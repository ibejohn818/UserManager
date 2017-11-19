<?php
namespace UserManager\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use UserManager\Model\Entity\UserAccount;
use Cake\ORM\TableRegistry;
use UserManager\Model\Table\UserAccountsTable;

/**
 * UserManager\Model\Entity\UserAccount Test Case
 */
class UserAccountTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Entity\UserAccount
     */
    public $UserAccount;
    public $UserAccountsTable;

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
        $this->UserAccount = new UserAccount();
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
        unset($this->UserAccount);

        parent::tearDown();
    }

    /**
     * Test loadCustomFields method
     *
     * @return void
     */
    public function testLoadCustomFields()
    {

        $ua = $this->UserAccountsTable->find()
            ->where(['id'=>1])
            ->first();

        $ua->loadCustomFields(['UserAccountCustomFields.id >'=>0]);

        foreach($ua->custom_fields as $k=>$v) {
            switch($v->name) {

                case "Gender":
                    $this->assertEquals($v->user_value->field_value, "male");
                    break;
                case "Hidden":
                    $this->assertEquals($v->user_value->field_value, "hideme");
                    break;
            }
        }
    }
}
