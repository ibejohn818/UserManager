<?php

namespace UserManager/Sdk;

use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Network\Http\Client;

class Base {


	protected $_accessKey;

	public function getAccessKey() {
		return $this->_accessKey;
	}

	public function setAccessKey($key) {
		$this->_accessKey = $key;
	}

	public function get($endPoint,$data = [], $options = []) {

		$client = new Client();

		if($this->getAccessKey()) {
			$options['headers']['Authorization'] = "Bearer ".$this->getAccessKey();
		}


	}

}
