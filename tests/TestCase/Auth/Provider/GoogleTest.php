<?php

namespace App\Test\TestCase\Auth\Provider;

use Cake\TestSuite\TestCase;


class GoogleTest extends TestCase
{

	public function setup()
	{
		parent::setup();

	}

	public function testOut()
	{
		$c = $this->getMockBuilder('UserManager\Shell\ConfigShell')
			->getMock();

		fwrite(STDERR,var_dump($c,true));
		fwrite(STDERR,var_dump(new \UserManager\Shell\ConfigShell(),true));

	}

	public function tearDown()
	{
		parent::tearDown();

	}
}
