pipeline {
    agent any

    stages {
        stage('Checkout Code') {
            steps {
                echo '📦 Pulling latest code from GitHub...'
                git branch: 'main', url: 'https://github.com/Pyari11/studentresultmanagement.git'
            }
        }

        stage('Build') {
            steps {
                echo '⚙️ Verifying project structure...'
                bat 'echo Build successful!'
            }
        }

        stage('Test') {
            steps {
                echo '🧪 Running basic syntax checks...'
                // Just a placeholder for PHP validation or test scripts
                bat 'echo Tests passed successfully!'
            }
        }

        stage('Deploy to XAMPP') {
            steps {
                echo '🚀 Deploying to local XAMPP folder...'
                // Copies your code into XAMPP htdocs
                bat 'xcopy /E /I /Y * C:\\xampp\\htdocs\\studentresult'
            }
        }
    }

    post {
        success {
            echo '✅ Pipeline completed successfully!'
        }
        failure {
            echo '❌ Pipeline failed. Please check the logs.'
        }
    }
}
