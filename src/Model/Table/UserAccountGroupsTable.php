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

    public function validationNewGroup(Validator $v)
    {
        $v->add('id', 'validate', [
            'rule'=> 'validateId',
            'message'=>'Group ID is already in use',
            'provider'=>'table'
        ]);

        $v->add('group_id', 'custom', [
            'rule'=>'validateCustomID',
            'provider'=>'table',
            'message'=>'Custom'
        ]);


        $v->requirePresence('name')
            ->notEmpty('name', 'Cannot be left empty')
        ->add('name', 'validate', [
            'rule'=>'validateDupe',
            'message'=>'Group name is already in use',
            'provider'=>'table'
        ]);

        $v->requirePresence('slug')
        ->notEmpty('slug', 'Cannot be left empty')
            ->add('slug', 'validate', [
            'rule'=>'validateDupe',
            'message'=>'Slug is already in use',
            'provider'=>'table'
        ]);
        return $v;
    }


    public function validationEditGroup(Validator $v)
    {

        $v->notEmpty('name', 'Cannot be left empty')
            ->add('name', 'validate', [
            'rule'=>'validateDupe',
            'message'=>'Group name is already in use',
            'provider'=>'table'
        ]);


        $v->notEmpty('slug', 'Cannot be left empty')
        ->add('slug', 'validate', [
            'rule'=>'validateDupe',
            'message'=>'Slug is already in use',
            'provider'=>'table'
        ]);

        return $v;
    }

    public function validateCustomID($check, $ctx = [])
    {
        die(print_r(func_get_args()));
    }

    public function validateDupe($check, array $c=[])
    {

        if (empty($check)) {
            return true;
        }

        $f = $c['field'];
        $cond = [
            $f=>$check
        ];

        if (isset($c['data']['id']) && !empty($c['data']['id'])) {
            $cond['id !='] = $c['data']['id'];
        }
        $chk = $this->find()
                    ->where($cond)
                    ->count();

        if ($chk > 0) {
            return "Group {$f} already in use";
        }

        return true;

    }

    public function validateId($check, array $context)
    {
        $chk = $this->find()->where(['id'=>$check])->count();

        if ($chk > 0) {
            return false;
        }

        return true;

    }

    public function delete(\Cake\Datasource\EntityInterface $entity, $options = [])
    {

        $group_id = $entity->id;
        if (!$group_id) {
            throw new \Cake\Network\Exception\NotAcceptableException('Invalid Entity!');
        }
        $query = [];
        //delete user>group association
        $query[] = "DELETE FROM  user_account_group_assignments where user_account_group_id = '{$group_id}'";
        //delete permissions
        $query[] = "DELETE FROM  user_account_permissions where user_account_group_id = '{$group_id}'";
        // delete the group
        $query[] = "DELETE FROM  user_account_groups where id = '{$group_id}'";
        $conn = $this->getConnection();

        $conn->begin();

        foreach($query as $q) {
            if(!$conn->execute($q)) {
                $conn->rollback();
                return false;
            }
        }
        $conn->commit();
        return true;

    }


}
