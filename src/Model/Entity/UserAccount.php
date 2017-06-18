<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * UserAccount Entity.
 * @property $id int
 * @property $created DateTime
 * @property $modified DateTime
 * @property $first_name string
 * @property $last_name string
 * @property $email string
 * @property $active bool
 * @property $user_groups UserManager\Model\Entity\UserAccountGroup
 * @property $user_account_profile_images UserManager\Model\Entity\UserAccountProfileImage
 * @property $profile_image UserManager\Model\Eneityt\UserAccountProfileImage
 */
class UserAccount extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
		'*'=>true,
		'id'=>false,
		'custom_fields'=>true
    ];


    public function loadCustomFields(array $conditions = []) {

        $CustomFields = TableRegistry::get("UserManager.UserAccountCustomFields");

        $fields = $CustomFields->find()
                    ->contain([
                        'UserValue'=>[
                            'conditions'=>[
                                'UserValue.user_account_id'=>$this->id
                            ]
                        ]
                    ]);

		if(count($conditions)>0) {
			$fields->where($conditions);
		}

        foreach ($fields as $k => $v) {
            if(!($v->user_value instanceof \UserManager\Model\Entity\UserAccountCustomFieldValue)) {
                $v->user_value = new \UserManager\Model\Entity\UserAccountCustomFieldValue(['user_account_id'=>$this->id]);
            }
        }

        $this->custom_fields = $fields;
    }

}
