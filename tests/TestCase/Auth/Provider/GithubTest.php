<?php

namespace UserManager\Test\TestCase\Auth\Provider;

use UserManager\Auth\Provider\Github;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

class GithubProvderTest extends TestCase
{


    public function setUp()
    {
        parent::setUp();
    }


    public function tearDown()
    {
        parent::tearDown();
    }


    public function testPersonalTokenConstruct()
    {

        $token = "test-token";

        $gh = Github::personalToken($token);

        $this->assertTrue(($gh instanceof \UserManager\Auth\Provider\Github));

    }

    public function testAccessToken()
    {
        $gh = new Github();

        $res = $gh->accessToken();

        $this->assertNull($res);

        $res = $gh->accessToken("token");

        $this->assertEquals($res, "token");

    }

    public function testGetLoginUrl()
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['HTTP_HOST'] = 'test.com';

        $gh = new Github();

        $url = $gh->getLoginUrl();

        $this->assertEquals(substr($url, 0, 5), "https");
    }

    public function testHttpClient()
    {

        $gh = new Github();

        $res = $gh->httpClient(new \Cake\Network\Http\Client());

        $this->assertTrue(($res instanceof \Cake\Network\Http\Client));

        $gh = new Github();

        $this->assertTrue(($gh->httpClient() instanceof \Cake\Network\Http\Client));

        $this->expectException(\TypeError::class);

        $gh->httpClient("test");

    }
}
