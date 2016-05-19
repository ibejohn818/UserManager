<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAccountCustomField Entity.
 */
class UserAccountCustomField extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'field_type' => true,
        'field_options' => true,
        'active' => true,
        'display_weight' => true,
        'visible' => true,
        'user_account_custom_field_values' => true,
        'user_value' => true
    ];

    protected static $_fieldTypes = [
        'text'=>'Text Field',
        'textarea'=>'Text Area',
        'select'=>'Select Field',
        'checkbox'=>'Checkbox',
        'radiogroup'=>'Radio Group'
    ];

    public static function fieldTypes() {

        return static::$_fieldTypes;

    }
}
