<?php

namespace Usermanager\Test\TestCase\Event;

use Cake\TestSuite\TestCase;
use UserManager\Event\AuthEvent;


class AuthEventTest extends TestCase
{


    public function setUp()
    {
        parent::setUp();
    }


    public function tearDown()
    {
        parent::tearDown();
    }

    public function testConstruct()
    {

        $mockProvider = $this->getMockBuilder("\UserManager\Auth\Provider\Google")
                    ->getMock();

        $creds = [];

        $event = new AuthEvent("AuthEvent", $this, $creds, $mockProvider);

        $this->assertTrue(($event instanceof \Cake\Event\Event));

    }

}
