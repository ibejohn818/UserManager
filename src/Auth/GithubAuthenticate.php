<?php

namespace UserManager\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Event\Event;
use Cake\Event\EventManager;
use UserManager\Config\Config;
use UserManager\Lib\GithubSdk;
use Cake\ORM\TableRegistry;

class GithubAuthenticate extends BaseAuthenticate {



	public function authenticate(Request $request, Response $response) {

		$url = Config::get("githubRedirectUrl");

		if($request->here == $url && isset($_GET['code'])) {

			EventManager::instance(
							new Event(
								"UserManager.GithubAuthenticate.beforeAuthenticate",
								$this,
								compact(
									"request",
									"response"
								)
							));


			$sdk = new GithubSdk();

			$token = $sdk->getToken($request);

			if(!$token) {

				EventManager::instance()->dispatch(
							new Event(
								"UserManager.GithubAuthenticate.failed",
								$this,
								[
									'request'=>$request,
									'response'=>$request,
									'GithubSdk'=>$sdk
								]
							));
				return false;
			}

			$GithubUser = $sdk->get("/user");


			//locate the account
			$UserAccountForeignCredentials  = TableRegistry::get("UserManager.UserAccountForeignCredentials");
			$UserAccounts                   = TableRegistry::get("UserManager.UserAccounts");

			$nameArr = explode(" ",$GithubUser['name']);

			$first_name = "";
			$last_name = "";
			if(count($nameArr)<=0) {
				$first_name = $GithubUser['name'];
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

			$uac = $UserAccountForeignCredentials->newEntity([
									'service_name'=>'github',
									'param1'=>$GithubUser['id'],
									'param2'=>$GithubUser['login']
								]);
			$ua = $UserAccounts->newEntity([
									'email'=>$GithubUser['email'],
									'first_name'=>$first_name,
									'last_name'=>$last_name
								]);

			$credentials = $UserAccountForeignCredentials->locateAccount([
									'service_name'=>'github',
									'param1'=>$GithubUser['id']
								],$ua,$uac);

			EventManager::instance()->dispatch(
				new Event(
					"UserManager.GithubAuthenticate.success",
					$this,
					[
						'request'=>$request,
						'response'=>$request,
						'GithubSdk'=>$sdk,
						'GithubUser'=>&$GithubUser,
						'user'=>&$credentials
					]
				));


			return $credentials;

		}


	}



}
