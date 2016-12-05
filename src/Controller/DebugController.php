<?php

namespace UserManager\Controller;

use UserManager\Controller\AppController;

class DebugController extends AppController
{

	public function beforeFilter(\Cake\Event\Event $event)
	{
		if(\Cake\Core\Configure::read("debug")!=1) {
			throw new \Cake\Error\FatalErrorException("MUST BE IN DEBUG MDOE");
		}
		parent::beforeFilter($event);
	}


	public function index() {

		

	}


}
