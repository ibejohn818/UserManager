<?php
namespace UserManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserAccountCustomFieldsFixture
 *
 */
class UserAccountCustomFieldsFixture extends TestFixture
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
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'field_type' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'field_options' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'display_weight' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'visible' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
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
            'created' => '2017-11-16 18:11:19',
            'modified' => '2017-11-16 18:11:19',
            'name' => 'Gender',
            'field_type' => 'select',
            'field_options' => 'male:Make\nfemale:Female',
            'active' => 1,
            'display_weight' => 1,
            'visible' => 1,
            'slug' => 'GENDER'
        ],
        [
            'id' => 2,
            'created' => '2017-11-16 18:11:19',
            'modified' => '2017-11-16 18:11:19',
            'name' => 'Hidden',
            'field_type' => 'text',
            'field_options' => '',
            'active' => 1,
            'display_weight' => 2,
            'visible' => 0,
            'slug' => 'HIDDEN'
        ],
    ];
}
