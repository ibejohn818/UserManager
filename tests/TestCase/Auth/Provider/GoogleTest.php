<?php

namespace UserManager\Test\TestCase\Auth;

use UserManager\Auth\Provider\Google;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

class GoogleProviderTest extends TestCase
{



    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        //$config = TableRegistry::exists('UserAccounts') ? [] : ['className' => UserAccountsTable::class];
        //$this->UserAccountsTable = TableRegistry::get('UserAccounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountsTable);

        parent::tearDown();
    }

    public function testGetLoginUrl()
    {

        $mock = $this->getMockBuilder("\Google_Client")
                        ->getMock();

        $g = new Google();

        $g->setClient($mock);

        $mock->expects($this->once())
            ->method("createAuthUrl")
            ->will($this->returnValue("http://authurl.com"));

        $this->assertEquals($g->getLoginUrl(), "http://authurl.com");

    }

    public function testSetClient()
    {

        $mock = $this->getMockBuilder("\Google_Client")
                        ->getMock();

        $g = new Google();

        $g->setClient($mock);

        $c = $g->client();

        $this->assertTrue(($c instanceof \Google_Client));

    }

    public function testClient()
    {

        $_SERVER['HTTP_HOST'] = 'test.com';
        $_SERVER['HTTPS'] = 'on';

        $g = new Google();

        $c = $g->client();

        $this->assertEquals($c->getRedirectUri(), "https://test.com");

    }

    private function mockLoginRedirect()
    {


    }

    public function testHandleLoginRedirect()
    {

        $mockClient = $this->getMockBuilder("\Google_Client")
                            ->getMock();

        $mockClient->expects($this->once())
                    ->method("getAccessToken")
                    ->will($this->returnValue("token"));

        $mockService = $this->getMockBuilder("\Google_Service_Oauth2")
                            ->setConstructorArgs([$mockClient])
                            ->getMock();

        $mockService->userinfo = new userinfo();

        $g = new Google();

        $g->setClient($mockClient);
        $g->setOauthService($mockService);

        $res = $g->handleLoginRedirect(['code'=>'code']);

        $this->assertEquals($res['user'], 'get');
        $this->assertEquals($res['token'], 'token');

    }
}
class userinfo
{
    public function get()
    {
        return "get";
    }
}

