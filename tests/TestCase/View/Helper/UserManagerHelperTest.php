<?php
namespace UserManager\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use UserManager\View\Helper\UserManagerHelper;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;

#Fixtures
use UserManager\Test\Fixtures\UserAccountCustomFieldsFixture;

/**
 * UserManager\View\Helper\UserManagerHelper Test Case
 */
class UserManagerHelperTest extends TestCase
{

	private $request;
	private $response;
	private $UserAccounts;

	public $fixtures = [
		'plugin.UserManager.UserAccountCustomFields',
		'plugin.UserManager.UserAccounts',
		'plugin.UserManager.UserAccountGroups',
		'plugin.UserManager.UserAccountGroupAssignments',
		'plugin.UserManager.UserAccountPasswds',
		'plugin.UserManager.UserAccountProfileImages',
		'plugin.UserManager.UserAccountForeignCredentials',
		'plugin.UserManager.UserAccountPermissions',

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
		$this->UserAccounts = TableRegistry::get("UserManager.UserAccounts");
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


	protected function loginJohn()
	{

		$john = $this->UserAccounts->authenticateUser(['UserAccounts.id'=>1]);

		$this->request->session()->write("Auth.User",$john);
	}

	protected function logoutJohn()
	{

		$this->request->session()->delete("Auth");

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
		$this->loginJohn();
		//should detect logged in
		$this->assertTrue($this->UserManagerHelper->isLoggedIn());
		$this->logoutJohn();
    }

    /**
     * Test user method
     *
     * @return void
     */
    public function testUser()
    {
		$this->assertEquals($this->UserManagerHelper->user("email"),"");

		$this->loginJohn();

		$this->assertEquals($this->UserManagerHelper->user("email"),"john@johnchardy.com");

		$this->logoutJohn();

    }

    /**
     * Test authorizeBtn method
     *
     * @return void
     */
    public function testAuthorizeBtn()
    {
		$urlParams = [
			'plugin'=>'UserManager',
			'controller'=>'UserAccounts',
			'action'=>'index',
			'prefix'=>'admin'
		];

		$btn = $this->UserManagerHelper->authorizeBtn('success','test',$urlParams);

		$this->assertFalse($btn);

		$this->loginJohn();

		$btn = $this->UserManagerHelper->authorizeBtn('success','test',$urlParams);

		$this->assertContains("href",$btn);

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
