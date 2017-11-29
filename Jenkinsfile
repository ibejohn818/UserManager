#!/usr/bin/env groovy

import hudson.model.*
import hudson.EnvVars


node {

    try {

        def $WDIR = "${env.PWD}"

        stage("Stage Repo") {
            echo "Checkout repo"
            checkout scm
        }

        stage("Pull Docker Image") {
            sh "docker pull ibejohn818/php:php71w-build"
        }

        stage("Build App") {
            sh "docker run -it --rm -v ${WDIR}:/code -w /code ibejohn818/php:php71w-build /bin/bash -c '/usr/bin/composer update --no-interaction && /usr/bin/composer install --no-interaction'"
        }

        stage("Run Tests") {
            sh "docker run -it --rm -v ${WDIR}:/code -w /code ibejohn818/php:php71w-build /bin/bash -c './vendor/bin/phpunit test'"
            currentBuild.result = "SUCCESS"
        }

    } catch(Exception err) {
        currentBuild.result = "FAILURE"
    } finally {

    }
}
