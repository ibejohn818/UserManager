<?php

namespace UserManager\Controller;

use UserManager\Controller\AppController;
use Cake\Event\Event;
use UserManager\Lib\GoogleSdk;
use Cake\Mailer\MailerAwareTrait;
use UserManager\Mailer\UserMailer;
use UserManager\Model\Entity\UserAccount;


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

				$this->redirect($this->here);

			}

        }

        $this->set(compact("resetRequest","errorMessage"));
    }

    public function logout() {

        $this->redirect($this->Auth->logout());

    }

	public function register() {

		$userAccount = new UserAccount();

		if($this->request->is(['post','put'])) {


		}

		$this->set(compact(
			"userAccount"
		));

	}

    public function google() {

        $sdk = new GoogleSdk();

        $goBackUrl = false;

        $this->redirect($sdk->returnLoginUrl());

    }

    public function handleForeignLogin() {

        $user = $this->Auth->identify();

        if($user['id']) {

            $this->Auth->setUser($user);

            $this->redirect($this->Auth->redirectUrl());

        }
    }

}
