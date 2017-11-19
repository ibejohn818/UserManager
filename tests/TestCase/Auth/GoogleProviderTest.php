<?php

namespace UserManager\Test\TestCase\Auth;

use UserManager\Auth\Provider\Google;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

class GoogleTest extends TestCase
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

        $mock->expects($this->once())
                ->method("createAuthUrl")
                ->will($this->returnValue("http://authurl.com"));

        $g = new Google();

        $g->setClient($mock);


        $url = $g->getLoginUrl();

        $this->assertEquals($url, "http://authurl.com");

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


    public function testHandleLoginRedirect()
    {

        $this->markTestIncomplete('Not implemented yet.');
        $mock = $this->getMockBuilder("\Google_Client")
                        ->getMock();

        $g = new Google();

        $g->setClient($mock);

        $c = $g->client();


    }
}
