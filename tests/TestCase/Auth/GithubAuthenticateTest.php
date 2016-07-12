<?php

namespace UserManager\Test\TestCase\Auth;

use UserManager\Auth\GithubAuthenticate;
use UserManager\Config\Config;
use Cake\TestSuite\TestCase;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Controller\ComponentRegistry;


class GithubAuthenticateTest extends TestCase {

	public $auth;

	public function setUp() {

		parent::setUp();
        $this->Collection = $this->getMockBuilder(ComponentRegistry::class)->getMock();
		$this->auth = new GithubAuthenticate($this->Collection,[]);

	}


	public function testAuthenticateNoData() {


		$req = new Request();
		$res = new Response();

		$result = $this->auth->authenticate($req,$res);

		$this->assertEquals(false,$result);

	}

	public function testAuthenticateInvalid() {


		$req = new Request(Config::get("githubRedirectUrl"));
		$res = new Response();

		//mock incoming code
		$_GET['code'] = "random";

		$result = $this->auth->authenticate($req,$res);

		$this->assertEquals(false,$result);

	}


}
