<?php
namespace UserManager\Mailer;

use Cake\Mailer\Mailer;

/**
 * User mailer.
 */
class UserMailer extends Mailer
{

    /**
     * Mailer's name.
     *
     * @var string
     */
    static public $name = 'User';


    public function tester() {

    	$this
    		->to("john@johnchardy.com")
    		->subject("testing email system")
    		->emailFormat("html")
            ->from('john@johnchardy.com')
            ->template("UserManager.testers")
    		->transport("gmail");

    }

}
