<?php

namespace UserManager\Auth;

use Cake\Error\FatalErrorException;
use Cake\Auth\BaseAuthenticate;
use Cake\Http\ServerRequest;
use Cake\Http\Response;
use Cake\Event\Event;
use Cake\Event\EventManager;
use UserManager\Event\AuthEvent;
use UserManager\Lib\GithubSdk;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Core\App;

class LoginProviderAuthenticate extends BaseAuthenticate
{


	public function authenticate(ServerRequest $request, Response $response)
	{

		$providers = $this->providers();

		foreach($providers as $p) {

			$enabled = 	Configure::read("UserManager.{$p}LoginEnable");

			$linkMatch = (Configure::read("UserManager.{$p}AuthRedirectUrl") ==
						$request->here);

			if($enabled && $linkMatch) {

				$provider = "\UserManager\Auth\Provider\\".$p;

				$provider = new $provider();

				if(!($provider instanceof \UserManager\Auth\Provider\ProviderBase)) {
					throw new FatalErrorException("Class: ".get_class($provider). "Not Instance of \UserManager\Auth\Provider\ProviderBase");
				}

				$credentials = $provider->authenticate($request, $response);

				if(!isset($credentials['id'])) {

					$event = new Event("UserManager.Authenticate.failed",$this,compact("provider"));

				} else {

					$event = new AuthEvent("UserManager.Authenticate.success", $this, $credentials, $provider);

				}

				EventManager::instance()->dispatch($event);

				return $credentials;

			}

		}

	}


	private function providers()
	{

		$path = App::path("Auth/Provider","UserManager");

		$p = [];

		foreach(scandir($path[0]) as $v)
		{
			if(in_array($v,['.','..']) 
				|| !preg_match('/\.php$/',$v) 
				|| preg_match('/ProviderBase/',$v)
			) {
				continue;
			}

			$p[] = preg_replace('/(.*)(\.php$)/','$1',$v);

		}

		return $p;

	}
}
