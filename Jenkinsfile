pipeline {
    agent { label 'devqii-linux' }
    options {
        disableConcurrentBuilds()
        timeout(time: 15, unit: 'MINUTES')
        buildDiscarder(logRotator(numToKeepStr: '15'))
        skipDefaultCheckout(true)
        timestamps()
    }
    triggers {
        githubPush()
        pollSCM('H/5 * * * *')
    }
    parameters {
        string(name: 'DEPLOY_HOST', defaultValue: 'ftp.developer-village.com', description: 'GoDaddy FTP hostname (without ftp://)')
        string(name: 'DEPLOY_PORT', defaultValue: '21', description: 'FTP/explicit FTPS port')
        string(name: 'DEPLOY_PATH', defaultValue: '', description: 'Website directory as seen by FTP, e.g. /public_html or /')
        booleanParam(name: 'FTP_TLS', defaultValue: true, description: 'Use encrypted explicit FTPS; disable only for plain FTP hosting')
    }
    stages {
        stage('Checkout main') {
            steps {
                deleteDir()
                script {
                    def checkoutInfo = checkout scm
                    if (!(checkoutInfo.GIT_BRANCH in ['origin/main', 'main']) || env.CHANGE_ID) {
                        error('This production job must use origin/main and must not build pull requests.')
                    }
                }
            }
        }
        stage('Validate and package') {
            steps { sh 'bash scripts/package-site.sh' }
        }
        stage('Archive') {
            steps { archiveArtifacts artifacts: 'dist/site.tar.gz', fingerprint: true }
        }
        stage('Deploy to GoDaddy') {
            steps {
                withCredentials([
                    usernamePassword(credentialsId: 'godaddy-ftp', usernameVariable: 'DEPLOY_USER', passwordVariable: 'DEPLOY_PASSWORD')
                ]) {
                    sh 'bash scripts/deploy-site.sh'
                }
            }
        }
    }
}
