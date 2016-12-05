<?php

namespace UserManager\Lib;

use UserManager\Config\Config;
use Cake\Network\Http\Client;
use Cake\Cache\Cache;

class GithubSdk
{

	protected static $token_url = "https://github.com/login/oauth/access_token";
	protected static $auth_url	= "https://github.com/login/oauth/authorize";

	protected $accessToken = null;
	protected $personalToken = null;

	protected $cacheConfig = true;

	public function __construct()
	{

		$cacheConfig = Config::get("githubApiCacheConfig");

		if(strlen($cacheConfig)>0) {
			$this->cacheConfig = $cacheConfig;
		}

	}

	/**
	 * Return a github object using OAuth 
	 * athentication
	 * @return \UserManager\Lib\GithubSdk
	 */
	public static function oauth() {

		$args = func_get_args();

		if(
			isset($args[0]) &&
			($args[0] instanceof \UserManager\Model\Entity\UserAccount)
		) {

		} elseif(
			isset($args[0]) &&
			($args[0] instanceof \UserManager\Model\Entity\UserAccountForiegnCredential)
		) {

		} elseif($args[0]) {
			$self = new Self();
			$self->setAccessToken($args[0]);
			return $self;
		}

	}

	/**
	 * Return a GithubSdk object using
	 * Personal Auth token authentication
	 * @return \UserManager\Lib\GithubSdk
	 */
	public static function personalToken($token)
	{

		$sdk = new self();

		$sdk->personalToken = $token;

		return $sdk;

	}


	public function authUrl()
	{

		$query = [
			'client_id'=>Config::get("githubClientId"),
			'redirect_url'=>$_SERVER['HTTP_HOST'].Config::get("githubRedirectUrl"),
			'scope'=>Config::get("githubApiScopes")
		];

		$query = http_build_query($query);

		$url = static::$auth_url."?{$query}";

		return $url;

	}

	public function getToken(\Cake\Network\Request $request)
	{

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


	public function get($endpoint,$data = [],$options = [],$cache = true)
	{

		if($this->cacheConfig && $cache) {
			$token = md5(serialize(func_get_args()).$this->personalToken.$this->accessToken);
			$cached = Cache::read($token,$this->cacheConfig);
		} else {
			$cache = false;
			$cached = false;
		}

		$client = new Client();

		if($this->accessToken) {
			$options['headers']['Authorization'] = "Bearer {$this->accessToken}";
		} elseif($this->personalToken) {
			$options['headers']['Authorization'] = "token {$this->personalToken}";
		}

		if($this->cacheConfig && $cache && $cached) {
			$options['headers']['If-None-Match'] = $cached['etag'];
			if(isset($cached['modified'])) {
				$options['headers']['If-Modified-Since'] = $cached['modified'];
			}
		}

		$qs = "";

		if(count($data)>0) {
			$qs = "?".http_build_query($data);
		}


		$res = $client->get("https://api.github.com{$endpoint}{$qs}",[],$options);

		if($res->code == 304) {
			return $cached['result'];
		}

		$result = [];

		$body = $res->body();

		$json = json_decode($body,true);

		$result['content'] = $json;

		$result['headers'] = $res->headers;

		if(($pagination = $this->parsePaginationHeader($result['headers'])) !== false) {
			$result['pagination'] = $pagination;
		}

		if($this->cacheConfig && $cache) {
			$cached = [
				'etag'=>$res->headers['Etag'],
				'result'=>$result
			];

			if(isset($res->headers['Last-Modified'])) {
				$cached['modified'] = $res->headers['Last-Modified'];
			}

			Cache::write($token,$cached,$this->cacheConfig);
		}

		return $result;

	}

	public function setAccessToken($token)
	{

		$this->accessToken = $token;

	}

	public function getAccessToken()
	{

		return	$this->accessToken;

	}


	private function parsePaginationHeader($headers)
	{

		if(!isset($headers['Link'])) {
			return false;
		}

		$linkParts = explode(",",$headers['Link']);

		$links = [];

		foreach($linkParts as $k=>$v) {

			preg_match('/(rel=)(")(.*)(")/',$v,$key);
			preg_match('/(<)(.*)(>)/',$v,$link);
			$links[$key[3]] = $link[2];

		}

		if(isset($links['last'])) {

			preg_match('/(&|\?)(page=)([0-9]{1,})/',$links['last'],$page);
			$links['total_pages'] = $page[3];

		} elseif(isset($links['first']) && isset($links['prev']) && !isset($links['last'])) {

			preg_match('/(&|\?)(page=)([0-9]{1,})/',$links['prev'],$page);
			$links['total_pages'] = $page[3]+1;

		}

		return $links;

	}
}
