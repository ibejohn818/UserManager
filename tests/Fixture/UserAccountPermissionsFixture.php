<?php
namespace UserManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserAccountPermissionsFixture
 *
 */
class UserAccountPermissionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'allowed' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'weight' => ['type' => 'integer', 'length' => 3, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'user_account_group_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_account_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'prefix' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'plugin' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'controller' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'action' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 1,
            'user_account_group_id' => 1,
            'user_account_id' => null,
            'prefix' => null,
            'plugin' => 'Test',
            'controller' => 'Test',
            'action' => 'index',
            'weight'=>0
        ],
        [
            'id' => 2,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 1,
            'user_account_group_id' => 2,
            'user_account_id' => null,
            'prefix' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
            'weight'=>0
        ],
        [
            'id' => 3,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 1,
            'user_account_group_id' => 1,
            'user_account_id' => 10,
            'prefix' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
            'weight'=>0

        ],
        [        //deny user 2 Admin::UserManager::UserAccounts::edit
            'id' => 4,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 0,
            'user_account_group_id' => null,
            'user_account_id' => 10,
            'prefix' => 'Admin',
            'plugin' => 'UserManager',
            'controller' => 'UserAccounts',
            'action' => 'edit',
            'weight'=>0

        ],
        [         //deny usergroup 1 Admin:UserManager::UserAccounts::edit
            'id' => 5,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 0,
            'user_account_group_id' => 1,
            'user_account_id' => null,
            'prefix' => 'Admin',
            'plugin' => 'UserManager',
            'controller' => 'UserAccounts',
            'action' => 'edit',
            'weight'=>0
        ],
        [ //allow group 1
            'id' => 6,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 1,
            'user_account_group_id' => 1,
            'user_account_id' => null,
            'prefix' => 'Admin',
            'plugin' => 'UserManager',
            'controller' => 'UserAccounts',
            'action' => 'edit',
            'weight'=>0
        ],
        [ //allow group 3 but user attached to 3 denied
            'id' => 7,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 1,
            'user_account_group_id' => 3,
            'user_account_id' => null,
            'prefix' => 'Admin',
            'plugin' => 'UserManager',
            'controller' => 'UserAccounts',
            'action' => 'edit'
        ],
        [ //denied group but allow user
            'id' => 8,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 1,
            'user_account_group_id' => 4,
            'user_account_id' => null,
            'prefix' => null,
            'plugin' => 'UserManager',
            'controller' => 'NoController',
            'action' => 'index',
            'weight'=>0
        ],
        [ //denied group but allow user
            'id' => 9,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 1,
            'user_account_group_id' => null,
            'user_account_id' => 15,
            'prefix' => 'Admin',
            'plugin' => 'UserManager',
            'controller' => 'UserAccounts',
            'action' => 'edit',
            'weight'=>0
        ],
    ];

    public function init()
    {


        parent::init();

    }

}
