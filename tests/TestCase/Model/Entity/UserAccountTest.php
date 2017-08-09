<?php
namespace UserManager\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use UserManager\Model\Entity\UserAccount;

/**
 * UserManager\Model\Entity\UserAccount Test Case
 */
class UserAccountTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Entity\UserAccount
     */
    public $UserAccount;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->UserAccount = new UserAccount();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccount);

        parent::tearDown();
    }

    /**
     * Test loadCustomFields method
     *
     * @return void
     */
    public function testLoadCustomFields()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
