<?php
namespace UserManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use UserManager\Model\Entity\UserAccountProfileImage;
use Cake\Core\Configure;

/**
 * UserAccountProfileImages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $UserAccounts
 */
class UserAccountProfileImagesTable extends Table
{

	/**
	* Initialize method
	*
	* @param array $config The configuration for the Table.
	* @return void
	*/
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->table('user_account_profile_images');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('UserAccounts', [
			'foreignKey' => 'user_account_id',
			'className' => 'UserManager.UserAccounts'
		]);
	}

	/**
	* Default validation rules.
	*
	* @param \Cake\Validation\Validator $validator Validator instance.
	* @return \Cake\Validation\Validator
	*/
	public function validationDefault(Validator $validator)
	{
		$validator
			->integer('id')
			->allowEmpty('id', 'create');

		$validator
			->allowEmpty('source');

		$validator
			->allowEmpty('file_name');

		return $validator;
	}

	/**
	* Returns a rules checker object that will be used for validating
	* application integrity.
	*
	* @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	* @return \Cake\ORM\RulesChecker
	*/
	public function buildRules(RulesChecker $rules)
	{
		$rules->add($rules->existsIn(['user_account_id'], 'UserAccounts'));
		return $rules;
	}


	/**
	 * Set and image as default updating all other images
	 * as not the default
	 * @param UserAccountProfileImage $image An account ID or UserAccountProfileImage entity
	 * @return bool Returns true if successful or false if failure
	 */
	public function setAsDisplay(UserAccountProfileImage $image) {

		//set all images default_image = 0
		$this->updateAll(
			['display_image'=>false],
			['user_account_id'=>$image->user_account_id]
		);

		$image->display_image = true;

		return $this->save($image);

	}


}
