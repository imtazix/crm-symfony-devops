pipeline {
    agent any

    environment {
        SONAR_HOST_URL = 'http://localhost:9000'
        SONAR_LOGIN = 'squ_3b87e461253f8d6c08a4a9dbd83ae2f69c1cfe17'
        DOCKER_IMAGE = 'mahdimaadhadh/crm-symfony-devops'
    }

    stages {
        stage('Checkout') {
            steps {
                git credentialsId: 'github-creds', url: 'https://github.com/imtazix/crm-symfony-devops.git', branch: 'main'
            }
        }

        stage('Composer install') {
            agent {
                docker {
                    image 'composer:2.5'
                    args '-v /var/run/docker.sock:/var/run/docker.sock'
                }
            }
            steps {
                sh 'composer install'
                sh 'php bin/console cache:clear || true'
            }
        }

        stage('Analyse SonarQube') {
            environment {
                PATH = "/opt/sonar-scanner/bin:$PATH"
            }
            steps {
                withSonarQubeEnv('SonarQube') {
                    sh '''
                        sonar-scanner \
                        -Dsonar.projectKey=crm-symfony-devops \
                        -Dsonar.sources=. \
                        -Dsonar.host.url=$SONAR_HOST_URL \
                        -Dsonar.login=$SONAR_LOGIN
                    '''
                }
            }
        }

        stage('Build Docker image') {
            steps {
                retry(3) {
                    timeout(time: 5, unit: 'MINUTES') {
                        sh 'docker build -t $DOCKER_IMAGE .'
                    }
                }
            }
        }

        stage('Push DockerHub') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'dockerhub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                    retry(2) {
                        sh '''
                            echo "$DOCKER_PASS" | docker login -u "$DOCKER_USER" --password-stdin
                            docker push $DOCKER_IMAGE
                        '''
                    }
                }
            }
        }

        stage('Préparer connexion SSH') {
            steps {
                sh '''
                    mkdir -p ~/.ssh
                    ssh-keyscan 10.0.2.15 >> ~/.ssh/known_hosts
                    chmod 600 ~/.ssh/id_rsa || true
                '''
            }
        }

        stage('Déploiement Ansible distant') {
            steps {
                sh '''
                    pwd
                    export ANSIBLE_HOST_KEY_CHECKING=False
                    ansible-playbook -i ansible/inventory.ini ansible/deploy.yml \
                      --private-key=/var/lib/jenkins/.ssh/id_rsa \
                      -u mehdi \
                      -e 'ansible_remote_tmp=/tmp/.ansible'
                '''
            }
        }
    }
}
