<?php
namespace UserManager\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use UserManager\Model\Entity\UserAccount;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Error\FatalErrorException;
use Cake\Utility\Inflector;

/**
 * UserAccounts Model
 */
class UserAccountsTable extends Table
{


    public $customFieldsSchema = [
            'UserAccounts.id',
            'UserAccounts.email',
            'UserAccounts.first_name',
            'UserAccounts.last_name',
            'UserAccounts.middle_name'
        ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('user_accounts');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('UserAccountCustomFieldValues', [
            'foreignKey' => 'user_account_id',
            'className' => 'UserManager.UserAccountCustomFieldValues'
        ]);
        $this->hasMany('UserAccountForeignCredentials', [
            'foreignKey' => 'user_account_id',
            'className' => 'UserManager.UserAccountForeignCredentials'
        ]);
        // $this->hasMany('UserAccountGroupAssignments', [
        //     'foreignKey' => 'user_account_id',
        //     'className' => 'UserManager.UserAccountGroupAssignments'
        // ]);
        $this->belongsToMany('UserAccountGroups',[
            'className'=>'UserManager.UserAccountGroups',
            // 'joinTable'=>'user_account_group_assignments',
            'through'=>'UserManager.UserAccountGroupAssignments'
        ]);
        $this->hasMany('UserAccountPasswds', [
            'foreignKey' => 'user_account_id',
            'className' => 'UserManager.UserAccountPasswds'
        ]);
        $this->hasMany('UserAccountPermissions', [
            'foreignKey' => 'user_account_id',
            'className' => 'UserManager.UserAccountPermissions'
        ]);
		$this->belongsTo("UserAccountProfileImages",[
			'className'=>'UserManager.UserAccountProfileImages',
			'foriegnKey'=>'user_account_id'
		]);
		$this->hasOne("ProfileImage",[
			'className'=>'UserManager.UserAccountProfileImages',
			'foreignKey'=>'user_account_id'
		]);
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
		$rules->add($rules->isUnique(['email'],'Email address already in use'));
        return $rules;
    }


    public function getLoginUser($email,$passwdHash)
    {

        $q = $this->find()
            ->contain([
                'UserAccountGroups',

            ]);

    }

    public function findUsersCustomFields(Query $q,array $options) {

        $UserAccountCustomFields = TableRegistry::get("UserManager.UserAccountCustomFields");

        $fields = $this->customFieldsSchema;

        $customFieldsFind = $UserAccountCustomFields->find()
                            ->where(["visible"=>1])->all();

        $customFields = [];

        foreach($customFieldsFind as $k=>$v) {
            $fields[$v->name] = $q->func()->max("IF(cf.name='{$v->name}',cv.field_value,NULL)");
        }

        $q->select($fields)
        ->join([
            'cv'=>[
                'table'=>'user_account_custom_field_values',
                'type'=>'LEFT',
                'conditions'=>'UserAccounts.id = cv.user_account_id'
            ],
            'cf'=>[
                'table'=>'user_account_custom_fields',
                'type'=>'LEFT',
                'conditions'=>'cf.id = cv.user_account_custom_field_id'
            ]
        ])
        ->group('UserAccounts.id');


        return $q;

    }

    public function customFieldsSchema() {

        $UserAccountCustomFields = TableRegistry::get("UserManager.UserAccountCustomFields");

        $fields = [
            'UserAccounts.id',
            'UserAccounts.email',
            'UserAccounts.first_name',
            'UserAccounts.last_name',
            'UserAccounts.middle_name'
        ];

        $customFieldsFind = $UserAccountCustomFields->find()
                            ->where(["visible"=>1])->all();

        foreach($customFieldsFind as $k=>$v) {
            $fields[] = $v->name;
        }

        return $fields;

    }

	public function handleAccountRegistration(UserAccount $userAccount, $passwd = false) {

        //get the default user groups

        $defaultGroups = $this->UserAccountGroups->find()->where(['UserAccountGroups.default'=>1]);

        if($defaultGroups->count()<=0) {
            throw new FatalErrorException("There are no default Account Groups specified to create accounts");
        }
        $userAccount->user_account_groups = [];

        foreach($defaultGroups as $k=>$v) {
            $userAccount->user_account_groups[] = $v;
        }

		//create a profile url from their email address
		$userAccount->profile_uri = $this->createProfileUri($userAccount);

		//set the account active
		$userAccount->active = 1;

		if(($userAccount = $this->save($userAccount)) === false) {
			return false;
		}

		//is there a password?
		if($passwd) {
			$this->updatePassword($userAccount->id,$passwd);
		}

		return $userAccount;


	}


	public function createProfileUri(UserAccount $userAccount,$attempts = 0) {

		$uri = "{$userAccount->first_name} {$userAccount->last_name}";

		$emailSplit = explode("@",$userAccount->email);

		$uri = $emailSplit[0];

		if($attempts>0) {
			$uri .= " {$emailSplit[1]}";
		}

		//slug the URI
		//$uri = Inflector::dasherize(Inflector::slug($uri));
		$uri = Inflector::dasherize($uri);
		$uri .= ".html";

		$chk = $this->find()
						->where(['profile_uri'=>$uri])
						->count();

		if($chk>0) {
			return $this->createProfileUri($userAccount,($attempts+1));
		}

		return $uri;

	}


    public function authenticateUser($conditions,$password = false,$options = [])
    {

        $q = $this->find();

        $q->contain([
            'UserAccountPasswds'=>[
                'finder'=>'LoginPasswd'
            ],
            'UserAccountGroups',
			'ProfileImage',
            'UserAccountForeignCredentials'=>[
                'sort'=>[
                    'UserAccountForeignCredentials.id'=>'DESC'
                ]
            ]
        ]);

        $q->where($conditions);

		$user = $q->first();

		if(!isset($user->id)) {
			return false;
		}

		$user = $user->toArray();


        if($password && $user['user_account_passwds'][0]) {
            $userPassword = $user['user_account_passwds'][0]['passwd'];
        } else {
            $userPassword = false;
        }

        unset($user['user_account_passwds']);

        if(!$password) {
            return $user;
        }

        if($password && $userPassword && ((new DefaultPasswordHasher)->check($password,$userPassword))) {
            return $user;
        }

        return false;

    }

    public function authenticationUser(array $conditions) {

        $find = $this->find()
                ->contain([
                    'UserAccountPasswd'=>[
                        'finder'=>'LoginPasswd'
                    ],
                    'UserAccountGroupAssignments'=>[
                        'UserAccountGroups'
                    ]
                ])
                ->where($conditions);

        return $find->first();

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
			->add('first_name','valid',['rule'=>'notBlank',
				'message'=>"First Name Cannot Be Empty"
			]);

        $validator
			->add('last_name','valid',[
				'rule'=>'notBlank',
				'message'=>"Last Name Cannot Be Empty"
			]);

        $validator
			->add('email','valid',[
				'rule'=>'email',
				'message'=>'EmailAddress is invalid'
			]);


        return $validator;
    }

    public function confirmPassword($value, array $context) {

       if(!isset($context['data']['passwd'])) {
            return false;
       }

       if($context['data']['passwd'] != $value) {
            return false;
       }

       return true;

    }


    public function validationPassword(Validator $validator) {

        $validator
                ->add('passwd_confirm','passwordConfirm',[
                    'rule'=>'confirmPassword',
                    'message'=>'Your passwords do not match',
                    'provider'=>'table'
                ]);

        return $validator;

    }

	public function validationRegistration(Validator $validator) {

		$validator = $this->validationDefault($validator);

		$validator
			->add("first_name","first_name",[
				'rule'=>"notBlank",
				'message'=>'First Name cannot be empty'
			])
			->add('last_name','last_name',[
				'rule'=>'notBlank',
				'message'=>'Last Name cannot be empty'
			])
			->add('email_confirm','email_confirm',[
				'rule' => function ($value, $context) use($validator) {
					if($value!=$context['data']['email']) {
						return false;
					}
					return true;
			},
			'message'=>'Email addreses do not match'
			]);

		$validator = $this->validationPassword($validator);

		return $validator;

	}

	public function validationAdminEdit(Validator $validator) {

		$validator = $this->validationDefault($validator);

		$validator
				->add("profile_uri","valid",[
					'rule'=>'confirmUniquieProfileUri',
					'message'=>"Profile URI already In Use, One has been suggested",
					'provider'=>'table'
				]);


		return $validator;
	}

	public function confirmUniqueProfileUri($value, $context = []) {

		return true;


	}

    public function updatePassword($UserAccountID, $password)
    {

        $userAccountPasswd = $this->UserAccountPasswds->newEntity([
            'user_account_id'=>$UserAccountID,
            'passwd'=>(new DefaultPasswordHasher)->hash($password)
        ]);

        return $this->UserAccountPasswds->save($userAccountPasswd);

    }

    public function locateForeignAccount($email,UserAccount $userAccount) {

        $account = $this->findByEmail($email)->contain(false)->first();

        if(!$account) {
            $account = $this->createForeignLoginAccount($userAccount);
        }

        return $account;

    }

    public function createForeignLoginAccount(UserAccount $userAccount) {

		$userAccount = $this->handleAccountRegistration($userAccount);

		return $userAccount;

    }


}
