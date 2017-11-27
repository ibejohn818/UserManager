<?php

namespace UserManager\Auth\Provider;

use UserManager\Auth\Provider\ProviderBase;
use Cake\Network\Http\Client;
use Cake\Core\Configure;
use Cake\Http\ServerRequest;
use Cake\Http\Response;
use Cake\Core\InstanceConfigTrait;

class Github extends ProviderBase
{

    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'cacheAdapter'=>'\Cake\Cache\Cache'
    ];

    protected $cacheAdapter = null;

	protected static $token_url = "https://github.com/login/oauth/access_token";
	protected static $auth_url	= "https://github.com/login/oauth/authorize";

	protected $accessToken = null;
	protected $personalToken = null;

	protected $cacheConfig = true;
    /**
     */
    protected $_httpClient;

	public function __construct(array $config = [])
	{
		$cacheConfig = Configure::read("UserManager.LoginProviders.Github.cacheConfig");

		if(strlen($cacheConfig)>0) {
			$this->cacheConfig = $cacheConfig;
		}

        $this->setConfig($config);

        $this->cacheAdapter = $this->getConfig("cacheAdapter");

		parent::__construct();

	}

    /**
     * HttpClient getter/setter
     * @param \Cake\Network\Http\Client $client
     * @return \Cake\Network\Http\Client
     */
    public function httpClient(Client $client = null)
    {

        if(!is_null($client)) {
            $this->_httpClient = $client;
        } elseif(is_null($this->_httpClient)) {
            $this->_httpClient = new \Cake\Network\Http\Client();
        }

        return $this->_httpClient;

    }

    public function accessToken(string $token = null)
    {

        if(!is_null($token)) {
            $this->accessToken = $token;
        }

        return $this->accessToken;

    }

    /**
     * {@inheritdoc}
     */
	public function getLoginUrl()
	{

        $proto = "http://";

        if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
            $proto = "https://";
        }

		$query = [
			'client_id'=>Configure::read("UserManager.LoginProviders.Github.clientId"),
			'redirect_url'=>"{$proto}{$_SERVER['HTTP_HOST']}/user-manager/auth-callback/github",
			'scope'=>Configure::read("UserManager.LoginProviders.Github.apiScopes")
		];

		$query = http_build_query($query);

		$url = static::$auth_url."?{$query}";

		return $url;

	}

    /**
     * {@inheritdoc}
     */
	public function authenticate(ServerRequest $request, Response $res)
	{

			$token = $this->getToken($request);

			if(!$token) {
				return false;
			}

			$GithubUser = $this->get("/user",[],[],false);

			$nameArr = explode(" ",$GithubUser['content']['name']);

			$first_name = "";
			$last_name = "";
			if(count($nameArr)<=0) {
				$first_name = $GithubUser['content']['name'];
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
				'provider'=>'github',
				'key_name'=>"id",
				'key_value'=>$GithubUser['content']['id']
			];

			$ld = [];

			$ld[] = $this->UserAccountLoginProviderData->newEntity([
				'provider'=>'github',
				'key_name'=>"id",
				'key_value'=>$GithubUser['content']['id']
			]);

			$ld[] = $this->UserAccountLoginProviderData->newEntity([
				'provider'=>'github',
				'key_name'=>"username",
				'key_value'=>$GithubUser['content']['login']
			]);

			$ld[] = $this->UserAccountLoginProviderData->newEntity([
				'provider'=>'github',
				'key_name'=>"oauth_token",
				'key_value'=>$this->accessToken()
			]);

			$ua = $this->UserAccounts->newEntity([
                    'email'=>$GithubUser['content']['email'],
                    'first_name'=>$first_name,
                    'last_name'=>$last_name
                ]);

			$credentials = $this->UserAccountLoginProviderData
									->locateAccount($conditions,$ua,$ld);

			return $credentials;

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


	public function getToken(\Cake\Network\Request $request)
	{

		$code =  $request->query("code");

		$query = [
			'client_id'=>Configure::read("UserManager.LoginProviders.Github.clientId"),
			'client_secret'=>Configure::read("UserManager.LoginProviders.Github.clientSecret"),
			'scope'=>Configure::read("UserManager.LoginProviders.Github.apiScopes"),
			'code'=>$code,
			'accept'=>'json'
		];

		$client = $this->httpClient();

		$res = $client->post(static::$token_url,$query);

		$query = $res->body();

		parse_str($query,$vars);

		if(!isset($vars['access_token'])) {
			return false;
		}

		$token = $vars['access_token'];

		return $this->accessToken($token);

	}


	public function get($endpoint,$data = [],$options = [],$cache = true)
	{

		if($this->cacheConfig && $cache) {
			$token = md5(serialize(func_get_args()).$this->personalToken.$this->accessToken);
			$cached = $this->cacheAdapter::read($token,$this->cacheConfig);
		} else {
			$cache = false;
			$cached = false;
		}

		$client = $this->httpClient();

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

			$this->cacheAdapter::write($token,$cached,$this->cacheConfig);
		}

		return $result;

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
