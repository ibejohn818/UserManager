<?php 

namespace UserManager\Lib;

class Bootstrap {

    private static $_executed = false;

    public function __construct() {
        $this->_configure();
    }

    private function _configure()  {

        if(static::$_executed) {
            return;
        }

        if(Configure::check('UserManager.master_passwd')) {
            define("UMP_MASTER_PASSWD",Configure::consume("UserManager.master_passwd"));
        }

        static::$_executed = true;

    }

}