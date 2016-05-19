<?php

use Cake\Mailer\Email;
use Cake\Cache\Cache;

//configuration

$http_host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST']:'';

//ADMIN USER ACCOUNT GROUP ID
define('USER_ACCOUNT_ADMIN_ACCOUNT_GROUP',9999);

//MASTER LOGIN PASSWORD
define("USER_ACCOUNT_MASTER_PASSWD","");

//GOOGLE API KEY
define("GOOGLE_API_KEY","AIzaSyBGur0U-SZzREwEqYffNfqJUz45NixBM18");
define("GOOGLE_CLIENT_ID","990121652841-v6ml182uput63re60ra8u1akgipsj58c.apps.googleusercontent.com");
define("GOOGLE_CLIENT_SECRET","NEx4LlAjrf4bAAF0YAg7i8G7");
define("GOOGLE_CLIENT_REDIRECT_URL","http://{$http_host}/user-manager/auth-callback/google");
# scopes seperated by a space
define("GOOGLE_CLIENT_SCOPES","email profile");

#############################
## GOOGLE PROFILE IMAGE
#############################
# put the path relative to CAKEPHP WEBROOT
# no slashes on the begining or end
# Make sure the path is writable
# if defined this will fire the beforeRender
# of the UserManager helper and make sure the image is saved and up-to-date
#define("GOOGLE_PROFILE_IMAGE_WEBROOT","");

# email configuration
// Email::configTransport('gmail', [
// 	'from'=>'john@johnchardy.com',
//     'host' => 'smtp.gmail.com',
//     'port' => 587,
//     'username' => 'john@johnchardy.com',
//     'password' => 'artosari',
//     'className' => 'Smtp',
//     'emailFormat'=>'html',
//     'tls'=>true
// ]);

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
