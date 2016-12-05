<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAccountForeignCredential Entity.
 * @property $id int
 * @property $user_account_id int
 * @property $user_account \UserManager\Model\Entity\UserAccount;
 * @property $param1 string
 * @property $param2 string
 * @property $param3 string
 * @property $param4 string
 * @property $oauth_token string
 * @property $oauth_secret string
 * @property $service_name string
 */
class UserAccountForeignCredential extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
		"*"=>true,
		'id'=>false
    ];
}
