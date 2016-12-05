<?php 

namespace UserManager\Auth;

use Cake\Auth\BaseAuthenticate;
use UserManager\Model\Entity\UserAccount;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Event\EventManager;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use UserManager\Lib\GoogleSdk;
use UserManager\Config\Config;

class GoogleAuthenticate extends BaseAuthenticate {


    protected $GoogleSdk = false;

    public $user = null;

    public $googleData = null;

    public function authenticate(Request $request,Response $response) {

		$url = Config::get("googleAuthRedirectUrl");

		if(empty($url)) {
			return false;
		}

		if($request->here = $url && isset($_GET['code'])) {


			$this->googleData = $this->GoogleSdk()->handleLoginRedirect($request->query);

			//locate the account
			$UserAccountForeignCredentials  = TableRegistry::get("UserManager.UserAccountForeignCredentials");
			$UserAccounts                   = TableRegistry::get("UserManager.UserAccounts");

			$uac = $UserAccountForeignCredentials->newEntity([
									'service_name'=>'google',
									'param1'=>$this->googleData['user']->id,
									'param2'=>$this->googleData['user']->picture
								]);
			$ua = $UserAccounts->newEntity([
									'email'=>$this->googleData['user']->email,
									'first_name'=>$this->googleData['user']->givenName,
									'last_name'=>$this->googleData['user']->familyName
								]);

			$credentials = $UserAccountForeignCredentials->locateAccount([
									'service_name'=>'google',
									'param1'=>$this->googleData['user']->id
								],$ua,$uac);


			$this->user = $credentials;

			if($this->user) {

				$event = new Event("UserManager.Authenticate.success",$this,['google_token'=>$this->googleData['token']]);

			} else {

				$event = new Event("UserManager.Authenticate.failed",$this);

			}

			EventManager::instance()->dispatch($event);

			return $this->user;
		}

		return false;


    }


    private function GoogleSdk() {

        if(!$this->GoogleSdk) {
            $this->GoogleSdk = new GoogleSdk(false);
        }

        return $this->GoogleSdk;

    }

}
