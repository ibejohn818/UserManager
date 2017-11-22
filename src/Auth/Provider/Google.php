<?php

namespace UserManager\Auth\Provider;

use Cake\Error\FatalErrorException;
use Cake\Core\Configure;
use UserManager\Auth\Provider\ProviderBase;
use Cake\Http\ServerRequest;
use Cake\Http\Response;

class Google extends ProviderBase
{

    private $_client = false;
    private $_oauthService = false;
	private $_token = false;

	public function getLoginUrl()
	{

        $client = $this->client();

        $redirect = $authUrl = $client->createAuthUrl();

        return $redirect;

    }

    public function setClient(\Google_Client $client)
    {
        $this->_client = $client;
    }

	public function client()
	{

        if(!$this->_client) {
			$proto = "http";
			if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
				$proto = "https";
			}
			$redirect = "{$proto}://{$_SERVER['HTTP_HOST']}/user-manager/auth-callback/google";
            $client = new \Google_Client();
            $client->setClientId(Configure::read("UserManager.LoginProviders.Google.clientId"));
            $client->setClientSecret(Configure::read("UserManager.LoginProviders.Google.clientSecret"));
            $client->setRedirectUri($redirect);
            $client->setScopes(Configure::read("UserManager.LoginProviders.Google.clientScopes"));
            $this->setClient($client);
        }

        return $this->_client;
    }

    public function setOauthService(\Google_Service_Oauth2 $service)
    {
        $this->_oauthService = $service;
    }

    public function oauthService()
    {
        if(!$this->_oauthService) {
            $this->setOauthService(new \Google_Service_Oauth2($this->client()));
        }

        return $this->_oauthService;
    }

	public function handleLoginRedirect(array $params = [])
	{
        $client = $this->client();

        $client->authenticate($params['code']);

        $token = $client->getAccessToken();

        $client->setAccessToken($token);

        $user = $this->oauthService()->userinfo->get();

        return ['user'=>$user,'token'=>$token];
    }

	public function authenticate(ServerRequest $request, Response $response)
	{

		$googleData = $this->handleLoginRedirect($request->query);

		$conditions = [
			'provider'=>"google",
			'key_name'=>"id",
			'key_value'=>$googleData['user']->id
		];

		$ld = [];

		$ld[] = $this->UserAccountLoginProviderData->newEntity([
			'provider'=>'google',
			'key_name'=>"id",
			'key_value'=>$googleData['user']->id
		]);

		$ld[] = $this->UserAccountLoginProviderData->newEntity([
			'provider'=>'google',
			'key_name'=>"picture",
			'key_value'=>$googleData['user']->picture
		]);

		$ld[] = $this->UserAccountLoginProviderData->newEntity([
			'provider'=>'google',
			'key_name'=>"oauth_token",
			'key_value'=>$googleData['token']['access_token']
		]);

		$ua = $this->UserAccounts->newEntity([
            'email'=>$googleData['user']->email,
            'first_name'=>$googleData['user']->givenName,
            'last_name'=>$googleData['user']->familyName
        ]);

		$credentials = $this->UserAccountLoginProviderData
								->locateAccount($conditions,$ua,$ld);
        //die(pr($credentials));

		return $credentials;

	}


}
