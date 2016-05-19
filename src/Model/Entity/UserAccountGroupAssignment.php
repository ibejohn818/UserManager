<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAccountGroupAssignment Entity.
 */
class UserAccountGroupAssignment extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'user_account_id' => true,
        'user_account_group_id' => true,
        'user_account' => true,
        'user_account_group' => true,
    ];



}
