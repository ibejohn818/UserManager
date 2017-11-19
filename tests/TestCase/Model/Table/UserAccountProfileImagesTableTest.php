<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use UserManager\Model\Table\UserAccountProfileImagesTable;

/**
 * UserManager\Model\Table\UserAccountProfileImagesTable Test Case
 */
class UserAccountProfileImagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserAccountProfileImagesTable
     */
    public $UserAccountProfileImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_account_profile_images',
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_account_custom_fields',
        'plugin.user_manager.user_account_login_provider_data',
        'plugin.user_manager.user_account_groups',
        'plugin.user_manager.user_account_group_assignments',
        'plugin.user_manager.user_account_permissions',
        'plugin.user_manager.user_account_passwds',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserAccountProfileImages') ? [] : ['className' => UserAccountProfileImagesTable::class];
        $this->UserAccountProfileImages = TableRegistry::get('UserAccountProfileImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountProfileImages);

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

        $res = $this->UserAccountProfileImages->validationDefault($v);

        $this->assertTrue(($res->field("id") instanceof \Cake\Validation\ValidationSet));
        $this->assertTrue(($res->field("image_source") instanceof \Cake\Validation\ValidationSet));
        $this->assertTrue(($res->field("file_name") instanceof \Cake\Validation\ValidationSet));

    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $r = new \Cake\ORM\RulesChecker();

        $r = $this->UserAccountProfileImages->buildRules($r);

        $this->assertTrue(($r instanceof \Cake\ORM\RulesChecker));
    }

    /**
     * Test setAsDisplay method
     *
     * @return void
     */
    public function testSetAsDisplay()
    {

        $img = $this->UserAccountProfileImages->find()
                            ->where([
                                'id'=>2
                            ])->first();

        $res = $this->UserAccountProfileImages->setAsDisplay($img);

        $this->assertTrue($res->active);
    }
}
