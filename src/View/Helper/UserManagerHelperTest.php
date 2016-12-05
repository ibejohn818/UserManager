<?php
namespace UserManager\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use UserManager\View\Helper\UserManagerHelper;
use Cake\Network\Request;
use Cake\Network\Response;

#Fixtures
use UserManager\Test\Fixtures\UserAccountCustomFieldsFixture;

/**
 * UserManager\View\Helper\UserManagerHelper Test Case
 */
class UserManagerHelperTest extends TestCase
{

	private $request;
	private $response;

	public $fixtures = [
		'plugin.UserManager.UserAccountCustomFields'
	];

    /**
     * Test subject
     *
     * @var \UserManager\View\Helper\UserManagerHelper
     */
    public $UserManagerHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
		$this->request = new Request();
		$this->repsonse = new Response();
        $view = new View($this->request,$this->response);
        $this->UserManagerHelper = new UserManagerHelper($view);

    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
		unset(
			$this->UserManagerHelper,
			$this->request,
			$this->response
		);

        parent::tearDown();
    }

    /**
     * Test isLoggedIn method
     *
     * @return void
     */
    public function testIsLoggedIn()
    {
		//not logged in should be false
		$this->assertFalse($this->UserManagerHelper->isLoggedIn());
		//stuff login session
		$this->request->session()->write("Auth.User.id",1);
		//should detect logged in
		$this->assertTrue($this->UserManagerHelper->isLoggedIn());
		$this->request->session()->delete("Auth");
    }

    /**
     * Test user method
     *
     * @return void
     */
    public function testUser()
    {
		$this->assertEquals($this->UserManagerHelper->user("email"),"");

		$this->request->session()->write("Auth.User",['id'=>1,'email'=>'none@none.com']);

		$this->assertEquals($this->UserManagerHelper->user("email"),"none@none.com");

		$this->request->session()->delete("Auth");

    }

    /**
     * Test authorizeBtn method
     *
     * @return void
     */
    public function testAuthorizeBtn()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test authorizeLink method
     *
     * @return void
     */
    public function testAuthorizeLink()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test authorizeUri method
     *
     * @return void
     */
    public function testAuthorizeUri()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test isMemberOfGroup method
     *
     * @return void
     */
    public function testIsMemberOfGroup()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test customFieldEdit method
     *
     * @return void
     */
    public function testCustomFieldEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeRender method
     *
     * @return void
     */
    public function testBeforeRender()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test userImage method
     *
     * @return void
     */
    public function testUserImage()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
