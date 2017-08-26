<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UserManager\Model\Table\UserCommentsTable;

/**
 * UserManager\Model\Table\UserCommentsTable Test Case
 */
class UserCommentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserCommentsTable
     */
    public $UserComments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_comments',
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
        $config = TableRegistry::exists('UserComments') ? [] : ['className' => UserCommentsTable::class];
        $this->UserComments = TableRegistry::get('UserComments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserComments);

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
