<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UserManager\Model\Table\UserAccountsTable;

/**
 * UserManager\Model\Table\UserAccountsTable Test Case
 */
class UserAccountsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserAccountsTable
     */
    public $UserAccountsTable;

    /**
     * Fixtures
     *
     * @var array
     */
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
        $config = TableRegistry::exists('UserAccounts') ? [] : ['className' => UserAccountsTable::class];
        $this->UserAccountsTable = TableRegistry::get('UserAccounts', $config);
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

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test generateId method
     *
     * @return void
     */
    public function testGenerateId()
    {

		$id = $this->UserAccountsTable->generateId();

		$this->assertTrue(is_int($id));

		$this->assertTrue(($id>0));
		print_r($this->UserAccountsTable->find()->all()->toArray());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {

        $this->markTestIncomplete('Not implemented yet.');

    }

    /**
     * Test getLoginUser method
     *
     * @return void
     */
    public function testGetLoginUser()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findUsersCustomFields method
     *
     * @return void
     */
    public function testFindUsersCustomFields()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test customFieldsSchema method
     *
     * @return void
     */
    public function testCustomFieldsSchema()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test handleAccountRegistration method
     *
     * @return void
     */
    public function testHandleAccountRegistration()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test createProfileUri method
     *
     * @return void
     */
    public function testCreateProfileUri()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test authenticateUser method
     *
     * @return void
     */
    public function testAuthenticateUser()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test authenticationUser method
     *
     * @return void
     */
    public function testAuthenticationUser()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test confirmPassword method
     *
     * @return void
     */
    public function testConfirmPassword()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationPassword method
     *
     * @return void
     */
    public function testValidationPassword()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationRegistration method
     *
     * @return void
     */
    public function testValidationRegistration()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationAdminEdit method
     *
     * @return void
     */
    public function testValidationAdminEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test confirmUniqueProfileUri method
     *
     * @return void
     */
    public function testConfirmUniqueProfileUri()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test updatePassword method
     *
     * @return void
     */
    public function testUpdatePassword()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test locateForeignAccount method
     *
     * @return void
     */
    public function testLocateForeignAccount()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test createForeignLoginAccount method
     *
     * @return void
     */
    public function testCreateForeignLoginAccount()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test locateLoginProviderAccount method
     *
     * @return void
     */
    public function testLocateLoginProviderAccount()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test createLoginProviderAccount method
     *
     * @return void
     */
    public function testCreateLoginProviderAccount()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
