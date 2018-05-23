<?php
namespace UserManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserComments Model
 *
 * @property \UserManager\Model\Table\UserAccountsTable|\Cake\ORM\Association\BelongsTo $UserAccounts
 * @property |\Cake\ORM\Association\BelongsTo $ParentUserComments
 * @property |\Cake\ORM\Association\HasMany $ChildUserComments
 *
 * @method \UserManager\Model\Entity\UserComment get($primaryKey, $options = [])
 * @method \UserManager\Model\Entity\UserComment newEntity($data = null, array $options = [])
 * @method \UserManager\Model\Entity\UserComment[] newEntities(array $data, array $options = [])
 * @method \UserManager\Model\Entity\UserComment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \UserManager\Model\Entity\UserComment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \UserManager\Model\Entity\UserComment[] patchEntities($entities, array $data, array $options = [])
 * @method \UserManager\Model\Entity\UserComment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class UserCommentsTable extends Table
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

        $this->setTable('user_comments');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('UserAccounts', [
            'foreignKey' => 'user_account_id',
            'className' => 'UserManager.UserAccounts'
        ]);
        $this->belongsTo('ParentUserComments', [
            'className' => 'UserManager.UserComments',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildUserComments', [
            'className' => 'UserManager.UserComments',
            'foreignKey' => 'parent_id'
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
            ->allowEmpty('model');

        $validator
            ->allowEmpty('foreign_key');

        $validator
            ->allowEmpty('title');

        $validator
            ->allowEmpty('comment');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentUserComments'));

        return $rules;
    }

	public function setTreeScope($model, $fk)
	{

		$this->behaviors()->Tree->config('scope',[
			'model'=>$model,
			'foreign_key'=>$fk
		]);

	}

	public function returnComments($model, $fk, $options = [])
	{

		$this->setTreeScope($model, $fk);

		$comments = $this->find('threaded',[
			'conditions'=>[
				'UserComments.model'=>$model,
				'UserComments.foreign_key'=>$fk
			],
			'order'=>[
				'UserComments.created'=>'DESC'
			],
			'contain'=>[
				'UserAccounts'
			]
		]);

		return $comments;

	}

	public function createComment(\UserManager\Model\Entity\UserComment $UserComment)
	{

		$this->setTreeScope($UserComment->model, $UserComment->foreign_key);

		return $this->save($UserComment);

	}

	public function createCommentTop(\UserManager\Model\Entity\UserComment $UserComment)
    {

		$this->setTreeScope($UserComment->model, $UserComment->foreign_key);

		$result = $this->save($UserComment);

        if ($result->parent_id<=0) {
            $count = $this->find()->where([
                'model'=>$result->model,
                'foreign_key'=>$result->foreign_key,
                'parent_id'=>null
            ])->count();
            $res = $this->moveUp($result, ($count-1));
        }

        return $result->id;

    }

    public function handleDelete($model, $fk, \UserManager\Model\Entity\UserComment $entity)
    {
        $this->setTreeScope($model, $fk);
        if (count($entity->children) > 0) {
            $entity->set('is_deleted', true);
            return $this->save($entity);
        } else {
            return $this->delete($entity);
        }
    }
}
