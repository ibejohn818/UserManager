<?php

namespace UserManager\Test\TestCase\Auth;

use UserManager\Auth\GoogleProvider;
use Cake\TestSuite\TestCase;

class GoogleProviderTest extends TestCase
{



    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        //$config = TableRegistry::exists('UserAccounts') ? [] : ['className' => UserAccountsTable::class];
        //$this->UserAccountsTable = TableRegistry::get('UserAccounts', $config);
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

    public function testInit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

}
