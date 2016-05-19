<?php

namespace UserManager\Lib;

class UserManagerConfig {

	private static $_config = [

		'emailTransport'=>'Tesing',
		'masterPassword'=>''

	];

	public static function get($key) {

		return self::$_config[$key];

	}


}
