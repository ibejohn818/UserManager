<?php

namespace UserManager\Lib;

use Facebook\Facebook;
use UserManager\Config\Config;

class FacebookSdk {

	private $_sdk = false;
	protected static $token_url = "https://graph.facebook.com/v2.3/oauth/access_token";
	protected static $auth_url = "https://www.facebook.com/dialog/oauth";
	protected static $graph_url = "https://graph.facebook.com/v2.6";

	protected $_accessToken;

	public function client() {

		if(!$this->_sdk) {

			$this->_sdk = new Facebook([
				'app_id' =>Config::get("facebookApiId"),
				'app_secret' =>Config::get("facebookApiSecret"),
				'default_graph_version' => 'v2.4',
			]);

		}

		return $this->_sdk;

	}

	public function getLoginUrl() {

		$qs = [
			'client_id'=>Config::get("facebookApiId"),
			'redirect_uri'=>"http://".$_SERVER['HTTP_HOST'].Config::get("facebookApiRedirectUrl"),
			'response_type'=>'code',
			'scope'=>Config::get("facebookApiScopes")
		];

		$query = http_build_query($qs);

		$url = static::$auth_url."?{$query}";

		return $url;

	}

	public function getLoginToken(\Cake\Network\Request $req) {

		$code = $req->query("code");

		$qs = [
			'client_id'=>Config::get("facebookApiId"),
			'client_secret'=>Config::get("facebookApiSecret"),
			'redirect_uri'=>"http://".$_SERVER['HTTP_HOST'].Config::get("facebookApiRedirectUrl"),
			'scope'=>Config::get("facebookApiScopes"),
			'code'=>$code
		];

		$query = http_build_query($qs);

		$client = new \Cake\Network\Http\Client();

		$res = $client->post(static::$token_url,$query);

		if($res->code!=200) {
			return false;
		}

		$body = $res->body();

		$json = json_decode($body,true);

		$this->setAccessToken($json['access_token']);

		return $this->getAccessToken();

	}

	public function getAccessToken() {
		return $this->_accessToken;
	}


	public function setAccessToken($token) {
		$this->_accessToken = $token;
	}


	public function apiGet($endPoint,$data = [], $options = []) {

		$client = new \Cake\Network\Http\Client();

		$token = $this->getAccessToken();

		$options['headers']['Authorization'] = 'Bearer '.$token;

		$res = $client->get(static::$graph_url.$endPoint,$data,$options);

		$json = json_decode($res->body(),true);

		return $json;

	}

	public function _getLoginUrl() {

		$fb = $this->client();

		$helper = $fb->getRedirectLoginHelper();

		$permissions = Config::get("facebookApiScopes"); // Optional permissions
		$loginUrl = $helper->getLoginUrl(Config::facebookLoginRedirectUrl(), $permissions);

		return $loginUrl;

	}


	public function handleLoginRedirect() {

		$fb = $this->client();

		$helper = $fb->getRedirectLoginHelper();
//die(var_dump($helper));
//try {
  //$accessToken = $helper->getAccessToken();
//} catch(Facebook\Exceptions\FacebookResponseException $e) {
  //// When Graph returns an error
  //echo 'Graph returned an error: ' . $e->getMessage();
  //exit;
//} catch(Facebook\Exceptions\FacebookSDKException $e) {
  //// When validation fails or other local issues
  //echo 'Facebook SDK returned an error: ' . $e->getMessage();
  //exit;
//}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo '<h3>Metadata</h3>';
var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId(Config::get("facebookApiId")); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

  echo '<h3>Long-lived</h3>';
  var_dump($accessToken->getValue());
}

	}



}

