<?php
namespace UserManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserAccountProfileImagesFixture
 *
 */
class UserAccountProfileImagesFixture extends TestFixture
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
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'file_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'image_source' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'user_account_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
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
            'created' => '2017-11-16 18:13:49',
            'modified' => '2017-11-16 18:13:49',
            'active' => 1,
            'file_name' => 'one.jpg',
            'image_source' => 'Lorem ipsum dolor sit amet',
            'user_account_id' => 1
        ],
        [
            'id' => 2,
            'created' => '2017-11-16 18:13:49',
            'modified' => '2017-11-16 18:13:49',
            'active' => 0,
            'file_name' => 'two.jpg',
            'image_source' => 'Lorem ipsum dolor sit amet',
            'user_account_id' => 1
        ],
        [
            'id' => 3,
            'created' => '2017-11-16 18:13:49',
            'modified' => '2017-11-16 18:13:49',
            'active' => 1,
            'file_name' => 'Lorem ipsum dolor sit amet',
            'image_source' => 'Lorem ipsum dolor sit amet',
            'user_account_id' => 10
        ],
    ];
}
