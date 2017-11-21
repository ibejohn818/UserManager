<?php

namespace UserManager\Test\TestCase\Auth;

use UserManager\Auth\UserAccountAuthorize;
use UserManager\Model\Table\UserAccountsTable;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class UserAccountAuthorizeTest extends TestCase
{


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

    public $UserAccountsTable;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserAccounts') ? [] : ['className' => UserAccountsTable::class];
        $this->UserAccountsTable = TableRegistry::get('UserAccounts', $config);
        \Cake\Cache\Cache::disable();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountsTable);

        parent::tearDown();
    }

    private function getUser($id)
    {
        $user = $this->UserAccountsTable->authenticationUser(['UserAccounts.id'=>$id]);
        return $user;
    }

    public function testAuthorize()
    {

        $req = new \Cake\Http\ServerRequest();
        $req->params['plugin'] = "UserManager";
        $req->params['controller'] = "UserAccounts";
        $req->params['action'] = "edit";
        $req->params['prefix'] = "Admin";

        $resp = new \Cake\Http\Response();

        $reg = new \Cake\Controller\ComponentRegistry();

        $auth = new UserAccountAuthorize($reg);

        $user = $this->getUser(1);

        $res =  $auth->authorize($user, $req, $resp);

        $this->assertTrue($res);

        $user = $this->getUser(10);

        $res =  $auth->authorize($user, $req, $resp);

        $this->assertFalse($res);
    }

}
