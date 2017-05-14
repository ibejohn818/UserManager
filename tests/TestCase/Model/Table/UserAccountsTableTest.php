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
    public $UserAccounts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_account_custom_fields',
        'plugin.user_manager.user_value',
        'plugin.user_manager.user_account_foreign_credentials',
        'plugin.user_manager.user_account_groups',
        'plugin.user_manager.user_account_group_assignments',
        'plugin.user_manager.user_account_permissions',
        'plugin.user_manager.user_account_passwds',
        'plugin.user_manager.user_account_profile_images',
        'plugin.user_manager.profile_image'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserAccounts') ? [] : ['className' => 'UserManager\Model\Table\UserAccountsTable'];
        $this->UserAccounts = TableRegistry::get('UserAccounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccounts);

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
        $this->markTestIncomplete('Not implemented yet.');
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
}
