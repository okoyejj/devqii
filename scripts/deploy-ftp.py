#!/usr/bin/env python3
"""Upload the packaged site using Jenkins-bound FTP credentials."""
import ftplib
import os
from pathlib import Path
import re
import ssl
import sys


def settings():
    config = {}
    for name in ('DEPLOY_HOST', 'DEPLOY_PORT', 'DEPLOY_PATH', 'DEPLOY_USER', 'DEPLOY_PASSWORD'):
        value = os.environ.get(name, '')
        if not value or any(char in value for char in '\r\n\0'):
            raise ValueError(f'Set a valid {name} in Jenkins')
        config[name] = value
    if not re.fullmatch(r'[a-zA-Z0-9][a-zA-Z0-9.-]*', config['DEPLOY_HOST']):
        raise ValueError('DEPLOY_HOST must be a hostname or IPv4 address without ftp://')
    if not config['DEPLOY_PORT'].isdigit() or not 1 <= int(config['DEPLOY_PORT']) <= 65535:
        raise ValueError('DEPLOY_PORT must be between 1 and 65535')
    path = config['DEPLOY_PATH']
    if not path.startswith('/') or any(part in ('.', '..') for part in path.split('/')):
        raise ValueError('DEPLOY_PATH must be an absolute FTP directory without traversal')
    tls = os.environ.get('FTP_TLS', 'true').lower()
    if tls not in ('true', 'false'):
        raise ValueError('FTP_TLS must be true or false')
    config['tls'] = tls == 'true'
    return config


def deploy():
    config = settings()
    site = Path(__file__).resolve().parents[1] / 'dist' / 'site'
    if not (site / 'index.php').is_file():
        raise ValueError('Run scripts/package-site.sh before deployment')
    paths = sorted(site.rglob('*'))
    if any(path.is_symlink() for path in paths):
        raise ValueError('The release must not contain symbolic links')
    if any(any(c in str(p.relative_to(site)) for c in '\r\n\0') for p in paths):
        raise ValueError('The release contains an invalid FTP filename')
    ftp = ftplib.FTP_TLS(context=ssl.create_default_context(), timeout=60) if config['tls'] else ftplib.FTP(timeout=60)
    with ftp:
        ftp.connect(config['DEPLOY_HOST'], int(config['DEPLOY_PORT']))
        # FTP_TLS negotiates TLS before sending the login credentials.
        ftp.login(config['DEPLOY_USER'], config['DEPLOY_PASSWORD'])
        if config['tls']:
            ftp.prot_p()
        ftp.set_pasv(True)
        # Require the confirmed document root to exist; never guess or create it.
        ftp.cwd(config['DEPLOY_PATH'])
        for path in paths:
            relative = path.relative_to(site).as_posix()
            if path.is_dir():
                try:
                    ftp.mkd(relative)
                except ftplib.error_perm:
                    current = ftp.pwd()
                    ftp.cwd(relative)  # Ignore mkdir failure only if this directory exists.
                    ftp.cwd(current)
            elif path.is_file() and path.name != 'config.php' and path.suffix != '.log':
                with path.open('rb') as source:
                    ftp.storbinary(f'STOR {relative}', source)
                print(f'Uploaded {relative}', flush=True)
        ftp.quit()
    print('GoDaddy upload complete.', flush=True)


if __name__ == '__main__':
    try:
        deploy()
    except ValueError as error:
        print(str(error), file=sys.stderr)
        sys.exit(1)
    except (OSError, ftplib.Error) as error:
        # Avoid echoing server-provided text that could contain credentials.
        print(f'FTP deployment failed ({type(error).__name__}). Check connectivity, TLS, credentials and directory permissions.', file=sys.stderr)
        sys.exit(1)
