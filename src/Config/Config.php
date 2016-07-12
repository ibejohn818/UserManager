<?php

namespace UserManager\Config;

class Config {

	protected static $_config = false;

	public static function get($key) {

		if(!static::$_config) {
			static::$_config = json_decode(file_get_contents(CONFIG."user-manager.conf.json"),true);
		}

		if(!isset(static::$_config[$key])) {
			return null;
		}

		return static::$_config[$key];

	}

	/**
	 * Checks if a property exists and has a value
	 */
	public static function is($key) {

		if(!static::$_config) {
			static::$_config = json_decode(file_get_contents(CONFIG."user-manager.conf.json"),true);
		}

		if(!isset(static::$_config[$key])) {
			return false;
		}

		if(empty(static::$_config[$key])) {
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


	public static function twitterLoginRedirectUrl() {

		$host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST']:false;

		if(!$host) {
			return false;
		}

		return "http://{$host}/user-manager/auth-callback/twitter";

	}

}
