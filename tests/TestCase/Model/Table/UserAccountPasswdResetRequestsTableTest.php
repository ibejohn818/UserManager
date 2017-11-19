<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UserManager\Model\Table\UserAccountPasswdResetRequestsTable;

/**
 * UserManager\Model\Table\UserAccountPasswdResetRequestsTable Test Case
 */
class UserAccountPasswdResetRequestsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserAccountPasswdResetRequestsTable
     */
    public $UserAccountPasswdResetRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_account_passwd_reset_requests',
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
        $config = TableRegistry::exists('UserAccountPasswdResetRequests') ? [] : ['className' => UserAccountPasswdResetRequestsTable::class];
        $this->UserAccountPasswdResetRequests = TableRegistry::get('UserAccountPasswdResetRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountPasswdResetRequests);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    //public function testInitialize()
    //{
        //$this->markTestIncomplete('Not implemented yet.');
    //}

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {

        $r = new \Cake\ORM\RulesChecker();

        $r = $this->UserAccountPasswdResetRequests->buildRules($r);

        $this->assertTrue(($r instanceof \Cake\ORM\RulesChecker));

    }

    /**
     * Test validationResetpassword method
     *
     * @return void
     */
    public function testValidationResetpassword()
    {
        $v = new \Cake\Validation\Validator();

        $res = $this->UserAccountPasswdResetRequests->validationResetpassword($v);

        $this->assertTrue(($res->field("email") instanceof \Cake\Validation\ValidationSet));
    }

    /**
     * Test checkEmailAddress method
     *
     * @return void
     */
    public function testCheckEmailAddress()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test handlePasswordReset method
     *
     * @return void
     */
    public function testHandlePasswordReset()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
