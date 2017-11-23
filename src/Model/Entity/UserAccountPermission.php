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
        'id'=>false,
        '*'=>true,
    ];
}
