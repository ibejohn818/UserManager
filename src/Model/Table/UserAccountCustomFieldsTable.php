<?php
namespace UserManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use UserManager\Model\Entity\UserAccountCustomField;

/**
 * UserAccountCustomFields Model
 */
class UserAccountCustomFieldsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('user_account_custom_fields');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('UserAccountCustomFieldValues', [
            'foreignKey' => 'user_account_custom_field_id',
            'className' => 'UserManager.UserAccountCustomFieldValues'
        ]);
        $this->hasOne('UserValue',[
            'className'=>'UserManager.UserAccountCustomFieldValues',
            'foreignKey'=>'user_account_custom_field_id'
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
            ->allowEmpty('name');

        $validator
            ->allowEmpty('field_type');

        $validator
            ->allowEmpty('field_options');

        $validator
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('active');

        $validator
            ->add('display_weight', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('display_weight');

        $validator
            ->add('visible', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('visible');

        return $validator;
	}

	public function validationCreate(Validator $v)
	{

		$v->requirePresence("slug")
            ->notEmpty("slug","Slug cannot be left emtpy")
            ->add('slug','slug_unique',[
                'rule' => 'uniqueSlug',
                'message'=>'Slug much be unique',
                'provider'=>'table'
			]);

		$v->requirePresence("name")
			->notEmpty("name","Name cannot be left emtpy");

		return $v;

	}

    public function uniqueSlug($value, array $context=[])
    {

        $conds = [
            'slug'=>$value
        ];

        if(isset($context['data']['id'])) {
            $conds['id !='] = $context['data']['id'];
        }

        $chk = $this->find()->where($conds)->count();

        if($chk<=0) {
            return true;
        }

        return false;

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
		$rules->add($rules->isUnique(['slug'],'Slug already in use'));
        return $rules;
    }

	public function delete(\Cake\Datasource\EntityInterface $field, $options = [])
	{

		$this->UserValue->deleteAll(['user_account_custom_field_id'=>$field->id]);

		return parent::delete($field);


	}

}
