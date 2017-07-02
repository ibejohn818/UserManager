<?php


use Cake\Core\App;
use Cake\Core\Configure;

function userManagerGetProviders()
{

	if(!Configure::check("UserManager.providers")) {

		$path = App::path("Auth/Provider","UserManager");
		$providers = [];
		foreach(scandir($path[0]) as $k=>$v) {
			if(in_array($v,['.','..','ProviderBase.php'])
				|| !preg_match('/\.php$/',$v)
			) {
				continue;
			}

			$p = str_replace(".php","",$v);

			$providers[] = $p;
		}

		sort($providers);
		Configure::write("UserManager.loginProviders",$providers);
	}

}
