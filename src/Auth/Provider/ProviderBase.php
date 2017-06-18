<?php

namespace UserManager\Auth\Provider;

use Cake\Datasource\ModelAwareTrait;


abstract class ProviderBase
{

	use  ModelAwareTrait;

	public function __construct()
	{
		$this->loadModel("UserManager.UserAccounts");
		$this->loadModel("UserManager.UserAccountForeignCredentials");
		$this->loadModel("UserManager.UserAccountLoginProviderData");
	}

	abstract public function getLoginUrl();
	abstract public function authenticate(\Cake\Http\ServerRequest $request, \Cake\Http\Response $response);

}
