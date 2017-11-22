<?php

namespace UserManager\Test\TestCase\Auth\Provider;

use UserManager\Auth\Provider\Google;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

class GoogleProviderTest extends TestCase
{


    public $fixtures = [
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_account_custom_fields',
        'plugin.user_manager.user_account_login_provider_data',
        'plugin.user_manager.user_account_groups',
        'plugin.user_manager.user_account_group_assignments',
        'plugin.user_manager.user_account_permissions',
        'plugin.user_manager.user_account_passwds',
        'plugin.user_manager.user_account_profile_images',
    ];

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

        $this->assertEquals($c->getRedirectUri(), "https://test.com/user-manager/auth-callback/google");

    }

    private function mockLoginRedirect()
    {


    }

    public function testOauthService()
    {

        $_SERVER['HTTP_HOST'] = 'test.com';
        $_SERVER['HTTPS'] = 'on';

        $g = new Google();

        $res = $g->oauthService();

        $this->assertTrue(($res instanceof \Google_Service_Oauth2));

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

    public function testAuthenticate()
    {


        $mockClient = $this->getMockBuilder("\Google_Client")
                            ->getMock();

        $mockClient->expects($this->once())
                    ->method("getAccessToken")
                    ->will($this->returnValue(["access_token"=>"token"]));

        $mockService = $this->getMockBuilder("\Google_Service_Oauth2")
                            ->setConstructorArgs([$mockClient])
                            ->getMock();

        $mockService->userinfo = new userinfo_obj();

        $mockReq = $this->getMockBuilder("\Cake\Http\ServerRequest")
                        ->getMock();

        $mockReq->query = ['code'=>'token'];

        $mockRes = $this->getMockBuilder("\Cake\Http\Response")
                        ->getMock();

        $g = new Google();

        $g->setClient($mockClient);
        $g->setOauthService($mockService);

        $res = $g->authenticate($mockReq, $mockRes);

        $this->assertEquals($res['id'], 1);
        $this->assertEquals($res['profile_uri'] , "john.html");

    }

}


class userinfo
{
    public function get()
    {
        return "get";
    }
}

class userinfo_obj
{
    public function get()
    {
        $cls = new \stdclass();

        $cls->id = "id";
        $cls->picture = "picture";
        $cls->email = "jhardy@test.com";
        $cls->givenName = "givenName";
        $cls->familyName = "familyName";

        return $cls;
    }
}
