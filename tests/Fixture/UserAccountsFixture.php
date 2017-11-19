<?php
namespace UserManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserAccountsFixture
 *
 */
class UserAccountsFixture extends TestFixture
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
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'first_name' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'last_name' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'middle_name' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'profile_uri' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'username' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
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
            'created' => '2017-11-16 02:47:40',
            'modified' => '2017-11-16 02:47:40',
            'first_name' => 'John',
            'last_name' => 'Hardy',
            'middle_name' => 'Christopher',
            'active' => 1,
            'email' => 'jhardy@test.com',
            'profile_uri' => 'john.html',
            'username' => 'none'
        ],
        [
            'id' => 2,
            'created' => '2017-11-16 02:47:40',
            'modified' => '2017-11-16 02:47:40',
            'first_name' => 'John',
            'last_name' => 'Test',
            'middle_name' => 'Tester',
            'active' => 1,
            'email' => 'jtest@test.com',
            'profile_uri' => 'john-test.html',
            'username' => 'none'
        ],
        [
            'id' => 10,
            'created' => '2017-11-16 02:47:40',
            'modified' => '2017-11-16 02:47:40',
            'first_name' => 'John',
            'last_name' => 'Test10',
            'middle_name' => 'Tester',
            'active' => 1,
            'email' => 'jtest@test.com',
            'profile_uri' => 'jtest.html',
            'username' => 'none'
        ],
    ];
}
