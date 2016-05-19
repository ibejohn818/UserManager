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
        'user_account_id' => true,
        'user_account_custom_field_id' => true,
        'field_value' => true,
        'user_account' => true,
        'user_account_custom_field' => true,
    ];
}
