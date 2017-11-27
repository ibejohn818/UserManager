<?php

namespace UserManager\Test\TestCase\Auth\Provider;

use UserManager\Auth\Provider\Github;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

class GithubTest extends TestCase
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


        $req = new \Cake\Http\ServerRequest();

        $req->query['code'] = "test";

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
    }

}

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
