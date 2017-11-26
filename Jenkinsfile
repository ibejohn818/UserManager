#!/usr/bin/env groovy

import hudson.model.*
import hudson.EnvVars


node {

    try {

        def img_tag = "${env.BRANCH_NAME.toLowerCase()}${env.BUILD_ID}"

        stage("Stage Repo") {
            echo "Checkout repo"
            checkout scm
        }

        stage("Build App") {
            sh "docker build -f Dockerfile-jenkins -t ${img_tag}/user-manager ."
        }

        stage("Run Tests") {
            sh "docker run ${img_tag}/user-manager /bin/bash -c '/code/vendor/bin/phpunit tests'"
            currentBuild.result = "SUCCESS"
        }

    } catch(Exception err) {
        currentBuild.result = "FAILURE"
    } finally {
        sh "docker image rm ${img_tag} -f"
    }
}
