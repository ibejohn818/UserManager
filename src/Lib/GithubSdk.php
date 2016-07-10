<?php

namespace UserManager\Lib;

use UserManager\Config\Config;
use Cake\Network\Http\Client;

class GithubSdk {

	protected static $token_url = "https://github.com/login/oauth/access_token";
	protected static $auth_url	= "https://github.com/login/oauth/authorize";

	protected $_accessToken = null;

	public function __constuct() {

	}

	public function authUrl() {

		$query = [
			'client_id'=>Config::get("githubClientId"),
			'redirect_url'=>$_SERVER['HTTP_HOST'].Config::get("githubRedirectUrl"),
			'scope'=>Config::get("githubApiScopes")
		];

		$query = http_build_query($query);

		$url = static::$auth_url."?{$query}";

		return $url;

	}

	public function getToken(\Cake\Network\Request $request) {

		$code =  $request->query("code");

		$query = [
			'client_id'=>Config::get("githubClientId"),
			'client_secret'=>Config::get("githubClientSecret"),
			'scope'=>Config::get("githubApiScopes"),
			'code'=>$code,
			'accept'=>'json'
		];

		$client = new Client();

		$res = $client->post(static::$token_url,$query);

		$query = $res->body();

		parse_str($query,$vars);

		if(!isset($vars['access_token'])) {
			return false;
		}

		$token = $vars['access_token'];

		$this->setAccessToken($token);

		return $this->getAccessToken();

	}


	public function get($endpoint,$data = [],$options = []) {

		$client = new Client();

		$options['headers']['Authorization'] = 'Bearer ' . $this->_accessToken;

		$res = $client->get("https://api.github.com{$endpoint}",[],$options);

		$body = $res->body();

		$json = json_decode($body,true);

		return $json;

	}

	public function setAccessToken($token) {

		$this->_accessToken = $token;

	}

	public function getAccessToken() {

		return	$this->_accessToken;

	}


}
