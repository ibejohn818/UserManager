<?php
namespace UserManager\Model\Table;

use UserManager\Model\Entity\UserAccountPasswdResetRequest;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Chronos\Chronos;
/**
 * UserAccountPasswdResetRequests Model
 *
 * @property \Cake\ORM\Association\BelongsTo $UserAccounts
 */
class UserAccountPasswdResetRequestsTable extends Table
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

        $this->table('user_account_passwd_reset_requests');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UserManager.UserAccounts', [
            'foreignKey' => 'user_account_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault__(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('expires', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('expires');

        $validator
            ->allowEmpty('sha1hash');

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

    public function validationResetpassword(Validator $validator) {


        $validator
			->notEmpty("email","Email cannot be empty")
			->add("email","valid",['rule'=>'email','message'=>'Invalid Email Address','last'=>true])
            ->add('email','custom',[
            'rule' => function ($value, $context) use($validator) {

                $find = $this->UserAccounts->find()
                        ->select(["id","email"])
                        ->contain(["UserAccountPasswds","UserAccountForeignCredentials"])
                        ->where(["email"=>$value])
                        ->first();

			   if(isset($find->id)) {
				   return true;
			   }

               return false;

            },
            'message'=>"Email address not associated with a valid account"
        ]);

        return $validator;

    }

	public function handlePasswordReset($EmailAddress,$minutesActive = 90) {

		//find the account
		$account = $this->UserAccounts
					->find()
					->contain(false)
					->where([
						'email'=>$EmailAddress
					])
					->first();

		if(!isset($account->id) || empty($account->id)) {
			return false;
		};

		$request = new UserAccountPasswdResetRequest();

		$request->user_account_id = $account->id;

		$request->sha1hash = sha1(serialize($account).uniqid());

		$expire = Chronos::parse("+{$minutesActive} Minutes");

		return $this->save($request);

	}



}
