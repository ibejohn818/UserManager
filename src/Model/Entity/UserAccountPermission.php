<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAccountPermission Entity.
 */
class UserAccountPermission extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'allowed' => true,
        'user_account_group_id' => true,
        'user_account_id' => true,
        'plugin' => true,
        'controller' => true,
        'action' => true,
        'user_account_group' => true,
        'user_account' => true,
    ];
}
