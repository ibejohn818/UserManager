<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAccountForeignCredential Entity.
 */
class UserAccountForeignCredential extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'user_account_id' => true,
        'service_name' => true,
        'param1' => true,
        'param2' => true,
        'param3' => true,
        'param4' => true,
        'user_account' => true,
    ];
}
