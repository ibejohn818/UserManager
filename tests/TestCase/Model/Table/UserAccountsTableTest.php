<?php
namespace UserManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Error\FatalErrorException;
use UserManager\Model\Table\UserAccountsTable;
use Cake\Auth\DefaultPasswordHasher;

/**
 * UserManager\Model\Table\UserAccountsTable Test Case
 */
class UserAccountsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Table\UserAccountsTable
     */
    public $UserAccountsTable;
    public $fa_id = false;
    /**
     * Fixtures
     *
     * @var array
     */
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
        unset($this->UserAccountsTable);

        parent::tearDown();
    }

    /**
     * Test generateId method
     *
     * @return void
     */
    public function testGenerateId()
    {
        $id = $this->UserAccountsTable->generateId(1, 3);

        $this->assertEquals($id, 3);
    }


    /**
     * Test findUsersCustomFields method
     *
     * @return void
     */
    public function testFindUsersCustomFields()
    {
        $query = $this->UserAccountsTable->find("UsersCustomFields");
        $sql = $query->sql();

        $this->assertTrue(strpos($sql, "Gender")>0);
        $this->assertFalse(strpos($sql, "Hidden"));
    }

    /**
     * Test customFieldsSchema method
     *
     * @return void
     */
    public function testCustomFieldsSchema()
    {
        $s = $this->UserAccountsTable->customFieldsSchema();

        $this->assertTrue(in_array("Gender", $s));
        $this->assertFalse(in_array("Hidden", $s));
    }

    /**
     * Test handleAccountRegistration method
     *
     * @return void
     */
    public function testHandleAccountRegistration()
    {

        $e = $this->UserAccountsTable->newEntity([
            'first_name'=>'Johnny',
            'last_name'=>'Five',
            'email'=>'new@email.com'
        ]);

        $res = $this->UserAccountsTable->handleAccountRegistration($e, 'password');

        $this->assertTrue($res->id>0);

        $ua = $this->UserAccountsTable->find()
            ->contain(['UserAccountGroups','UserAccountPasswds'])
            ->where(['id'=>$res->id])
            ->first();


        $this->assertTrue(!empty($ua->user_account_passwds[0]->id));
        $this->assertEquals('new@email.com', $ua->email);

        // test with duplicate email
        $e = $this->UserAccountsTable->newEntity([
            'first_name'=>'Johnny',
            'last_name'=>'Five',
            'email'=>'jhardy@test.com'
        ]);

        $res = $this->UserAccountsTable->handleAccountRegistration($e, 'password');

        $this->assertFalse($res);

        $dg = $this->UserAccountsTable->UserAccountGroups->find()->where(['id'=>1])->first();

        $dg->set('default_group', 0);

        $dg = $this->UserAccountsTable->UserAccountGroups->save($dg);

        $this->expectException(FatalErrorException::class);

        // test with duplicate email
        $e = $this->UserAccountsTable->newEntity([
            'first_name'=>'Johnny',
            'last_name'=>'Five',
            'email'=>'exception@test.com'
        ]);

        $res = $this->UserAccountsTable->handleAccountRegistration($e, 'password');


    }

    /**
     * Test createProfileUri method
     *
     * @return void
     */
    public function testCreateProfileUri()
    {

        $ua = $this->UserAccountsTable->find()
                    ->where(['id'=>1])
                    ->first();

        $uri = $this->UserAccountsTable->createProfileUri($ua);

        $this->assertEquals($uri, "john-hardy.html");

        $ua = $this->UserAccountsTable->newEntity([
            "first_name"=>'John',
            "last_name"=>'Test',
            "email"=>'backup@email.com'
        ]);

        $uri = $this->UserAccountsTable->createProfileUri($ua);

        $this->assertEquals($uri, "backup.html");

        $ua = $this->UserAccountsTable->newEntity([
            "first_name"=>'John',
            "last_name"=>'Test',
            "email"=>'jtest@email.com'
        ]);

        $uri = $this->UserAccountsTable->createProfileUri($ua);

        $this->assertEquals($uri, "jtest-2.html");
    }

    /**
     * Test authenticateUser method
     *
     * @return void
     */
    public function testAuthenticateUser()
    {
        // get first user
        $cond = [
            'UserAccounts.id'=>1
        ];

        $res = $this->UserAccountsTable->authenticateUser($cond, "password");

        $this->assertEquals($res['email'], "jhardy@test.com");
        $this->assertEquals($res['user_account_groups'][0]['name'], "Root");


        // test bad password
        $res = $this->UserAccountsTable->authenticateUser($cond, "aaaapassword");

        $this->assertFalse($res);

        $res = $this->UserAccountsTable->authenticateUser($cond);

        $this->assertEquals($res['email'], "jhardy@test.com");
        $this->assertEquals($res['user_account_groups'][0]['name'], "Root");

        // test bad ID
        $cond = [
            'UserAccounts.id'=>99999
        ];

        $res = $this->UserAccountsTable->authenticateUser($cond);

        $this->assertFalse($res);

        $cond = [
            'UserAccounts.id'=>2
        ];

        $res = $this->UserAccountsTable->authenticateUser($cond, "password");

        $this->assertFalse($res);


    }

    /**
     * Test authenticationUser method
     *
     * @return void
     */
    public function testAuthenticationUser()
    {
        $cond = [
            'UserAccounts.id'=>1
        ];

        $res = $this->UserAccountsTable->authenticationUser($cond);

        $this->assertEquals($res->email, "jhardy@test.com");


        $cond = [
            'UserAccounts.id'=>99999
        ];

        $res = $this->UserAccountsTable->authenticationUser($cond);

        $this->assertTrue(is_null($res));
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
     * Test confirmPassword method
     *
     * @return void
     */
    public function testConfirmPassword()
    {
        $c = [
            'data'=>[
                'passwd'=>'test'
            ]
        ];

        $pass = "test";

        $res = $this->UserAccountsTable->confirmPassword($pass, $c);

        $this->assertTrue($res);

        $pass = "wrong";

        $res = $this->UserAccountsTable->confirmPassword($pass, $c);

        $this->assertFalse($res);

        $res = $this->UserAccountsTable->confirmPassword($pass, []);

        $this->assertFalse($res);
    }

    /**
     * Test validationPassword method
     *
     * @return void
     */
    public function testValidationPassword()
    {
        $v = new \Cake\Validation\Validator();

        $res = $this->UserAccountsTable->validationPassword($v);

        $this->assertEquals($res->field("passwd_confirm")->rules()['passwordConfirm']->get("rule"),"confirmPassword");
    }

    /**
     * Test validationRegistration method
     *
     * @return void
     */
    public function testValidationRegistration()
    {
        $v = new \Cake\Validation\Validator();

        $res = $this->UserAccountsTable->validationRegistration($v);

        $this->assertEquals($res->field("first_name")->rules()['first_name']->get("rule"), "notBlank");

        $this->assertEquals($res->field("last_name")->rules()['last_name']->get("rule"), "notBlank");
    }

    public function testConfirmEmailMatch()
    {

        $email = 'testme@test.com';

        $c = [
                'data'=>[
                    'email'=>'testme@test.com'
                ]
            ];

        $res = $this->UserAccountsTable->confirmEmailMatch($email, $c);

        $this->assertTrue($res);

        $email = 'mis@test.com';

        $res = $this->UserAccountsTable->confirmEmailMatch($email, $c);

        $this->assertFalse($res);

        $res = $this->UserAccountsTable->confirmEmailMatch($email, []);

        $this->assertFalse($res);
    }


    /**
     * Test validationAdminEdit method
     *
     * @return void
     */
    public function testValidationAdminEdit()
    {
        $v = new \Cake\Validation\Validator();

        $res = $this->UserAccountsTable->validationAdminEdit($v);

        $this->assertEquals($res->field("profile_uri")->rules()['valid']->get("rule"),"confirmUniqueProfileUri");
    }

    /**
     * Test confirmUniqueProfileUri method
     *
     * @return void
     */
    public function testConfirmUniqueProfileUri()
    {
        $uri = "john.html";
        $c = [
                'data'=>[
                    'id'=>1
                ]
            ];

        $res = $this->UserAccountsTable->confirmUniqueProfileUri($uri, $c);

        $this->assertTrue($res);

        $c = [
                'data'=>[
                    'id'=>9999999
                ]
            ];

        $res = $this->UserAccountsTable->confirmUniqueProfileUri($uri, $c);

        $this->assertFalse($res);
    }

    /**
     * Test updatePassword method
     *
     * @return void
     */
    public function testUpdatePassword()
    {


        $pass = 'testme';

        $ua = $this->UserAccountsTable->newEntity([
            'first_name'=>'TestPass',
            'last_name'=>'TestPass',
            'email'=>'test@pass.com'
        ]);

        $ua = $this->UserAccountsTable->save($ua);

        $res = $this->UserAccountsTable->updatePassword($ua->id, $pass);

        $chk = $this->UserAccountsTable->UserAccountPasswds->find()
            ->where(['user_account_id'=>$ua->id])
            ->first();

        $this->assertTrue((new DefaultPasswordHasher)->check($pass, $chk->passwd));

    }


    /**
     * Test createLoginProviderAccount method
     *
     * @return void
     */
    public function testCreateLoginProviderAccount()
    {

        $dg = $this->UserAccountsTable->UserAccountGroups->find()->where(['id'=>1])->first();

        $dg->set('default_group', 1);

        $this->UserAccountsTable->UserAccountGroups->save($dg);

        $email = "test@newfor.com";

        $ua = $this->UserAccountsTable->newEntity([
            'first_name'=>'test_for',
            'last_name'=>'test_for',
            'email'=>$email
        ]);

        $res = $this->UserAccountsTable->createLoginProviderAccount($ua);

        $this->assertEquals($res->email, $email);
    }

    /**
     * Test locateLoginProviderAccount method
     *
     * @return void
     */
    public function testLocateLoginProviderAccount()
    {

        $email = 'test@for2.com';

        $ua = $this->UserAccountsTable->newEntity([
            'first_name'=>'TestPass',
            'last_name'=>'TestPass',
            'email'=>$email
        ]);

        $res = $this->UserAccountsTable->locateLoginProviderAccount($email, $ua);

        $this->assertEquals($res->email, $email);

        $ua = $this->UserAccountsTable->find()->where(['id'=>1])->first();

        $res = $this->UserAccountsTable->locateLoginProviderAccount($ua->email, $ua);

        $this->assertEquals($res->email, $ua->email);
    }


    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $ua = $this->UserAccountsTable->find()
            ->where([
                'id'=>10
            ])
            ->first();

        $res = $this->UserAccountsTable->delete($ua);

        $this->assertTrue($res);
    }


}
