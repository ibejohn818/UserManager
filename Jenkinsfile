#!/usr/bin/env groovy

import groovy.json.JsonOutput
import hudson.model.*
import hudson.EnvVars


node {

    try {

        def pwd = pwd()


        stage("Stage Repo") {
            echo "Checkout repo"
            checkout scm
        }

        stage("Composer Build") {
            sh "docker pull ibejohn818/php:php71w-build"
            sh "docker run --rm -it -v ${pwd}:/code -w /code ibejohn818/php:php71w-build /bin/bash -c '/usr/bin/composer composer update --no-interaction && /usr/bin/composer composer install --no-interaction'" 
        }

        stage("Run Tests") {
            sh "docker run --rm -it -v ${pwd}:/code -w /code ibejohn818/php:php71w-build /bin/bach -c 'vendor/bin/phpunit tests'"
            currentBuild.result = "SUCCESS"
        }

    } catch(Exception err) {
        currentBuild.result = "FAILURE"
    } finally {

    }
}
