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
            'action' => 'index'
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
            'action' => '*'
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
            'action' => '*'
        ],
        [        //deny user 2 Admin::UserManager::UserAccounts::edit
            'id' => 4,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 0,
            'user_account_group_id' => null,
            'user_account_id' => 10,
            'prefix' => 'admin',
            'plugin' => 'UserManager',
            'controller' => 'UserAccounts',
            'action' => 'edit'
        ],
        [         //deny usergroup 1 Admin:UserManager::UserAccounts::edit
            'id' => 5,
            'created' => '2017-11-16 18:14:22',
            'allowed' => 0,
            'user_account_group_id' => 1,
            'user_account_id' => null,
            'prefix' => 'admin',
            'plugin' => 'UserManager',
            'controller' => 'UserAccounts',
            'action' => 'edit'
        ],
    ];
}
