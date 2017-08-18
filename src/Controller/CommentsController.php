<?php

namespace UserManager\Controller;


use UserManager\Controller\AppController;


class CommentsController extends AppController
{

	public function initialize($conf = [])
	{

		parent::initialize($conf);

		$this->loadModel("UserManager.UserComments");

	}

	public function beforeFilter(\Cake\Event\Event $event)
	{
		parent::beforeFilter($event);
	}

	public function create()
	{

		if($this->request->is(['post','put'])) {

			$return_uri = $this->request->data("return_uri");

			$userComment = $this->UserComments->newEntity($this->request->data());

			if($this->UserComments->createComment($userComment)) {

				$this->Flash->success("Comment added successfully");

				$this->redirect($return_uri);

			}

		}

	}


}
