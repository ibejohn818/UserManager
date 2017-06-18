<?php

namespace UserManager\Controller\Admin;

use UserManager\Controller\AppController;
use UserManager\Model\Entity\UserAccountCustomField;

class CustomFieldsController extends AppController {

    public function beforeFilter(\Cake\Event\Event $event) {

        parent::beforeFilter($event);

        $this->loadModel('UserManager.UserAccountCustomFields');

    }

    public function index() {

        $customFields = $this->paginate($this->UserAccountCustomFields);

        $this->set(compact("customFields"));

    }

    public function add()
    {

        $customField = new UserAccountCustomField();

        if ($this->request->is(["post","put"])) {

			$customField = $this->UserAccountCustomFields->patchEntity($customField,$this->request->data,[
				'validate'=>'create'
			]);

            if($this->UserAccountCustomFields->save($customField)) {

                $this->Flash->success("CustomField created successfully!");

                $this->redirect([
                    'action'=>'edit',
                    $customField->id
                ]);

            } else {

            }

        }

        $this->set(compact("customField"));

    }

    public function edit($id = false)
    {

        $customField = $this->UserAccountCustomFields->get($id);

        if ($this->request->is(["post","put"])) {

             $customField = $this->UserAccountCustomFields->patchEntity($customField,$this->request->data);


            if($this->UserAccountCustomFields->save($customField)) {

                $this->Flash->success("CustomField updated successfully!");

                $this->redirect([
                    'action'=>'edit',
                    $customField->id
                ]);

            } else {

            }
        }

        $this->set(compact("customField"));

    }

	public function delete($id = false)
	{

		if($this->request->is(['post','delete','put']) && $id && ($field = $this->UserAccountCustomFields->findById($id)->first())) {

			if($this->UserAccountCustomFields->delete($field)) {
				$this->Flash->success("Custom Field Deleted!");
			} else {
				$this->Flash->error("Error deleting custom field");
			}

			$this->redirect(['action'=>'index']);

		} else {
			throw new NotFoundException("Invlaid URL");
		}

	}


}
