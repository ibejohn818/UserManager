<?php
namespace UserManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserAccountGroupAssignmentsFixture
 *
 */
class UserAccountGroupAssignmentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_account_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_account_group_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
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
            'user_account_id' => 1,
            'user_account_group_id' => 2
        ],
        [
            'id' => 2,
            'user_account_id' => 2,
            'user_account_group_id' => 1
        ],
        [
            'id' => 3,
            'user_account_id' => 10,
            'user_account_group_id' => 3
        ],
        [
            'id' => 4,
            'user_account_id' => 15,
            'user_account_group_id' => 4
        ],
    ];
}
