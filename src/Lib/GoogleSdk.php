<?php 

namespace UserManager\Lib;

use Cake\Error\FatalErrorException;

class GoogleSdk {

    private $_client = false;

    public function __construct($verifyConfig = true) {

        if(!$verifyConfig) {
            return $this;
        }

        if(!$this->isSdkLoaded()) {
            throw new FatalErrorException("You must have the Google PHP SDK in scope. Prefered method of installation is to use Composer");
        }

        if(!$this->isClientConfigured()) {
            throw new FatalErrorException("You must configure the Google SDK inside UserManager\Bootstrap.php");
        }

        if(!$this->isRedirectConfigured()) {
            throw new FatalErrorException("You must have the Google Client Redirect URL configured in UserManager\Bootstrap.php and it MUST match configuration in Google API Console");
        }

        return $this;

    }

    private function isSdkLoaded() {
         
         if(!class_exists("Google_Client")) {
            return false;
        } 

        return true;
    }

    private function isClientConfigured() {
        if(!defined("GOOGLE_CLIENT_ID") || !defined("GOOGLE_CLIENT_SECRET")) {
            return false;
        }

        return true;
    }

    private function isRedirectConfigured() {
        if(!defined("GOOGLE_CLIENT_REDIRECT_URL")) {
            return false;
        }

        return true;
    }

    public function isGoogleLoginConfigured() {

        if(!$this->isSdkLoaded()) {

            return false;
        }

        if(!$this->isClientConfigured()) {
            
            return false;
        }

        if(!$this->isRedirectConfigured()) {
            return false;
        }

        return true;

    }


    public function returnLoginUrl() {

        $client = $this->client();

        $redirect = $authUrl = $client->createAuthUrl();

        return $redirect;

    }

    public function client() {

        if(!$this->_client) {
            $client = new \Google_Client();
            $client->setClientId(GOOGLE_CLIENT_ID);
            $client->setClientSecret(GOOGLE_CLIENT_SECRET);
            $client->setRedirectUri(GOOGLE_CLIENT_REDIRECT_URL);
            $client->setScopes(GOOGLE_CLIENT_SCOPES);
            $this->_client = $client;
        }

        return $this->_client;
    }

    public function handleLoginRedirect(array $params = []) {
        
        $client = $this->client();

        $client->authenticate($params['code']);

        $token = $client->getAccessToken();

        $client->setAccessToken($token);

        $token_data = $client->verifyIdToken()->getAttributes();

        $oauth = new \Google_Service_Oauth2($client);

        $user = $oauth->userinfo->get();
        
        return ['user'=>$user,'token'=>$token];
    }


}