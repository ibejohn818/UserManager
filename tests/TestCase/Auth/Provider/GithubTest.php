<?php

namespace UserManager\Test\TestCase\Auth\Provider;

use UserManager\Auth\Provider\Github;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

class GithubTest extends TestCase
{

    public $fixtures = [
        'plugin.user_manager.user_account_permissions',
        'plugin.user_manager.user_account_groups',
        'plugin.user_manager.user_account_group_assignments',
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_account_custom_fields',
        'plugin.user_manager.user_account_login_provider_data',
        'plugin.user_manager.user_account_passwds',
        'plugin.user_manager.user_account_profile_images',
    ];

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

    public function testGetToken()
    {

        $req = new \Cake\Http\ServerRequest();

        $req->query['code'] = "test";

        $gh = new Github();

        $mockClient = $this->getMockBuilder('\Cake\Network\Http\Client')
						->disableOriginalConstructor()
						->setMethods(['post'])
                        ->getMock();

        $mockClient->method('post')->willReturn(new getTokenBodyFalse());

		$gh->httpClient($mockClient);

		$res = $gh->getToken($req);

		$this->assertFalse($res);

        $gh = new Github();

        $mockClient = $this->getMockBuilder('\Cake\Network\Http\Client')
						->disableOriginalConstructor()
						->setMethods(['post'])
                        ->getMock();


        $mockClient->method('post')->willReturn(new getTokenBodyTrue());

		$gh->httpClient($mockClient);

		$res = $gh->getToken($req);

        $this->assertEquals($res, 'test-token');
    }

    public function testGet()
    {


        //test result not cache hit, write to cache
        $conf = ["cacheAdapter"=> __NAMESPACE__."\\getTestCacheMock"];

        $gh = new Github($conf);

        $mockClient = $this->getMockBuilder('\Cake\Network\Http\Client')
						->disableOriginalConstructor()
						->setMethods(['get'])
                        ->getMock();

        $mockClient->method('get')->willReturn(new getTestGetBody());

        $gh->httpClient($mockClient);
        $gh->accessToken("test-token");

        $res = $gh->get("/test", ['test'=>'test'], [], true);

        $this->assertEquals($res['content']['test'], 'test');
        $this->assertEquals(getTestCacheMock::$write['etag'], "Test-Tag");
        $this->assertEquals(getTestCacheMock::$write['modified'], "Test-Modified");
        $this->assertEquals(getTestCacheMock::$write['result']['content']['test'], "test");

        //test result cached
        $conf = ["cacheAdapter"=> __NAMESPACE__."\\getTestCacheMockCached"];

        $gh = new Github($conf);

        $mockClient = $this->getMockBuilder('\Cake\Network\Http\Client')
						->disableOriginalConstructor()
						->setMethods(['get'])
                        ->getMock();

        $mockClient->method('get')->willReturn(new getTestGetBodyCached());

        $gh->httpClient($mockClient);
        $gh->accessToken("test-token");

        $res = $gh->get("/cached", ['cached'=>'cached'], [], true);

        $this->assertEquals($res['content']['test-cached'], 'cached-result');


        $gh = Github::personalToken("test-token");

        $mockClient = $this->getMockBuilder('\Cake\Network\Http\Client')
						->disableOriginalConstructor()
						->setMethods(['get'])
                        ->getMock();

        $mockClient->method('get')->willReturn(new getTestGetBodyThird());

        $gh->httpClient($mockClient);

        $res = $gh->get("/test-result", [], [], false);

        $this->assertEquals($res['content']['test'], 'test-result');
        $this->assertEquals($res['pagination']['total_pages'], 34);
        $this->assertTrue(isset($res['pagination']['next']));
        $this->assertTrue(isset($res['pagination']['last']));

        //test first prev pagination links
        $gh = Github::personalToken("test-token");

        $mockClient = $this->getMockBuilder('\Cake\Network\Http\Client')
						->disableOriginalConstructor()
						->setMethods(['get'])
                        ->getMock();

        $mockClient->method('get')->willReturn(new getTestGetBodyForth());


        $gh->httpClient($mockClient);

        $res = $gh->get("/test-result", [], [], false);

        $this->assertEquals($res['content']['test'], 'test-forth');
        $this->assertEquals($res['pagination']['total_pages'], 21);
        $this->assertTrue(isset($res['pagination']['first']));
        $this->assertTrue(isset($res['pagination']['prev']));

    }

    public function testAuthenticate()
    {

        \Cake\Cache\Cache::disable();

        $req = new \Cake\Http\ServerRequest();
        $res = new \Cake\Http\Response();

        $req->query['code'] = 'test-token';

        $mockClient = $this->getMockBuilder('\Cake\Network\Http\Client')
						->disableOriginalConstructor()
						->setMethods(['get', 'post'])
                        ->getMock();

        $mockClient->method('get')->willReturn(new getTestAuthenticateBody());
        $mockClient->method('post')->willReturn(new postTestAuthenticateBody());

        $gh = new Github();

        $gh->httpClient($mockClient);

        $creds = $gh->authenticate($req, $res);

        $this->assertEquals($creds['id'], 1);
        $this->assertEquals($creds['email'], 'jhardy@test.com');

        $mockClient = $this->getMockBuilder('\Cake\Network\Http\Client')
						->disableOriginalConstructor()
						->setMethods(['get', 'post'])
                        ->getMock();

        $mockClient->method('get')->willReturn(new getTestAuthenticateBody());
        $mockClient->method('post')->willReturn(new postTestAuthenticateBodyTwo());

        $gh = new Github();

        $gh->httpClient($mockClient);

        $creds = $gh->authenticate($req, $res);

        $this->assertFalse($creds);
    }

}

class getTestAuthenticateBodyTwo
{

    public $code = 200;
    public $headers = [
        'Etag'=>'etag'
    ];

    public function body()
    {
        return json_encode([
            'email'=>'jtest@test.com',
            'id'=>'6969',
            'name'=>'John',
            'login'=>'ibejohn818'
        ]);
    }

}

class postTestAuthenticateBodyTwo
{

    public $code= 200;

    public function body()
    {
        return '';
    }

}

class getTestAuthenticateBody
{

    public $code = 200;
    public $headers = [
        'Etag'=>'etag'
    ];

    public function body()
    {
        return json_encode([
            'email'=>'jhardy@test.com',
            'id'=>'6969',
            'name'=>'John Test',
            'login'=>'ibejohn818'
        ]);
    }

}

class postTestAuthenticateBody
{

    public $code= 200;

    public function body()
    {
        return 'access_token=test-token&scope=test-scope&token_type=test-type';
    }

}

class getTestGetBodyForth
{
    public $code = 200;
    public $headers = [
        'Etag'=>'test-etag',
        'Last-Modified'=>'test-modified',
        'Link'=>'<https://api.github.com/search/code?q=addClass+user%3Amozilla&page=1>; rel="first",
                <https://api.github.com/search/code?q=addClass+user%3Amozilla&page=20>; rel="prev"'
    ];
    public function body()
    {
        return json_encode([
            'test'=>'test-forth'
        ]);
    }

}

class getTestGetBodyThird
{
    public $code = 200;
    public $headers = [
        'Etag'=>'test-etag',
        'Last-Modified'=>'test-modified',
        'Link'=>'<https://api.github.com/search/code?q=addClass+user%3Amozilla&page=2>; rel="next",
                <https://api.github.com/search/code?q=addClass+user%3Amozilla&page=34>; rel="last"'
    ];
    public function body()
    {
        return json_encode([
            'test'=>'test-result'
        ]);
    }

}

class getTestGetBodyCached
{
    public $code = 304;
    public $headers = [
            'Etag'=>'Cached-Tag',
            'Last-Modified'=>'Cached-Modified',
            'Link'=>[
            ]
    ];

}

//testGet set 2
class getTestCacheMockCached
{
    public static $write;
    public static $result = [
        'result'=>[
            'content'=>[
                'test-cached'=>'cached-result'
            ]
        ],
        'headers'=>[
        ],
        'etag'=>'cached-etag',
        'modified'=>'cached-modified'
    ];

    public static function read()
    {
        return static::$result;
    }
}


//testGet set1
class getTestCacheMock
{
    public static $write = null;
    public static function read()
    {
        return false;
    }
    public static function write($token, $value, $conf)
    {
        static::$write = $value;
    }
}

//testGet set1
class getTestGetBody
{
    public $code = '200';
    public $headers = [
        'Etag'=>'Test-Tag',
        'Last-Modified'=>'Test-Modified'
    ];
    public function body()
    {
        $a = [
            'test'=>'test'
        ];
        return json_encode($a);
    }
}

class getTokenBodyFalse
{

    public function body()
    {
        return 'scope=test-scope&token_type=test-type';
    }

}

class getTokenBodyTrue
{
    public function body()
    {
        return 'access_token=test-token&scope=test-scope&token_type=test-type';
    }
}
