<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UserManager\Model\Table\UserAccountGroupAssignmentsTable;

/**
 * UserManager\Model\Table\UserAccountGroupAssignmentsTable Test Case
 */
class UserAccountGroupAssignmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserAccountGroupAssignmentsTable
     */
    public $UserAccountGroupAssignments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_account_group_assignments',
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_account_custom_fields',
        'plugin.user_manager.user_account_login_provider_data',
        'plugin.user_manager.user_account_groups',
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
        $config = TableRegistry::exists('UserAccountGroupAssignments') ? [] : ['className' => UserAccountGroupAssignmentsTable::class];
        $this->UserAccountGroupAssignments = TableRegistry::get('UserAccountGroupAssignments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountGroupAssignments);

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {

        $v = new \Cake\Validation\Validator();

        $res = $this->UserAccountGroupAssignments->validationDefault($v);

        $this->assertTrue(($res->field("id") instanceof \Cake\Validation\ValidationSet));

    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $r = new \Cake\ORM\RulesChecker();

        $r = $this->UserAccountGroupAssignments->buildRules($r);

        $this->assertTrue(($r instanceof \Cake\ORM\RulesChecker));
    }
}
