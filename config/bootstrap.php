<?php

use Cake\Mailer\Email;
use Cake\Cache\Cache;

//configuration

$http_host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST']:'';

// $CacheEngine = "File";
// $CacheEngine = "Memcached";
$CacheEngine = "Redis";

$Port = 6379;

$Servers = '127.0.0.1';

Cache::config('user-manager-1min',[
	'className' => $CacheEngine,
	'prefix' => 'um-1min-',
	'path' => CACHE . 'misc/',
	'serialize' => 'php',
	'duration' => '+1 minutes',
	'server'=>$Servers,
	'port'=>$Port
]);
