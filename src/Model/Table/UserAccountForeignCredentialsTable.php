<?php
namespace UserManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use UserManager\Model\Entity\UserAccountForeignCredential;
use UserManager\Model\Entity\UserAccount;
/**
 * UserAccountForeignCredentials Model
 *
 * @property \Cake\ORM\Association\BelongsTo $UserAccounts
 */
class UserAccountForeignCredentialsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('user_account_foreign_credentials');
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('service_name');

        $validator
            ->allowEmpty('param1');

        $validator
            ->allowEmpty('param2');

        $validator
            ->allowEmpty('param3');

        $validator
            ->allowEmpty('param4');

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


    public function locateAccount(array $conditions, UserAccount $userAccount, UserAccountForeignCredential $userAccountCredential) {

        $account = $this->find()
                    ->select([
                        'id','user_account_id'
                    ])
                    ->where($conditions)
                    ->first();

        if(!isset($account->id)) {

            $account = $this->UserAccounts->locateForeignAccount($userAccount->email,$userAccount);

            $userAccountCredential->set('user_account_id',$account->id);

            $userAccountCredential = $this->save($userAccountCredential);

            return $this->locateAccount($conditions,$account,$userAccountCredential);

        }

        //update the users foreign credential data
        $userAccountCredential->set("id",$account->id);

        $this->save($userAccountCredential);

        return $this->UserAccounts->authenticateUser(['UserAccounts.id'=>$account->user_account_id]);

    }

}
