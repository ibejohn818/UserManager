<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAccountLoginProviderData Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $provider
 * @property string $key_name
 * @property string $key_value
 * @property int $user_account_id
 *
 * @property \UserManager\Model\Entity\UserAccount $user_account
 */
class UserAccountLoginProviderData extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
