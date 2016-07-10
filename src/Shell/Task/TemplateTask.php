<?php

namespace UserManager\Shell\Task;

use Cake\Console\Shell;
use UserManager\View\TemplateView;
use Cake\Network\Request;
use Cake\Network\Response;

class TemplateTask extends Shell {


	protected $_view = false;

	public function _getView() {

		if(!$this->_view) {
			$this->_view = new TemplateView(new Request(),new Response());
		}

		return $this->_view;

	}


	public function generate($template) {

		die(pr($this->_getView()));


	}

}
