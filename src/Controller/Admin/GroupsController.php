<?php
namespace UserManager\Controller\Admin;

use UserManager\Controller\AppController;

/**
 * UserAccountGroups Controller
 *
 * @property \UserManager\Model\Table\UserAccountGroupsTable $UserAccountGroups
 */
class GroupsController extends AppController
{


	public function initialize()
	{
		parent::initialize();

		$this->loadModel("UserManager.UserAccountGroups");

	}

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('userAccountGroups', $this->paginate($this->UserAccountGroups));
        $this->set('_serialize', ['userAccountGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id User Account Group id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userAccountGroup = $this->UserAccountGroups->get($id, [
            'contain' => ['UserAccountGroupAssignments', 'UserAccountPermissions']
        ]);
        $this->set('userAccountGroup', $userAccountGroup);
        $this->set('_serialize', ['userAccountGroup']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userAccountGroup = $this->UserAccountGroups->newEntity();
        if ($this->request->is('post')) {

            if (empty($this->request->data['id'])) {
                unset($this->request->data['id']);
            }

            $userAccountGroup = $this->UserAccountGroups->patchEntity($userAccountGroup, $this->request->data);
            if ($this->UserAccountGroups->save($userAccountGroup)) {
                $this->Flash->success(__('The user account group has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user account group could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('userAccountGroup'));
        $this->set('_serialize', ['userAccountGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Account Group id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userAccountGroup = $this->UserAccountGroups->get($id, [
			'contain' => [
				'UserAccountPermissions'
			]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userAccountGroup = $this->UserAccountGroups->patchEntity($userAccountGroup, $this->request->data);
            if ($this->UserAccountGroups->save($userAccountGroup)) {
                $this->Flash->success(__('The user account group has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user account group could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('userAccountGroup'));
        $this->set('_serialize', ['userAccountGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User Account Group id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userAccountGroup = $this->UserAccountGroups->get($id);
        if ($this->UserAccountGroups->delete($userAccountGroup)) {
            $this->Flash->success(__('The user account group has been deleted.'));
        } else {
            $this->Flash->error(__('The user account group could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
