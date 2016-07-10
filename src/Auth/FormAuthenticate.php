<?php 

namespace UserManager\Auth;

use Cake\Auth\BaseAuthenticate;
use UserManager\Model\Entity\UserAccount;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Event\EventManager;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use UserManager\Config\Config;

class FormAuthenticate extends BaseAuthenticate {

   
   protected  $_defaultConfig = [
        'fields'=>[
            'username'=>'email',
            'password'=>'passwd'
        ],
        'contain'=>[
            'UserAccountPasswds'=>[
                'sort'=>[
                    'UserAccountPasswds.created'=>'DESC'
                ],
                'limit'=>1
            ]
        ]

   ];

    public $user = null;

    public function authenticate(Request $request,Response $response) {
        
        if(!isset($request->data[$this->config('fields')['username']]) || !isset($request->data[$this->config('fields')['password']])) {
            return false; 
        }

        EventManager::instance()->dispatch(new Event(
            'UserManager.Authenticate.beforeAuthenticate',
            $this,
            [
                'request'=>$request,
                'response'=>$response
            ]
        ));

        $this->user = TableRegistry::get("UserManager.UserAccounts")->authenticateUser(
                            [
                                $this->config('fields')['username']=>$request->data($this->config('fields')['username'])
                            ],
                            $request->data($this->config('fields')['password'])
                        );
        
        if($this->user) {

			//check to see if we are expiring passwords
			$pwExpire = Config::get("passwordExpireDays");

			//if($pwExpireDays>0 && (new DateTime("-{$pwExpire} Days"))) {

				

			//}



            $event = new Event("UserManager.Authenticate.success",$this);

        } else {

            $event = new Event("UserManager.Authenticate.failed",$this);

        }
        
        EventManager::instance()->dispatch($event);

        return $this->user;

    }

   



}
