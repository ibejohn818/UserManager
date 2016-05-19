<?php
namespace UserManager\Controller\Admin;

use UserManager\Controller\AppController;

/**
 * UserAccountPermissions Controller
 *
 * @property \UserManager\Model\Table\UserAccountPermissionsTable $UserAccountPermissions
 */
class UserAccountPermissionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['UserAccountGroups', 'UserAccounts']
        ];
        $this->set('userAccountPermissions', $this->paginate($this->UserAccountPermissions));
        $this->set('_serialize', ['userAccountPermissions']);
    }

    /**
     * View method
     *
     * @param string|null $id User Account Permission id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userAccountPermission = $this->UserAccountPermissions->get($id, [
            'contain' => ['UserAccountGroups', 'UserAccounts']
        ]);
        $this->set('userAccountPermission', $userAccountPermission);
        $this->set('_serialize', ['userAccountPermission']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userAccountPermission = $this->UserAccountPermissions->newEntity();
        if ($this->request->is('post')) {
            $userAccountPermission = $this->UserAccountPermissions->patchEntity($userAccountPermission, $this->request->data);
            if ($this->UserAccountPermissions->save($userAccountPermission)) {
                $this->Flash->success(__('The user account permission has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user account permission could not be saved. Please, try again.'));
            }
        }
        $userAccountGroups = $this->UserAccountPermissions->UserAccountGroups->find('list', ['limit' => 200]);
        $userAccounts = $this->UserAccountPermissions->UserAccounts->find('list', ['limit' => 200]);
        $this->set(compact('userAccountPermission', 'userAccountGroups', 'userAccounts'));
        $this->set('_serialize', ['userAccountPermission']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Account Permission id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userAccountPermission = $this->UserAccountPermissions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userAccountPermission = $this->UserAccountPermissions->patchEntity($userAccountPermission, $this->request->data);
            
            if ($this->UserAccountPermissions->save($userAccountPermission)) {
                $this->Flash->success(__('The user account permission has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user account permission could not be saved. Please, try again.'));
            }
        }
        $userAccountGroups = $this->UserAccountPermissions->UserAccountGroups->find('list', ['limit' => 200]);
        $userAccounts = $this->UserAccountPermissions->UserAccounts->find('list', ['limit' => 200]);
        $this->set(compact('userAccountPermission', 'userAccountGroups', 'userAccounts'));
        $this->set('_serialize', ['userAccountPermission']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User Account Permission id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userAccountPermission = $this->UserAccountPermissions->get($id);
        if ($this->UserAccountPermissions->delete($userAccountPermission)) {
            $this->Flash->success(__('The user account permission has been deleted.'));
        } else {
            $this->Flash->error(__('The user account permission could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
