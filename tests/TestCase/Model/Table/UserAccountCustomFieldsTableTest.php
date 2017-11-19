<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UserManager\Model\Table\UserAccountCustomFieldsTable;

/**
 * UserManager\Model\Table\UserAccountCustomFieldsTable Test Case
 */
class UserAccountCustomFieldsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserAccountCustomFieldsTable
     */
    public $UserAccountCustomFields;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_account_custom_fields',
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_accounts',
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
        $config = TableRegistry::exists('UserAccountCustomFields') ? [] : ['className' => UserAccountCustomFieldsTable::class];
        $this->UserAccountCustomFields = TableRegistry::get('UserAccountCustomFields', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountCustomFields);

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
        $v = new \Cake\Validation\Validator();

        $res = $this->UserAccountCustomFields->validationDefault($v);

        $this->assertEquals($res->field("active")->rules()['valid']->get("rule"), "boolean");

        $this->assertEquals($res->field("display_weight")->rules()['valid']->get("rule"), "numeric");

    }

    /**
     * Test validationCreate method
     *
     * @return void
     */
    public function testValidationCreate()
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
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
