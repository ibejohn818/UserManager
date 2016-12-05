<?php

namespace UserManager\View;

use Cake\View\View;

class TemplateView extends View {


	protected function _render($viewFile, $data = []) {

		$conetnt = parent::_render($viewFile,$data);

		//replace PHP tags
		$content = $this->phpIze($content);

		return $content;

	}

	protected function phpIze($content) {
		$content = str_replace("@php","<?php",
					str_replace("php@","?>",$content)
				);

		return $content;
	}


}
