<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Cache\Cache;
use UserManager\Model\Table\UserAccountPermissionsTable;

/**
 * UserManager\Model\Table\UserAccountPermissionsTable Test Case
 */
class UserAccountPermissionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserAccountPermissionsTable
     */
    public $UserAccountPermissions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.user_manager.user_account_permissions',
        'plugin.user_manager.user_account_groups',
        'plugin.user_manager.user_account_group_assignments',
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_account_custom_fields',
        'plugin.user_manager.user_account_login_provider_data',
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
        $config = TableRegistry::exists('UserAccountPermissions') ? [] : ['className' => UserAccountPermissionsTable::class];
        $this->UserAccountPermissions = TableRegistry::get('UserAccountPermissions', $config);
        Cache::disable();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountPermissions);

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

        $res = $this->UserAccountPermissions->validationDefault($v);

        $this->assertTrue(($res->field("id") instanceof \Cake\Validation\ValidationSet));

        $this->assertTrue(($res->field("allowed") instanceof \Cake\Validation\ValidationSet));

        $this->assertTrue(($res->field("plugin") instanceof \Cake\Validation\ValidationSet));

        $this->assertTrue(($res->field("controller") instanceof \Cake\Validation\ValidationSet));

        $this->assertTrue(($res->field("action") instanceof \Cake\Validation\ValidationSet));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {

        $r = new \Cake\ORM\RulesChecker();

        $r = $this->UserAccountPermissions->buildRules($r);

        $this->assertTrue(($r instanceof \Cake\ORM\RulesChecker));

    }

    /**
     * Test parseUserPermissionRequest method
     *
     * @return void
     */
    public function testParseUserPermissionRequest()
    {

        $user = [
            'id'=>1,
            'user_account_groups'=>[
                [
                    'id'=>2
                ]
            ]
        ];


        $req = new \Cake\Http\ServerRequest();

        $req->params['controller'] = "UserAccounts";
        $req->params['action'] = "edit";
        $req->params['plugin'] = "UserManager";
        $req->params['prefix'] = "admin";

        $res = $this->UserAccountPermissions->parseUserPermissionRequest(
            $user,
            $req
        );

        $this->assertTrue($res);

        //test user deny
        $user = [
            'id'=>10,
            'user_account_groups'=>[
                0
            ]
        ];


        $res = $this->UserAccountPermissions->parseUserPermissionRequest(
            $user,
            $req
        );

        $this->assertFalse($res);


        //test group deny
        $user = [
            'id'=>2,
            'user_account_groups'=>[
                [
                    'id'=>1
                ]
            ]
        ];


        $res = $this->UserAccountPermissions->parseUserPermissionRequest(
            $user,
            $req
        );

        $this->assertFalse($res);

    }

    /**
     * Test parseUserPermission method
     *
     * @return void
     */
    public function testParseUserPermission()
    {

        //test group deny
        $user = [
            'id'=>10,
            'user_account_groups'=>[
                [
                    'id'=>0
                ]
            ]
        ];


        $c = "UserAccounts";
        $a = "edit";
        $pl = "UserManager";
        $pr = "admin";

        $res = $this->UserAccountPermissions->parseUserPermission(
            $user,
            $c,
            $a,
            $pl,
            $pr
        );

        $this->assertFalse($res);

    }

    /**
     * Test checkGroupPermission method
     *
     * @return void
     */
    public function testCheckGroupPermission()
    {

        $id = 2;

        $res = $this->UserAccountPermissions->checkGroupPermission(
            $id,
            "UserAccounts",
            "index",
            "UserManager",
            "Admin"
        );

        $this->assertTrue($res);

    }

    /**
     * Test checkUserPermission method
     *
     * @return void
     */
    //public function testCheckUserPermission()
    //{
        //$this->markTestIncomplete('Not implemented yet.');
    //}

    /**
     * Test getPermissionRows method
     *
     * @return void
     */
    //public function testGetPermissionRows()
    //{
        //$this->markTestIncomplete('Not implemented yet.');
    //}
}
