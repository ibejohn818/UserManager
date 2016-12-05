<?php

namespace UserManager\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Event\EventManager;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use UserManager\Config\Config;
use UserManager\Lib\FacebookSdk;

class FacebookAuthenticate extends BaseAuthenticate 
{


	public function authenticate(Request $request, Response $response) 
	{

		$url = Config::get("facebookApiRedirectUrl");

		if($request->here == $url && isset($_GET['code'])) {

			$fb  = new FacebookSdk();

			$token = $fb->getLoginToken($request);

			if(!$token) {
				return false;
			}

			$em = EventManager::instance();

			$me = $fb->get("/me",['fields'=>'id,name,email']);

			if(!$me) {

				$event = new Event("UserManager.Authenticate.failed",$this,[
					'request'=>$request,
					'response'=>$response,
					'FacebookSdk'=>$fb
				]);

				$em->dispatch($event);

				return false;
			}


			//locate the account
			$UserAccountForeignCredentials  = TableRegistry::get("UserManager.UserAccountForeignCredentials");
			$UserAccounts                   = TableRegistry::get("UserManager.UserAccounts");

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


			$uac = $UserAccountForeignCredentials->newEntity([
									'service_name'=>'facebook',
									'param1'=>$me['id'],
								]);
			$ua = $UserAccounts->newEntity([
									'email'=>$me['email'],
									'first_name'=>$first_name,
									'last_name'=>$last_name
								]);
			//var_dump($me);
			//var_dump($ua);
			//var_dump($uac);
			//die();
			$credentials = $UserAccountForeignCredentials->locateAccount([
									'service_name'=>'facebook',
									'param1'=>$me['id']
								],$ua,$uac);


			return $credentials;

		}

		return false;

	}



}
