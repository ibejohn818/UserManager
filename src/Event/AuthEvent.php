<?php

namespace UserManager\Event;

use Cake\Event\Event;
use UserManager\Auth\Provider\ProviderBase;

class AuthEvent extends Event
{

	public $credentials;
	public $provider;
	public function __construct($name, $subject, &$credentials = false, ProviderBase &$provider = null)
	{

		$this->credentials = &$credentials;
		$this->provider = &$provider;

		parent::__construct($name, $subject, []);

	}

}
