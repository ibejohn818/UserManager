<?php
namespace UserManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Error\FatalErrorException;

/**
 * UserAccountLoginProviderData Model
 *
 * @property \UserManager\Model\Table\UserAccountsTable|\Cake\ORM\Association\BelongsTo $UserAccounts
 *
 * @method \UserManager\Model\Entity\UserAccountLoginProviderData get($primaryKey, $options = [])
 * @method \UserManager\Model\Entity\UserAccountLoginProviderData newEntity($data = null, array $options = [])
 * @method \UserManager\Model\Entity\UserAccountLoginProviderData[] newEntities(array $data, array $options = [])
 * @method \UserManager\Model\Entity\UserAccountLoginProviderData|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \UserManager\Model\Entity\UserAccountLoginProviderData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \UserManager\Model\Entity\UserAccountLoginProviderData[] patchEntities($entities, array $data, array $options = [])
 * @method \UserManager\Model\Entity\UserAccountLoginProviderData findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserAccountLoginProviderDataTable extends Table
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

        $this->setTable('user_account_login_provider_data');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->allowEmpty('provider');

        $validator
            ->allowEmpty('key_name');

        $validator
            ->allowEmpty('key_value');

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


	public function locateAccount(array $conditions, \UserManager\Model\Entity\UserAccount $userAccount, array $loginData)

	{

		if(count($loginData)<=0) {
			throw new FatalErrorException("you must provide loginData entities");
		}

        foreach($loginData as $k=>$v) {
            if(!($v instanceof \UserManager\Model\Entity\UserAccountLoginProviderData)) {
                throw new FatalErrorException("loginData must be UserDataLoginProviderData entities");
            }
        }

		if(empty($userAccount->email)) {
			throw new FatalErrorException("userAccount->email must be set!");
		}

		$account = $this->find()
						->select(['user_account_id'])
						->where($conditions)
						->first();

		if(!isset($account->user_account_id)
			|| !($account_id = $account->user_account_id)
		) {
			$account_id = $this->UserAccounts->locateLoginProviderAccount(
				$userAccount->email,
				$userAccount
			)->id;
		}

        foreach($loginData as $k=>$v) {
            $loginData[$k]->user_account_id = $account_id;
        }

		$this->deleteAll([
			'user_account_id'=>$account_id,
			'provider'=>$loginData[0]['provider']
		]);

		$this->saveMany($loginData);

        return $this->UserAccounts->authenticateUser(['UserAccounts.id'=>$account_id]);

    }
}
