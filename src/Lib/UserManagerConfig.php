<?php

namespace UserManager\Lib;

class UserManagerConfig {

	private static $_config = [

		'emailTransport'=>'Tesing',
		'masterPassword'=>'',

		# Password Auth Options
		'passwordExpireDays'=>'0', //Leave at zero to never expire. Will throw password expires event if caught

		# GOOGLE API CONFIG
		'googleApiKey'=>'AIzaSyBGur0U-SZzREwEqYffNfqJUz45NixBM18',
		'googleClientId'=>'990121652841-v6ml182uput63re60ra8u1akgipsj58c.apps.googleusercontent.com',
		'googleClientSecret'=>'NEx4LlAjrf4bAAF0YAg7i8G7',
		## GOOGLE GRANT SCOPES SEPERATED BY SPACE
		'googleClientScopes'=>'email profile',


		# Facebook API Config
		'facebookApiSecret'=>	'd18e108abd54bc48e6d50ffff04db1cf',
		'facebookApiId'=>		'1482200855330752',
		'facebookApiScopes' => ['email']



	];

	public static function get($key) {

		return self::$_config[$key];

	}
	/**
	 * Checks if a property exists and has a value
	 */
	public static function is($key) {

		if(!isset(self::$_config[$key])) {
			return false;
		}

		if(empty(self::$_config[$key])) {
			return false;
		}

		return true;

	}

	/**
	 * Return the redirect URL google will send the 
	 * user back to after authenticating.
	 * Plugin:UserManager
	 * Controller:Login
	 * Action:handleForeignLogin
	 * Prefix: null
	 * @return string
	 */
	public static function googleLoginRedirectUrl() {

		$host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST']:false;

		if(!$host) {
			return false;
		}

		return "http://{$host}/user-manager/auth-callback/google";

	}

	public static function facebookLoginRedirectUrl() {

		$host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST']:false;

		if(!$host) {
			return false;
		}

		return "http://{$host}/user-manager/auth-callback/facebook";

	}


}
