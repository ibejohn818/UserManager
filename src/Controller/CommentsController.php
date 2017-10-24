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

			$userComment->user_account_id = $this->Auth->user("id");

			if(($newComment = $this->UserComments->createComment($userComment)) !== False) {

                $url = parse_url($return_uri);

                $query = [];

                parse_str($url['query'], $query);

                $query['comment'] = $newComment->id;

                $qs = http_build_query($query);

                $goTo = "{$url['path']}?{$qs}";

				$this->Flash->success("Comment added successfully");

				$this->redirect($goTo);

			}

		}

	}

    public function form()
    {

        $model = $this->request->query("model");
        $foreign_key = $this->request->query("foreign_key");
        $return_uri = $this->request->query("return_uri");
        $options = [];
        if($this->request->query("parent_id")) {
            $options["parent_id"] = $this->request->query("parent_id");
        }
        $this->set(compact(
            "model",
            "foreign_key",
            "return_uri",
            "options"
        ));


    }


}
