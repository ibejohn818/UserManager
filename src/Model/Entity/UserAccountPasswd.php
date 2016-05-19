<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAccountPasswd Entity.
 */
class UserAccountPasswd extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'passwd' => true,
        'user_account_id' => true,
        'user_account' => true,
    ];
}
