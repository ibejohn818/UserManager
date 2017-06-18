<?php

namespace UserManager\Auth\Provider;

use UserManager\Auth\Provider\ProviderBase;
use Cake\Http\ServerRequest;
use Cake\Http\Response;
use Cake\Core\Configure;

class Yahoo extends ProviderBase
{

	private $loginUrl = 'https://api.login.yahoo.com/oauth2/request_auth';
	private $tokenUrl = '';

	public function getLoginUrl()
	{

	    $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";


		$qs = [
			'client_id'=>Configure::read("UserManager.YahooClientId"),
			'response_type'=>'code',
			'redirect_uri'=>"{$proto}://{$_SERVER['HTTP_HOST']}".Configure::read("UserManager.YahooAuthRedirectUrl"),
			'scope'=>Configure::read("UserManager.YahooApiScopes")
		];

		$query = http_build_query($qs);

		return "{$this->loginUrl}?{$query}";


	}

	public function authenticate(ServerRequest $request, Response $response)
	{

	}

}
