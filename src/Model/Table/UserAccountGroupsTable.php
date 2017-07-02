<?php
namespace UserManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use UserManager\Model\Entity\UserAccountGroup;

/**
 * UserAccountGroups Model
 */
class UserAccountGroupsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('user_account_groups');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('UserAccountGroupAssignments', [
            'foreignKey' => 'user_account_group_id',
            'className' => 'UserManager.UserAccountGroupAssignments'
        ]);
        $this->hasMany('UserAccountPermissions', [
            'foreignKey' => 'user_account_group_id',
            'className' => 'UserManager.UserAccountPermissions'
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
            ->notEmpty('name');

        return $validator;
    }
}
