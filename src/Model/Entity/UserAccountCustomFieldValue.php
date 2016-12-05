<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAccountCustomFieldValue Entity.
 */
class UserAccountCustomFieldValue extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
		'*'=>true,
		'id'=>false
    ];
}
