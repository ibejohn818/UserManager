<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\ORM\RulesChecker;
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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $v = new \Cake\Validation\Validator();

        $res = $this->UserAccountCustomFields->validationDefault($v);

        $this->assertEquals($res->field("active")->rules()['valid']->get("rule"), "boolean");

        $this->assertEquals($res->field("visible")->rules()['valid']->get("rule"), "boolean");

        $this->assertEquals($res->field("display_weight")->rules()['valid']->get("rule"), "numeric");

        $this->assertTrue(($res->field("name") instanceof \Cake\Validation\ValidationSet));

        $this->assertTrue(($res->field("field_type") instanceof \Cake\Validation\ValidationSet));

        $this->assertTrue(($res->field("field_options") instanceof \Cake\Validation\ValidationSet));

    }

    /**
     * Test validationCreate method
     *
     * @return void
     */
    public function testValidationCreate()
    {
        $v = new \Cake\Validation\Validator();

        $res = $this->UserAccountCustomFields->validationCreate($v);

        $this->assertTrue(($res->field("slug") instanceof \Cake\Validation\ValidationSet));

        $this->assertTrue(($res->field("name") instanceof \Cake\Validation\ValidationSet));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $r = new RulesChecker();

        $r = $this->UserAccountCustomFields->buildRules($r);

        $this->assertTrue(($r instanceof RulesChecker));

    }

    public function testUniqueSlug()
    {

        $context = [
            'data'=>[
                'id'=>'5'
            ]
        ];

        $value = "GENDER";

        $chk = $this->UserAccountCustomFields->uniqueSlug($value, $context);

        $this->assertFalse($chk);

        $context = [
            'data'=>['id'=>1]
        ];

        $chk = $this->UserAccountCustomFields->uniqueSlug($value, $context);

        $this->assertTrue($chk);

    }



    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $e = $this->UserAccountCustomFields->find()->where(['id'=>1])->first();

        $res = $this->UserAccountCustomFields->delete($e);

        $this->assertTrue($res);
    }
}
