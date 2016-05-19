<?php
namespace UserManager\Controller\Admin;

use UserManager\Controller\AppController;

/**
 * UserAccounts Controller
 *
 * @property \UserManager\Model\Table\UserAccountsTable $UserAccounts
 */
class UserAccountsController extends AppController
{

    public function beforeFilter(\Cake\Event\Event $event) {

        parent::beforeFilter($event);

        // $this->Auth->deny();

    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {


		$this->paginate['limit'] = 2;

        $this->set('userAccounts', $this->paginate($this->UserAccounts));
        $this->set('_serialize', ['userAccounts']);


    }

    public function tester() {

        $customSchema = $this->UserAccounts->customFieldsSchema();

        $sortSchema = [];

        foreach($customSchema as $k=>$v) {
             $sortSchema[] = (!preg_match('/(\.)/',$v)) ? "`{$v}`":$v;
        }

        $this->paginate = [
            'sortWhitelist'=> $sortSchema
        ];

        $this->set("customFieldsSchema",$customSchema);

        $this->set('users',$this->paginate($this->UserAccounts->find('UsersCustomFields')));

    }

    /**
     * View method
     *
     * @param string|null $id User Account id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userAccount = $this->UserAccounts->get($id, [
            'contain' => ['UserAccountCustomFieldValues', 'UserAccountForeignCredentials', 'UserAccountGroupAssignments', 'UserAccountPasswds', 'UserAccountPermissions']
        ]);
        $this->set('userAccount', $userAccount);
        $this->set('_serialize', ['userAccount']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userAccount = $this->UserAccounts->newEntity();
        if ($this->request->is('post')) {
            $userAccount = $this->UserAccounts->patchEntity($userAccount, $this->request->data);
            if ($this->UserAccounts->save($userAccount)) {
                $this->Flash->success(__('The user account has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user account could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('userAccount'));
        $this->set('_serialize', ['userAccount']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Account id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userAccount = $this->UserAccounts->get($id, [
            'contain' => [
                'UserAccountCustomFieldValues',
                'UserAccountGroups'
            ]
        ]);
        $userAccount->loadCustomFields();
        if ($this->request->is(['patch', 'post', 'put'])) {
            // die(pr($this->request->data));
            $userAccount->user_account_groups = [];
            $userAccount = $this->UserAccounts->patchEntity($userAccount, $this->request->data,[
                'associated'=>[
                    'UserAccountCustomFieldValues',
                    'UserAccountGroups'
                ]
            ]);
            // die(pr($userAccount));
            if ($this->UserAccounts->save($userAccount)) {
                $this->Flash->success(__('The user account has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user account could not be saved. Please, try again.'));
            }
        }
        $this->selects();
        $this->set(compact('userAccount'));
        $this->set('_serialize', ['userAccount']);
    }

    private function selects() {

      $userGroups = $this->UserAccounts->UserAccountGroups->find('list')->order([
        'name'=>'ASC'
      ])->toArray();

      $this->set(compact("userGroups"));

    }

    /**
     * Delete method
     *
     * @param string|null $id User Account id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userAccount = $this->UserAccounts->get($id);
        if ($this->UserAccounts->delete($userAccount)) {
            $this->Flash->success(__('The user account has been deleted.'));
        } else {
            $this->Flash->error(__('The user account could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function password($id) {

        $userAccount = $this->UserAccounts->get($id);

        if($this->request->is(['put','post'])) {

            $userAccount = $this->UserAccounts->newEntity(
                $this->request->data(),
                [
                    'validate'=>'password'
                ]
            );

            if(!$userAccount->errors()) {

                $this->UserAccounts->updatePassword($this->request->data('id'),$this->request->data('passwd'));

            }

        }

        $this->set(compact("userAccount"));

    }

}
