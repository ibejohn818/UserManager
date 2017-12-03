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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {

        $v = new \Cake\Validation\Validator();

        $res = $this->UserComments->validationDefault($v);

        $this->assertTrue(($res->field("id") instanceof \Cake\Validation\ValidationSet));
        $this->assertTrue(($res->field("model") instanceof \Cake\Validation\ValidationSet));
        $this->assertTrue(($res->field("foreign_key") instanceof \Cake\Validation\ValidationSet));
        $this->assertTrue(($res->field("comment") instanceof \Cake\Validation\ValidationSet));

    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {

        $r = new \Cake\ORM\RulesChecker();

        $r = $this->UserComments->buildRules($r);

        $this->assertTrue(($r instanceof \Cake\ORM\RulesChecker));
    }

    /**
     * Test setTreeScope method
     *
     * @return void
     */
    public function testSetTreeScope()
    {
        $this->UserComments->setTreeScope("Test","999");

        $scope = $this->UserComments->behaviors()->Tree->config("scope");


        $this->assertEquals($scope['model'], "Test");
        $this->assertEquals($scope['foreign_key'], "999");
    }

    /**
     * Test returnComments method
     *
     * @return void
     */
    public function testReturnComments()
    {
        $comments = $this->UserComments->returnComments("model", "fk")->all()->toArray();

        $this->assertEquals(count($comments), 1);

        $this->assertEquals($comments[0]->model, "model");
        $this->assertEquals($comments[0]->foreign_key, "fk");

    }

    /**
     * Test createComment method
     *
     * @return void
     */
    public function testCreateComment()
    {

        $c = $this->UserComments->newEntity([
            'model'=>'Testing',
            'foreign_key'=>'10',
            'user_account_id'=>1,
            'comment'=>'testing'
        ]);

        $res = $this->UserComments->createComment($c);

        $this->assertTrue(($res instanceof \UserManager\Model\Entity\UserComment));

    }
}
