<?php 

namespace UserManager\Controller;

use UserManager\Controller\AppController;

use UserManager\Lib\GoogleSdk;


class AuthController extends AppController {

    public function beforeFilter(\Cake\Event\Event $event) {

        parent::beforeFilter($event);

    }

    public function handleGoogleCallback() {
    
        $sdk = new GoogleSdk();

        $sdk->handleLoginRedirect($_REQUEST);

    }

}
