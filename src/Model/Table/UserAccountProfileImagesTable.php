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

	public function handleProfileImageUpload() {


	}


	public function createProfileImage($UserAccountID, $image, $imageSource,  $setAsDisplay = false) {

		//ensure we have an account
		$account = $this->UserAccounts->get($UserAccountID);

		//ensure the path to the image exists
		$path = WWW_ROOT.DS.Configure::read('UserManager.profileImageWwwPath').DS.$account->id;

		if(!is_dir($path)) {
			mkdir($path,0777,true);
		}

		//check if the imageSource is a url
		if(preg_match('/^http/i',$image)) {

			//download the image
			$client = new \Cake\Network\Http\Client();

			$res = $client->get($image);

			if(!$res) {
				return false;
			}

			//ensure the content type is an image
			if(!preg_match('/^image/i',$res->header("Content-Type"))) {
				return false;
			}

			//save a tmp image
			$tmpFileName = md5($imageSource);
			$tmpPath = TMP;
			if(!file_put_contents($tmpPath.DS.$tmpFileName,$res->body())) {
				return false;
			}

			$sha1 = sha1_file($tmpPath.DS.$tmpFileName);

			$img = $this->find()
						->where([
							'user_account_id'=>$account->id,
							'source'=>$imageSource,
							'sha1_file'=>$sha1
						]);
			if($img->count()>0) {
				return $img->first();
			}

			$ext = '';

			switch(strtolower($res->header("Content-Type"))) {

				case 'image/jpg':
				case 'image/jpeg':
					$ext = ".jpg";
					break;

				case 'image/png':
					$ext = ".png";
				break;

				case 'image/gif':
					$ext = ".gif";
				break;

				case 'image/bitmap':
					$ext = ".bmp";
				break;

			}

			$fileName = $tmpFileName.$ext;

			$entity = $this->newEntity([
				'user_account_id'=>$account->id,
				'sha1_file'=>$sha1,
				'file_name'=>$fileName,
				'source'=>$imageSource
			]);

			if(!rename($tmpPath.DS.$tmpFileName,$path.DS.$fileName)) {
				return false;
			}

			$profileImage =  $this->save($entity);

		}


		if($setAsDisplay) {
			$this->setAsDisplay($profileImage);
		}

		return $profileImage;

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
