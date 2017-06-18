<?php

namespace UserManager\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;

class TesterShell extends Shell
{

	public function load()
	{

		$dir = __DIR__;
		$f = __FILE__;
		$root = "{$dir}/../../";

		$j = file_get_contents("{$root}/config/config.template.json");

		$json = json_decode($j,true);

		print_r($json);

	}


}
