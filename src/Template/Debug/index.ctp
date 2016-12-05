<?php

function outList($list) {

	$out = "";

	foreach($list as $k=>$v) {

		$out .= "<dt>{$k}</dt>";
		$out .= "<dd>";
			if(is_array($v)) {
				$out .= outList($v);
			} else {
				$out .= $v;
			}
		$out .= "</dd>";

	}

	echo "<dl>{$out}</dl>";

}
outList($this->request->session()->read("Auth.User"));
?>
