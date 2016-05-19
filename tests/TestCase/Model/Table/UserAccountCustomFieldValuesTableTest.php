<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UserManager\Model\Table\UserAccountCustomFieldValuesTable;

/**
 * UserManager\Model\Table\UserAccountCustomFieldValuesTable Test Case
 */
class UserAccountCustomFieldValuesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_foreign_credentials',
        'plugin.user_manager.user_account_group_assignments',
        'plugin.user_manager.user_account_groups',
        'plugin.user_manager.user_account_permissions',
        'plugin.user_manager.user_account_passwds',
        'plugin.user_manager.user_account_custom_fields'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserAccountCustomFieldValues') ? [] : ['className' => 'UserManager\Model\Table\UserAccountCustomFieldValuesTable'];
        $this->UserAccountCustomFieldValues = TableRegistry::get('UserAccountCustomFieldValues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountCustomFieldValues);

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
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
}
