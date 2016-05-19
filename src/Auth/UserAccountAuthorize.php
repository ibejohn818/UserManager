<?php

namespace UserManager\Auth;

use Cake\Auth\BaseAuthorize;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;

class UserAccountAuthorize extends BaseAuthorize {

    public function authorize($user, Request $request) {

        $UserPermission = TableRegistry::get("UserManager.UserAccountPermissions");
        
        return $UserPermission->parseUserPermission($user,$request);

    }

}
