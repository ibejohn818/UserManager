<?php

namespace UserManager\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\Event\EventManager;
use Cake\Event\Event;
use UserManager\Lib\TwitterSdk;
use Cake\Core\Configure;


//class TwitterAuthenticate extends BaseAuthenticate {

	//public function authenticate(Request $req, Response $res) {

		//$url = Configure::read("UserManager.TwitterRedirectUrl");

		//if($req->here == $url && (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier']))) {

			//$em = EventManager::instance();

			//$event = new Event("UserManager.Authenticate.beforeAuthenticate",$this,[
				//'request'=>$req,
				//'response'=>$res
			//]);

			//$em->dispatch($event);

			//$sdk = new TwitterSdk($req);

			//$user = $sdk->completeAuthentication($_GET['oauth_verifier']);


			//if(!$user) {

				//$event = new Event("UserManager.Authenticate.failed",$this,[
					//'request'=>$req,
					//'response'=>$res
				//]);
				//$em->dispatch($event);
				//return false;
			//}

			////locate the account
			//$UserAccountForeignCredentials  = TableRegistry::get("UserManager.UserAccountForeignCredentials");
			//$UserAccounts                   = TableRegistry::get("UserManager.UserAccounts");


			//$nameArr = explode(" ",$user['name']);
			//$first_name = "";
			//$last_name = "";

			//if(count($nameArr)<=0) {
				//$first_name = $user['name'];
			//} else {
				//foreach($nameArr as $k=>$v) {
					//if($k==0) {
						//$first_name = $v;
					//} else {
						//$last_name = $v." ";
					//}
				//}

				//$last_name = rtrim($last_name);
			//}

			//$uac = $UserAccountForeignCredentials->newEntity([
									//'service_name'=>'twitter',
									//'param1'=>$user['id'],
									//'param2'=>$user['oauth_token'],
									//'param3'=>$user['oauth_secret']
								//]);
			//$ua = $UserAccounts->newEntity([
									//'email'=>$user['email'],
									//'first_name'=>$first_name,
									//'last_name'=>$last_name
								//]);
			////var_dump($user);
			////var_dump($ua);
			////var_dump($uac);
			////die();
			//$credentials = $UserAccountForeignCredentials->locateAccount([
									//'service_name'=>'twitter',
									//'param1'=>$user['id']
								//],$ua,$uac);

			//$event = new Event("UserManager.Authenticate.success",$this,[
				//'TwitterSdk'=>$sdk,
				//'TwitterUser'=>$user,
				//'user'=>&$credentials,
				//'request'=>$req,
				//'response'=>$res
			//]);

			//$em->dispatch($event);

			//return $credentials;

		//}

		//return false;

	//}

//}
