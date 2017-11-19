<?php
namespace UserManager\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use UserManager\Model\Entity\UserAccountCustomField;

/**
 * UserManager\Model\Entity\UserAccountCustomField Test Case
 */
class UserAccountCustomFieldTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \UserManager\Model\Entity\UserAccountCustomField
     */
    public $UserAccountCustomField;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->UserAccountCustomField = new UserAccountCustomField();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccountCustomField);

        parent::tearDown();
    }

    /**
     * Test fieldTypes method
     *
     * @return void
     */
    public function testFieldTypes()
    {

        $types = UserAccountCustomField::fieldTypes();

        $this->assertTrue(array_key_exists("text", $types));
        $this->assertTrue(array_key_exists("textarea", $types));
        $this->assertTrue(array_key_exists("select", $types));
        $this->assertTrue(array_key_exists("checkbox", $types));
        $this->assertTrue(array_key_exists("radiogroup", $types));

    }
}
