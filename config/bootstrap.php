<?php

use Cake\Mailer\Email;
use Cake\Cache\Cache;
use Cake\Core\Configure;

//configuration
//echo "CONFIG: ".CONFIG;

$dir = realpath(__DIR__);

require "{$dir}/functions.php";

$http_host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST']:'';

// $CacheEngine = "File";
// $CacheEngine = "Memcached";
$CacheEngine = "Memcached";

$Port = 11211;

$Servers = ['memcache'];

Cache::config('user-manager-1min',[
	'className' => $CacheEngine,
	'prefix' => 'um-1min-',
	'path' => CACHE . 'misc/',
	'serialize' => 'php',
	'duration' => '+1 minutes',
	'servers'=>$Servers,
	'port'=>$Port
]);


if(!$settings = @include_once CONFIG."user-manager.conf.php") {

	throw new \Cake\Error\FatalErrorException("UserManager Plugin: config\user-manager.conf.php NOT FOUND! Run shell command 'UserManager.config' to generate configuration");
}

Configure::write("UserManager",$settings);

Configure::write("UserManager.bootstrap",true);

userManagerGetProviders();
