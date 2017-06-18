<?php

namespace UserManager\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\EventManager;
use Cake\Core\Configure;

class AppController extends BaseController {


    public $helpers = ["UserManager.UserManager"];


    public function initialize() {

        parent::initialize();

        EventManager::instance()->on("UserManager.Authenticate.success",function($event) {

        });

		if(!Configure::check("UserManager.bootstrap")) {
			throw new \Cake\Error\FatalErrorException(<<<EOT
				UserManager Plugin Error: UserManager/config/bootstrap.php not loaded!
				Ensure your Plugin::load() has bootstrap setting enabled in your config/boostra.php.
				Plugin::load("UserManager",[
					'boostrap'=>true,
					'routes'=>true
				]);
EOT
			);
		}

    }

    public function beforeFilter(\Cake\Event\Event $event) {

        parent::beforeFilter($event);




    }

    protected function handleSearchRequest(array $PaginateOptions) {

        $searchKey = md5($this->request->here);

        do if($this->request->is(['post','put']) && isset($this->request->data['search-key']) && $this->request->data['search-key'] == $searchKey) {

            if(empty($this->request->data['search'])) {
                $this->request->session()->delete("Search.{$searchKey}");
                break;
            }

            $searchValue = "%".str_replace(" ","%",$this->request->data['search'])."%";

            $this->request->session()->write("Search.{$searchKey}.search-value",$searchValue);
            $this->request->session()->write("Search.{$searchKey}.search",$this->request->data['search']);

        } while(false);

        if(isset($_GET['clear-search']) && $_GET['clear-search'] == $searchKey) {

            $this->request->session()->delete("Search.{$searchKey}");

            $this->redirect($this->request->here);

        }

        if($this->request->session()->check("Search.{$searchKey}")) {
            $PaginateOptions['search'] = $this->request->session()->read("Search.{$searchKey}.search-value");
        }

        return $PaginateOptions;

    }

    public function userAccountAutoComplete() {

        $term = $_GET['term'];

        $UserAccounts = \Cake\ORM\TableRegistry::get("UserManager.UserAccounts");

        $search = $UserAccounts->find();

        // $search->where(['active'=>1]);

        $search->select([
            'name'=>$search->func()->concat([
                'UserAccounts.first_name'=>'literal',
                ' ',
                'UserAccounts.last_name'=>'literal'
            ]),
            'email',
            'id'
        ]);

        $search->where(function($exp) use($term) {

            return $exp->or_([
                "UserAccounts.email LIKE '%{$term}%'",
                "UserAccounts.first_name LIKE '%{$term}%'",
                "UserAccounts.last_name LIKE '%{$term}%'"
            ]);

        });

        $search->where(['active'=>1]);

        $results = $search->all()->toArray();

        $this->set(compact("results"));

        $this->viewBuilder()->layout("ajax");

        $this->render("/Elements/user-accounts-auto-complete");

    }

}
