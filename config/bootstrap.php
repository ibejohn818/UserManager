<?php

use Cake\Mailer\Email;
use Cake\Cache\Cache;
use Cake\Core\Configure;

//configuration
//echo "CONFIG: ".CONFIG;

$dir = realpath(__DIR__);

require "{$dir}/functions.php";

$http_host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST']:'';

define("USER_MANAGER_LOGIN_SETTINGS_SCHEMA", "config.login.schema.php");
define("USER_MANAGER_LOGIN_SETTINGS", "config.login.php");

// $CacheEngine = "File";
// $CacheEngine = "Memcached";
$defConf = Cache::getConfig("default");

$CacheEngine = $defConf['className'];
$Port = (isset($defConf['port'])) ? $defConf['port']:'';
$Servers = (isset($defConf['servers'])) ? $defConf['servers']:'';


Cache::setConfig('user-manager-1min',[
	'className' => $CacheEngine,
	'prefix' => 'um-1min-',
	'path' => CACHE . 'misc/',
	'serialize' => 'php',
	'duration' => '+10 minutes',
	'servers'=>$Servers,
	'port'=>$Port
]);

$conf = new \UserManager\Lib\Conf();

$conf->bootstrap();

Configure::write("UserManager.bootstrap",true);

userManagerGetProviders();
