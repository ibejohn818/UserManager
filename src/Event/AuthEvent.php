<?php

namespace UserManager\Event;

use Cake\Event\Event;

class AuthEvent extends Event
{

	public $credentials;
	public $provider;
	public function __construct($name, $subject, &$credentials = false, &$provider = false)
	{

		$this->credentials = &$credentials;
		$this->provider = &$provider;

		parent::__construct($name, $subject, []);

	}

}
