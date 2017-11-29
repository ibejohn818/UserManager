#!/usr/bin/env groovy

import hudson.model.*
import hudson.EnvVars


node {

    try {

        stage("Stage Repo") {
            echo "Checkout repo"
            checkout scm
        }

        stage("Pull Docker Image") {
            sh "docker pull ibejohn818/php:php71w-build"
        }

        stage("Build App") {
            sh "docker run --rm -v ${env.WORKSPACE}:/code -w /code ibejohn818/php:php71w-build /bin/bash -c '/usr/bin/composer update --no-interaction && /usr/bin/composer install --no-interaction'"
        }

        stage("Run Tests") {
            sh "docker run --rm -v ${env.WORKSPACE}:/code -w /code ibejohn818/php:php71w-build /bin/bash -c './vendor/bin/phpunit tests'"
            currentBuild.result = "SUCCESS"
        }

    } catch(Exception err) {
        currentBuild.result = "FAILURE"
    } finally {

    }
}
