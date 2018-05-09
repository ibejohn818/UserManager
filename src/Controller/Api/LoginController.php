<?php

namespace UserManager\Controller\Api;

use UserManager\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\MailerAwareTrait;
use UserManager\Mailer\UserMailer;
use UserManager\Model\Entity\UserAccount;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

class LoginController extends AppController {

    use MailerAwareTrait;

    public $uses = [];

    public function initialize(array $options = []) {

        parent::initialize($options);
    }

    public function beforeFilter(Event $event) {

        parent::beforeFilter($event);

        $this->Auth->allow();

        if(
            in_array('UserManager\Auth\GoogleAuthenticate',$this->Auth->config('authenticate'))
             ||
            array_key_exists('UserManager\Auth\GoogleAuthenticate', $this->Auth->config('authenticate'))
        ) {
            $this->set("google_login",true);
        }

    }

    public function index() {

        $this->loadModel("UserManager.UserAccounts");

        $userAccount = $this->UserAccounts->newEntity();

		if($this->request->getQuery("redirect")) {

			$this->request->session()->write("Login.redirect",$this->request->getQuery("redirect"));

		}

        if ($this->request->is("post")) {

            $user = $this->Auth->identify();

            if($user) {
                $this->Auth->setUser($user);
                $this->Flash->success("Logged In Successfully");
                $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error("Invalid Email/Password");
            }

        }

        // $this->getMailer("UserManager.User")->send("tester");

        $this->set(compact("userAccount"));
    }

    public function forgotPassword() {

        $this->loadModel("UserManager.UserAccountPasswdResetRequests");

        $resetRequest = $this->UserAccountPasswdResetRequests->newEntity();

        $errorMessage = false;

        if ($this->request->is(["post","put"])) {

            $resetRequest = $this->UserAccountPasswdResetRequests->patchEntity($resetRequest,$this->request->data,[
                'validate'=>'resetpassword'
            ]);

			$errorMessage = $resetRequest->errors();

            if(count($errorMessage)>0) {
				$msg = [];
				foreach($errorMessage['email'] as $k=>$v) {
					$msg[] = $v;
				}
				$this->Flash->error(implode("<br>",$msg));
			} else {

				$this->UserAccountPasswdResetRequests->handlePasswordReset($this->request->data['email']);

				$this->Flash->success("Email has been dispatched to \"{$this->request->data['email']}\" with a link to reset your password");

				$this->redirect("/");

			}

        }

        $this->set(compact("resetRequest","errorMessage"));
    }

    public function logout() {

        $this->redirect($this->Auth->logout());

    }

	public function register() {

		$this->loadModel("UserManager.UserAccounts");

		$userAccount = $this->UserAccounts->newEntity();

		if($this->request->is(['post','put'])) {

			$userAccount = $this->UserAccounts->patchEntity($userAccount,$this->request->data,[
				'validate'=>'registration'
			]);

			if(!$userAccount->errors()) {

				if(!$this->UserAccounts->handleAccountRegistration($userAccount, $this->request->data['passwd'])) {

					$this->Flash->error("Fix errors");

				} else {

					$this->Flash->success("Account Created Sucessfully");

					$this->redirect([
						'plugin'=>'UserManager',
						'controller'=>'Login',
						'action'=>'index',
						'prefix'=>null
					]);

				}
			} else {
				$this->Flash->error("Please fix the errors below");
			}
		}

		$this->set(compact(
			"userAccount"
		));

	}

	public function provider($type)
	{

		$type = ucfirst($type);

		$chk = Configure::read("UserManager.LoginProviders.{$type}.enabled");

		if(!$chk) {
			throw new NotFoundException("Provider: {$type}. Not Enabled");
		}
		//$cls = '\UserManager\Lib'.'\\'.ucfirst($type).'Sdk';

        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->request->session()->write('login_redirect', $_SERVER['HTTP_REFERER']);
        }

		$cls = "\UserManager\Auth\Provider\\".$type;

		$provider = new $cls;

		$this->redirect($provider->getLoginUrl());
	}

	public function twitter() {

		$sdk = new TwitterSdk($this->request);
		$url = $sdk->getLoginUrl();

		$this->redirect($url);
	}

    public function handleForeignLogin() {

        $user = $this->Auth->identify();

        if($user['id']) {

            $this->Auth->setUser($user);

			if($this->request->session()->check("Login.redirect")) {
				$url =  $this->request->session()->read("Login.redirect");
				$this->request->session()->delete("Login.redirect");
			} else {
				$url = $this->Auth->redirectUrl();
			}

            $this->redirect($url);

        }
    }

}
