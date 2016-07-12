<?php

namespace UserManager\Lib;

use Cake\Network\Request;
use Cake\Network\Http\Client;
use UserManager\Config\Config;

/**
 * Twitter API Helper Class
 * This class contains methods to complete the OAuth V1.0 request cycle
 * Once the access Token/Secret are obtained, CakePHP Http\Client can
 * handle making the requests to the secure endpoints with the obtained
 * Access Token/Secret
 *
 * The OAuth operations this class handles that are outside of the
 * scope of the Http\Client are
 *  - Obtain the Requests Token/Secret
 *  - Obtain the Access Token/Secret
 *
 */

class TwitterSdk {


	protected $_request;

	protected $_requestTokenUrl = "https://api.twitter.com/oauth/request_token";
	protected $_authenticateUrl = "https://api.twitter.com/oauth/authenticate";
	protected $_accessTokenUrl  = "https://api.twitter.com/oauth/access_token";
	protected $_apiEndpoint		= "https://api.twitter.com/1.1";

	protected $_oauthToken = null;
	protected $_oauthSecret = null;
	protected $_oauthVerifier = null;

	protected $_requestSessionKey = "Twitter.OAuthReqeust";
	protected $_accessSessionKey  = "Twitter.OAuthAccess";

	public function __construct(Request $req, $accessToken = false, $accessSecret = false)  {

		$this->_request = $req;

		if($accessToken) {
			$this->_accessToken = $accessToken;
		}

		if($accessSecret) {
			$this->_accessSecret = $accessSecret;
		}

		if($accessToken && $accessSecret) {

			$this->_oauthToken = $accessToken;
			$this->_oauthSecret = $accessSecret;

		} else if($this->_request->session()->check($this->_requestSessionKey)) {
			$this->_oauthToken = $this->_request->session()->read("{$this->_requestSessionKey}.oauthToken");
			$this->_oauthSecret = $this->_request->session()->read("{$this->_requestSessionKey}.oauthSecret");
			$this->_request->session()->delete($this->_requestSessionKey);
		}

	}

	public function getLoginUrl() {


		if(!($tokens = $this->getRequestTokens())) {
			return false;
		}

		$this->_oauthToken = $tokens['oauth_token'];
		$this->_oauthSecret = $tokens['oauth_token_secret'];

		$this->_request->session()->write($this->_requestSessionKey,[
			'oauthToken'=>$tokens['oauth_token'],
			'oauthSecret'=>$tokens['oauth_token_secret']
		]);



		$query = [
			'oauth_token'=>$this->_oauthToken,
		];

		$qs = http_build_query($query);

		$url = $this->_authenticateUrl."?{$qs}";

		return $url;
	}

	protected function getAccessToken($verifier) {

		$url = $this->_accessTokenUrl;

		$data['oauth_verifier'] = $verifier;

		$oauthHeader = $this->buildOAuthHeader($url,"POST",$data);

		$options['headers']['Authorization'] = $oauthHeader;

		$client = new Client();

		$res = $client->post($url,$data,$options);

		if($res->code!=200) {
			return false;
		}

		parse_str($res->body(),$params);

		return $params;

	}

	public function completeAuthentication($verifier) {

		$params = $this->getAccessToken($verifier);

		$this->_oauthToken = $params['oauth_token'];
		$this->_oauthSecret = $params['oauth_token_secret'];

		$user_id = $params['user_id'];
		$username = $params['screen_name'];

		$client = new Client();

		$user = $this->get("/account/verify_credentials");

		if(!isset($user['email'])) {
			$user['email'] = $user['screen_name']."@twitter.login.com";
		}

		$user['oauth_token'] = $this->_oauthToken;
		$user['oauth_secret'] = $this->_oauthSecret;

		return $user;

	}

	public function get($endPoint,$data = [], $options = []) {

		$options['auth'] = $this->httpClientAuth();

		$client = new Client();

		$res = $client->get($this->getEndpoint($endPoint),$data,$options);

		if($res->code!=200) {
			return false;
		}

		return json_decode($res->body(),true);

	}

	public function getEndpoint($uri) {

		return $this->_apiEndpoint."{$uri}.json";

	}

	public function httpClientAuth() {

		$auth = [
			'type'=>'oauth',
			'consumerKey'=>Config::get("twitterConsumerKey"),
			'consumerSecret'=>Config::get("twitterConsumerSecret"),
			'token'=>$this->_oauthToken,
			'tokenSecret'=>$this->_oauthSecret
		];

		return $auth;

	}

	protected function getRequestTokens() {

		$url = $this->_requestTokenUrl;

		$oauthParams = $this->buildOAuthHeader($url,"POST");

		$client = new \Cake\Network\Http\Client();

		$options['headers']['Authorization'] = $oauthParams;

		$res = $client->post($url,[],$options);

		if($res->code != 200) {
			return false;
		}

		parse_str($res->body(),$params);

		return $params;
	}


	protected function buildRequestTokenHeader() {

		$params = [
			'oauth_nonce'=>(sha1(mt_rand(1000,99999).microtime())),
			'oauth_timestamp'=>time(),
			'oauth_signature_method'=>'HMAC-SHA1',
			'oauth_consumer_key'=>Config::get("twitterConsumerKey"),
			'oauth_version'=>'1.0'
		];

		$keys = $this->_encode(array_keys($params));
		$values = $this->_encode(array_values($params));
		$params = array_combine($keys, $values);
		uksort($params, 'strcmp');

		$base = [];

		foreach($params as $k=>$v) {
			$base[] = $this->_encode($k)."=".$this->_encode($v);
		}

		$base = implode("&",$base);

		$base = "POST&".$this->_encode($this->_requestTokenUrl)."&".$this->_encode($base);

		$secret = $this->_encode(Config::get("twitterConsumerSecret"))."&";

		$params['oauth_signature'] = $this->_encode(base64_encode(hash_hmac("sha1",$base,$secret,true)));

		$header = [];

		foreach($params as $k=>$v) {
			$header[] = $k.'="'.$v.'"';
		}

		$header = implode(",",$header);

		return "OAuth {$header}";

	}

	protected function buildOAuthHeader($url,$method,$data = []) {

		$params = [
			'oauth_nonce'=>(sha1(mt_rand(1000,99999).microtime())),
			'oauth_timestamp'=>time(),
			'oauth_signature_method'=>'HMAC-SHA1',
			'oauth_consumer_key'=>Config::get("twitterConsumerKey"),
			'oauth_version'=>'1.0'
		];

		//check if we have an oauth/Access Token
		if($this->_oauthToken) {
			$params['oauth_token'] = $this->_oauthToken;
		}

		$params = array_merge($params,$data);

		$keys = $this->_encode(array_keys($params));
		$values = $this->_encode(array_values($params));
		$params = array_combine($keys, $values);
		uksort($params, 'strcmp');

		$base = [];

		foreach($params as $k=>$v) {
			$base[] = $this->_encode($k)."=".$this->_encode($v);
		}

		$base = implode("&",$base);

		$base = "{$method}&".$this->_encode($url)."&".$this->_encode($base);

		$secret = $this->_encode(Config::get("twitterConsumerSecret"))."&";

		//check if we have an oauth secret to add to the hashing key
		if($this->_oauthSecret) {
			$secret .= $this->_encode($this->_oauthSecret);
		}

		$params['oauth_signature'] = $this->_encode(base64_encode(hash_hmac("sha1",$base,$secret,true)));

		$header = [];

		foreach($params as $k=>$v) {
			$header[] = $k.'="'.$v.'"';
		}

		$header = implode(",",$header);

		return "OAuth {$header}";

	}

	protected function _encode($value) {

		if(is_array($value)) {
			return array_map([$this,"_encode"],$value);
		} else if(is_scalar($value)) {
			return str_ireplace(
				'+',
				' ',
				str_ireplace('%7E', '~', rawurlencode($value))
			);
		} else {
			return '';
		}
    }



}
