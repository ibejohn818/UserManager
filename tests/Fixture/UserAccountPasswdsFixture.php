<?php
namespace UserManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;
use Cake\Auth\DefaultPasswordHasher;
/**
 * UserAccountPasswdsFixture
 *
 */
class UserAccountPasswdsFixture extends TestFixture
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
        'passwd' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'user_account_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
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
        //[
            //'id' => 1,
            //'created' => '2017-11-16 18:13:01',
            //'passwd' => 'Lorem ipsum dolor sit amet',
            //'user_account_id' => 1
        //],
    ];

    public function init()
    {

        $this->records[] = [
            'id' => 1,
            'created' => '2017-11-16 18:13:01',
            'passwd' => (new DefaultPasswordHasher)->hash("password"),
            'user_account_id' => 1
        ];

        $this->records[] = [
            'id' => 2,
            'created' => '2017-11-16 18:13:01',
            'passwd' => (new DefaultPasswordHasher)->hash("password"),
            'user_account_id' => 10
        ];
        parent::init();
    }
}
