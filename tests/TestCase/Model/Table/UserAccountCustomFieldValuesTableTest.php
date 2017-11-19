<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\ORM\RulesChecker;
use UserManager\Model\Table\UserAccountCustomFieldValuesTable;

/**
 * UserManager\Model\Table\UserAccountCustomFieldValuesTable Test Case
 */
class UserAccountCustomFieldValuesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserAccountCustomFieldValuesTable
     */
    public $UserAccountCustomFieldValues;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_login_provider_data',
        'plugin.user_manager.user_account_groups',
        'plugin.user_manager.user_account_group_assignments',
        'plugin.user_manager.user_account_permissions',
        'plugin.user_manager.user_account_passwds',
        'plugin.user_manager.user_account_profile_images',
        'plugin.user_manager.user_account_custom_fields',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserAccountCustomFieldValues') ? [] : ['className' => UserAccountCustomFieldValuesTable::class];
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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {

        $r = new RulesChecker();

        $r = $this->UserAccountCustomFieldValues->buildRules($r);

        $this->assertTrue(($r instanceof RulesChecker));

    }
}
