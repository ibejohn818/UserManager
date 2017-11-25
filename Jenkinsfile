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

        stage("Build App") {
            sh "docker build -f Dockerfile-jenkins -t ${env.BUILD_ID}/user-manager ."
        }

        stage("Run Tests") {
            sh "docker run ${env.BUILD_ID}/user-manager"
            currentBuild.result = "SUCCESS"
        }

    } catch(Exception err) {
        currentBuild.result = "FAILURE"
    } finally {

    }
}
