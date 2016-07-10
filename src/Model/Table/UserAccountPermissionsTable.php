<?php
namespace UserManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use UserManager\Model\Entity\UserAccountPermission;
use Cake\Collection\Collection;
use Cake\Cache\Cache;
use Cake\Network\Request;

/**
 * UserAccountPermissions Model
 */
class UserAccountPermissionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('user_account_permissions');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('UserAccountGroups', [
            'foreignKey' => 'user_account_group_id',
            'className' => 'UserManager.UserAccountGroups'
        ]);
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
            ->add('allowed', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('allowed');

        $validator
            ->allowEmpty('plugin');

        $validator
            ->allowEmpty('controller');

        $validator
            ->allowEmpty('action');

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
        $rules->add($rules->existsIn(['user_account_group_id'], 'UserAccountGroups'));
        $rules->add($rules->existsIn(['user_account_id'], 'UserAccounts'));
        return $rules;
    }

    public function parseUserPermissionRequest($User, Request $request) {



        return $this->parseUserPermission($User,$request->params['controller'],
                                                $request->params['action'],
                                                $request->params['plugin'],
                                                (isset($request->params['prefix'])) ? $request->params['prefix']:false);

    }

    public function parseUserPermission($User, $Controller, $Action, $Plugin = false, $Prefix = false) {

        $token = "parse-user-perm-".md5(serialize(func_get_args()));
        $cacheKey = "user-manager-1min";

        if (($retVal = Cache::read($token,$cacheKey)) === false) {
            $userGroups = new Collection($User['user_account_groups']);
            // die(pr($User['user_account_groups']));
            $userGroupIds = $userGroups->extract("id")->toArray();

            $group = $this->checkGroupPermission($userGroupIds,
                                                $Controller,
                                                $Action,
                                                $Plugin,
                                                $Prefix
                                                );

            $userChk =  $this->checkUserPermission($User['id'],
                                                $Controller,
                                                $Action,
                                                $Plugin,
                                                $Prefix
                                            );

            $retVal = false;

            if($group && is_null($userChk)) { //if group has access and no users perms set

                $retVal = true;
            }

            if($group && !is_null($userChk) && !$userChk) { //if group has access and user is set to denied
                $retVal = false;
            }

            if(!$group && $userChk) { //if group doesn't have access and user does
                $retVal = true;
            }

            Cache::write($token,$retVal,$cacheKey);

        }

        return $retVal;
    }

    public function checkGroupPermission($UserGroupID, $Controller, $Action, $Plugin = false, $Prefix = false) {

        $groupConditions = [
            "user_account_group_id IN"=>$UserGroupID,
            "controller IN"=>["*",$Controller],
            "action IN"=>["*",$Action]
        ];

        if($Plugin && !empty($Plugin)) {
            $groupConditions['plugin IN'] = ["*",$Plugin];
        }

        if($Prefix && !empty($Prefix)) {
            $groupConditions['prefix IN'] = ["*",$Prefix];
        }

        $rows = $this->getPermissionRows($groupConditions);

        //default to false
        $allowed = false;

        if(count($rows)>0) {

            foreach ($rows as $k  => $v ) {
                $allowed = (bool)$v['allowed'];
            }
        }

        return $allowed;

    }

    public function checkUserPermission($UserID, $Controller, $Action, $Plugin = false, $Prefix = false) {

        $userConditions = [
            "user_account_id"=>$UserID,
            "controller IN"=>["*",$Controller],
            "action IN"=>["*",$Action]
        ];

        if($Plugin && !empty($Plugin)) {
            $userConditions['plugin IN'] = ["*",$Plugin];
        }

        if($Prefix && !empty($Prefix)) {
            $userConditions['prefix IN'] = ["*",$Prefix];
        }

        $rows = $this->getPermissionRows($userConditions);
        //default to false
        $allowed = false;

        if(count($rows)>0) {
            foreach ($rows as $k  => $v ) {
                $allowed =  (bool)$v['allowed'];
            }
            return $allowed;
        } else {
            return null;
        }

        return $allowed;

    }


    public function getPermissionRows($conditions, $cache = true) {

      $cacheKey = "user-manager-1min";

      $query = $this->find()
                   ->where($conditions)
                   ->order([
                       'allowed'=>'DESC'
                   ]);

      if($cache) {
        $query->cache(function ($q) {
            return "user-account-permisions-row-".md5(serialize($q->clause('where')));
        },$cacheKey);
      }



      return $query->toArray();

    }

}
