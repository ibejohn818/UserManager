<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAccountGroup Entity.
 */
class UserAccountGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        "id" => true,
        'name' => true,
        'user_account_group_assignments' => true,
        'user_account_permissions' => true,
    ];
}
