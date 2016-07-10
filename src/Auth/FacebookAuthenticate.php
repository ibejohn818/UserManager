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

class FacebookAuthenticate extends BaseAuthenticate {


	public function authenticate(Request $request, Response $response) {

		$url = Config::get("facebookApiRedirectUrl");

		if($request->here == $url && isset($_GET['code'])) {

			$fb  = new FacebookSdk();

			$token = $fb->getLoginToken($request);

			if(!$token) {
				return false;
			}

			$me = $fb->apiGet("/me",['fields'=>'id,name,email']);

			die(pr($me));

			$em = EventManager::instance();

			//locate the account
			$UserAccountForeignCredentials  = TableRegistry::get("UserManager.UserAccountForeignCredentials");
			$UserAccounts                   = TableRegistry::get("UserManager.UserAccounts");


			


		}

		return false;

	}



}
