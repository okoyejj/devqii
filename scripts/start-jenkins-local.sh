#!/usr/bin/env bash
set -euo pipefail
project_dir=$(cd "$(dirname "$0")/.." && pwd)
export JENKINS_HOME="$project_dir/.jenkins-local/home"
exec "$project_dir/.jenkins-local/runtime/java/bin/java" -Xms256m -Xmx1024m \
    -Djenkins.install.runSetupWizard=false \
    -jar "$project_dir/.jenkins-local/runtime/jenkins.war" \
    --httpListenAddress=127.0.0.1 --httpPort=8080
