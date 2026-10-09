#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
command -v php >/dev/null
command -v rsync >/dev/null
rm -rf dist
mkdir -p dist/site
# Copy only tracked website files from this checkout. Never ship secrets,
# development documents, logs, archives, or pipeline configuration.
while IFS= read -r -d '' file; do
    case "$file" in
        config.php|config.example.php|*.log|*.zip|*.md|*.txt)
            case "$file" in robots.txt) ;; *) continue ;; esac ;;
    esac
    case "$file" in
        *.php|*.html|.htaccess|robots.txt|sitemap.xml|assets/*|includes/*)
            if [[ -L "$file" ]]; then
                echo "Refusing website symlink: $file" >&2
                exit 1
            fi
            rsync -R -- "$file" dist/site/
            ;;
    esac
done < <(git ls-files -z)
test -f dist/site/index.php
while IFS= read -r -d '' file; do
    php -l "$file"
done < <(find dist/site -type f -name '*.php' -print0)
tar -czf dist/site.tar.gz -C dist/site .
