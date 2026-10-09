# GitHub → local Jenkins → GoDaddy

The pipeline checks PHP syntax, packages tracked website files, archives the
release in Jenkins, then uploads it through passive FTP. Explicit FTPS with
certificate verification is enabled by default. SSH access is not needed.

## 1. Connect GitHub

The Git remote `origin` is `https://github.com/okoyejj/devqii.git`. Commit the pipeline files,
website changes and portraits: untracked files are not packaged. Never commit
passwords or production config.php.

Every update to main, including direct pushes and merges, triggers deployment.
The initial/manual build also deploys. Polling may combine multiple pushes into
one build of the latest main; use webhooks for prompt builds.

## 2. Prepare Jenkins locally

A portable Jenkins installation is available in the ignored `.jenkins-local/`
directory. Start it with `bash scripts/start-jenkins-local.sh` and open
`http://localhost:8080/`. The login is `admin`; its generated password is stored
in `.jenkins-local/admin-password`. This directory contains credentials and
runtime data and must remain private and excluded from Git. Jenkins listens
only on localhost and must stay running for polling and builds to work.

The configured job is `devqii-production`. The FTP credential has ID
`godaddy-ftp`. A working FTP hostname and the confirmed deployment directory
must be configured before a production upload can succeed.

Use a Linux, WSL, or Linux Docker **agent** labelled `devqii-linux` with Bash,
Git, PHP CLI (matching your hosting version), tar, rsync, Python 3, and system CA certificates.
For Windows Jenkins, connect a Linux/WSL agent; these scripts use Bash, not bat.
For Docker, install the tools inside the agent image and persist Jenkins data.

Install Pipeline (including Declarative), Git, GitHub, Credentials Binding, and
Timestamper plugins. Create one **Pipeline** job, named `devqii-production`:

1. Definition: **Pipeline script from SCM**; SCM: **Git**.
2. Repository URL: `https://github.com/okoyejj/devqii.git`, with read-only checkout credentials if private.
3. Branch specifier: **`*/main`**. Script path: **`Jenkinsfile`**.
4. Do not expose production credentials to jobs building untrusted branches/PRs.

Use one production job per target: concurrency is disabled within this job.
The pipeline refuses checkouts whose branch is not main. The first build
registers its triggers and parameters; it will stop at deployment until the
credentials and target parameters are configured. Then use **Build with Parameters**.

Reference: [Jenkins Pipeline syntax](https://www.jenkins.io/doc/book/pipeline/syntax/).

## 3. Configure GoDaddy FTP credentials

In Jenkins Credentials, create a **Username with password** credential:

- ID: `godaddy-ftp`
- Username: `codex@devqii.co.uk`
- Password: the FTP password, entered directly in Jenkins.

The password is read from the process environment during deployment. It is never
stored in source files or passed as a command-line argument.

After the first build registers job parameters, configure their defaults so
webhook and polling builds use the correct target automatically:

| Parameter | Value |
| --- | --- |
| `DEPLOY_HOST` | `ftp.developer-village.com` |
| `DEPLOY_PORT` | `21` |
| `DEPLOY_PATH` | Confirmed existing website directory as seen by FTP, such as `/public_html`, or `/` if this account is restricted to the website root |
| `FTP_TLS` | `true` for encrypted explicit FTPS |

The directory must be confirmed before deployment: this account may serve
multiple websites, and the correct DEVQII folder must be selected. The pipeline
requires the directory to exist and never guesses or creates the target root.
FTPS certificate verification stays enabled. Only disable FTP_TLS if your
provider supports plain FTP only; that sends credentials and files unencrypted.
Implicit FTPS (port 990) and SFTP are not supported by this script.

All packaged files are uploaded each time, including .htaccess. Existing
server-only configuration, mail libraries and uploads are preserved. Removed
source files require deliberate server cleanup. Uploads are not atomic and can
leave a partial release if interrupted. Back up the site before the first run.
Jenkins retains release archives for manual recovery. Automatic rollback and
post-deploy HTTP checks are not implemented.

Reference: [Python FTP/FTPS client](https://docs.python.org/3/library/ftplib.html).

## 4. Trigger local Jenkins

The pipeline polls GitHub every five minutes, building only when SCM changes.
This works while Jenkins runs locally with outbound internet access. Keep the
machine and agent running; Jenkins cannot deploy while they are asleep/offline.

For immediate webhook builds, Jenkins needs a stable public HTTPS endpoint via
a tunnel or reverse proxy that forwards `/github-webhook/` to local Jenkins.
GitHub cannot reach `localhost`. Keep the administrative UI authenticated and
restrict public routing to the webhook endpoint. Configure webhook secret
validation in the Jenkins GitHub plugin and use the same secret in GitHub.

In GitHub repository **Settings → Webhooks**, add:

1. Payload URL: `https://YOUR_JENKINS_ENDPOINT/github-webhook/` (trailing slash).
2. Content type: `application/json`; matching secret; SSL verification enabled.
3. Events: **Just the push event**; activate it.

The GitHub plugin matches the repository and polls the job's configured main
branch. A push to another branch does not change this job's main checkout.
Polling remains a fallback for missed webhook deliveries.

Reference: [Jenkins GitHub plugin](https://plugins.jenkins.io/github/).

## 5. Verify the complete flow

Run `bash scripts/package-site.sh` locally to check packaging and PHP syntax.
Configure the job and run one build with the target parameters. Inspect its
stages, then check the live website and application form manually. Push a small
website change to main and verify GitHub webhook delivery (if enabled), Jenkins
build logs and the live result. Production deployment is only confirmed after
this real end-to-end test.
