<?php

namespace UserManager\Test\TestCase\Auth\Provider;

use UserManager\Auth\Provider\Facebook;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

class FacebookTest extends TestCase
{

    public $fixtures = [
        'plugin.user_manager.user_account_permissions',
        'plugin.user_manager.user_account_groups',
        'plugin.user_manager.user_account_group_assignments',
        'plugin.user_manager.user_accounts',
        'plugin.user_manager.user_account_custom_field_values',
        'plugin.user_manager.user_account_custom_fields',
        'plugin.user_manager.user_account_login_provider_data',
        'plugin.user_manager.user_account_passwds',
        'plugin.user_manager.user_account_profile_images',
    ];

    public function setUp()
    {
        parent::setUp();
    }


    public function tearDown()
    {
        parent::tearDown();
    }


    public function testGetUrl()
    {

        $_SERVER['HTTPS'] = 'on';
        $_SERVER['HTTP_HOST'] = 'test.com';

        $fb = new Facebook();

        $url = $fb->getLoginUrl();

        $this->assertEquals(substr($url, 0, 5), "https");

    }

}
