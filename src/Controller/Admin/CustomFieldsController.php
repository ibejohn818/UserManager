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

            $customField = $this->UserAccountCustomFields->patchEntity($customField,$this->request->data);

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

}
