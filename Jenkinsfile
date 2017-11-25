#!/usr/bin/env groovy

import groovy.json.JsonOutput
import hudson.model.*
import hudson.EnvVars


node {

    try {

        def pwd = pwd()


        stage("Stage Repo") {
            sh "echo ${pwd}"
            checkout scm
        }

        stage("Run Tests") {
            echo sh(script: 'env|sort', returnStdout: true)
            currentBuild.result = "SUCCESS"
        }

    } catch(Exception err) {
        currentBuild.result = "FAILURE"
    } finally {

    }
}
