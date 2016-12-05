<?php
namespace UserManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

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
        [
            'id' => 1,
            'created' => '2015-08-24 22:47:30',
            'passwd' => '$2y$10$IdbKLS0i6Mt/pnhLdjMlTeHZfqu8NL3vQI1GR3wS4bOrYgffaspnW',
            'user_account_id' => 1
        ],
        [
            'id' => 2,
            'created' => '2015-08-25 10:13:48',
            'passwd' => '$2y$10$SjWGH4xKlJvzZnwZAy0qp..GD3LwPS2s7o6hI/mghZLtyTRssxnlG',
            'user_account_id' => 2
        ],
        [
            'id' => 3,
            'created' => '2016-07-27 21:56:13',
            'passwd' => '$2y$10$KzcAi3VdrR0ar1L/FxwgruOW4ftoGpwEhu9XKKyFw1ZVNAKyw9h7i',
            'user_account_id' => 1
        ],
    ];
}
