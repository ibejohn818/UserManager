<?php

namespace UserManager\Auth\Provider;

use Facebook\Facebook as FacebookSdk;
use Cake\Core\Configure;
use UserManager\Auth\Provider\ProviderBase;
use Cake\Http\ServerRequest;
use Cake\Http\Response;

class Facebook extends ProviderBase
{

	private $_sdk = false;
	protected static $token_url = "https://graph.facebook.com/v2.3/oauth/access_token";
	protected static $auth_url = "https://www.facebook.com/dialog/oauth";
	protected static $graph_url = "https://graph.facebook.com/v2.6";

	protected $_accessToken;

	protected $_error = [];

	public function client()
	{

		if(!$this->_sdk) {

			$this->_sdk = new FacebookSdk([
				'app_id' =>Configure::read("UserManager.FacebookId"),
				'app_secret' =>Configure::read("UserManager.FacebookSecret"),
				'default_graph_version' => 'v2.4',
			]);

		}

		return $this->_sdk;

	}


	public function authenticate(ServerRequest $request, Response $response)
	{

		$this->getLoginToken($request);

		if(!$this->getAccessToken()) {
			return false;
		}

		$me = $this->get("/me",['fields'=>'id,name,email']);

		if(!$me) {
			return false;
		}

		$nameArr = explode(" ",$me['name']);
		$first_name = "";
		$last_name = "";

		if(count($nameArr)<=0) {
			$first_name = $me['name'];
		} else {
			foreach($nameArr as $k=>$v) {
				if($k==0) {
					$first_name = $v;
				} else {
					$last_name = $v." ";
				}
			}

			$last_name = rtrim($last_name);
		}


		$conditions = [
			'provider'=>'facebook',
			'key_name'=>'id',
			'key_value'=>$me['id']
		];

		//var_dump($me);
		//var_dump($ua);
		//var_dump($uac);
		//die();

		$ld = [];

		$ld[] = $this->UserAccountLoginProviderData->newEntity([
			'provider'=>'facebook',
			'key_name'=>"id",
			'key_value'=>$me['id']
		]);

		$ua = $this->UserAccounts->newEntity([
								'email'=>$me['email'],
								'first_name'=>$first_name,
								'last_name'=>$last_name
							]);

		$credentials = $this->UserAccountLoginProviderData
								->locateAccount($conditions,$ua,$ld);

		return $credentials;

	}


	public function getLoginUrl()
	{

		$qs = [
			'client_id'=>Configure::read("UserManager.FacebookId"),
			'redirect_uri'=>"http://".$_SERVER['HTTP_HOST'].Configure::read("UserManager.FacebookAuthRedirectUrl"),
			'response_type'=>'code',
			'scope'=>Configure::read("UserManager.FacebookScopes")
		];

		$query = http_build_query($qs);

		$url = static::$auth_url."?{$query}";

		return $url;

	}

	public function getLoginToken(\Cake\Network\Request $req)
	{

		$code = $req->query("code");

		$qs = [
			'client_id'=>Configure::read("UserManager.FacebookId"),
			'client_secret'=>Configure::read("UserManager.FacebookSecret"),
			'redirect_uri'=>"http://".$_SERVER['HTTP_HOST'].Configure::read("UserManager.FacebookAuthRedirectUrl"),
			'scope'=>Configure::read("UserManager.FacebookScopes"),
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

	public function getAccessToken()
	{
		return $this->_accessToken;
	}


	public function setAccessToken($token)
	{
		$this->_accessToken = $token;
	}


	public function get($endPoint,$data = [], $options = [])
	{

		$client = new \Cake\Network\Http\Client();

		$token = $this->getAccessToken();

		$options['headers']['Authorization'] = 'Bearer '.$token;

		$res = $client->get(static::$graph_url.$endPoint,$data,$options);

		$json = json_decode($res->body(),true);

		if(isset($json['error'])) {
			$this->_error = $json;
			return false;
		}

		return $json;

	}

	public function getError()
	{
		return $this->_error;
	}


	public function handleLoginRedirect()
	{

		//$fb = $this->client();

		//$helper = $fb->getRedirectLoginHelper();
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

		//if (! isset($accessToken)) {
		//if ($helper->getError()) {
			//header('HTTP/1.0 401 Unauthorized');
			//echo "Error: " . $helper->getError() . "\n";
			//echo "Error Code: " . $helper->getErrorCode() . "\n";
			//echo "Error Reason: " . $helper->getErrorReason() . "\n";
			//echo "Error Description: " . $helper->getErrorDescription() . "\n";
		//} else {
			//header('HTTP/1.0 400 Bad Request');
			//echo 'Bad request';
		//}
		//exit;
		//}

		//// Logged in
		//echo '<h3>Access Token</h3>';
		//var_dump($accessToken->getValue());

		//// The OAuth 2.0 client handler helps us manage access tokens
		//$oAuth2Client = $fb->getOAuth2Client();

		//// Get the access token metadata from /debug_token
		//$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		//echo '<h3>Metadata</h3>';
		//var_dump($tokenMetadata);

		//// Validation (these will throw FacebookSDKException's when they fail)
		//$tokenMetadata->validateAppId(Configure::read("UserManager.FacebookId")); // Replace {app-id} with your app id
		//// If you know the user ID this access token belongs to, you can validate it here
		////$tokenMetadata->validateUserId('123');
		//$tokenMetadata->validateExpiration();

		//if (! $accessToken->isLongLived()) {
		//// Exchanges a short-lived access token for a long-lived one
		//try {
			//$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		//} catch (Facebook\Exceptions\FacebookSDKException $e) {
			//echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
			//exit;
		//}

		//echo '<h3>Long-lived</h3>';
		//var_dump($accessToken->getValue());
		//}

	}



}

