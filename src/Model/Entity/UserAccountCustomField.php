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
		'*'=>true,
		'id'=>false
    ];

    protected static $_fieldTypes = [
        'text'=>'Text Field',
        'textarea'=>'Text Area',
        'select'=>'Select List',
        'checkbox'=>'Checkbox',
        'radiogroup'=>'Radio Group'
    ];

    public static function fieldTypes() {

        return static::$_fieldTypes;

    }
}
