<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UserManager\Model\Table\UserAccountLoginProviderDataTable;

/**
 * UserManager\Model\Table\UserAccountLoginProviderDataTable Test Case
 */
class UserAccountLoginProviderDataTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserAccountLoginProviderDataTable
     */
    public $UserAccountLoginProviderData;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_account_login_provider_data',
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_account_custom_fields',
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
        $config = TableRegistry::exists('UserAccountLoginProviderData') ? [] : ['className' => UserAccountLoginProviderDataTable::class];
        $this->UserAccountLoginProviderData = TableRegistry::get('UserAccountLoginProviderData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountLoginProviderData);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {

		$v = new \Cake\Validation\Validator();

        $res = $this->UserAccountLoginProviderData->validationDefault($v);

        $this->assertTrue(($res->field("id") instanceof \Cake\Validation\ValidationSet));
        $this->assertTrue(($res->field("provider") instanceof \Cake\Validation\ValidationSet));
        $this->assertTrue(($res->field("key_name") instanceof \Cake\Validation\ValidationSet));
        $this->assertTrue(($res->field("key_value") instanceof \Cake\Validation\ValidationSet));

    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $r = new \Cake\ORM\RulesChecker();

        $r = $this->UserAccountLoginProviderData->buildRules($r);

        $this->assertTrue(($r instanceof \Cake\ORM\RulesChecker));
    }

    /**
     * Test locateAccount method
     *
     * @return void
     */
    public function testLocateAccount()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
