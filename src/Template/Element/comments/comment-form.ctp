<?php
echo $this->Form->create(new \UserManager\Model\Entity\Comment(),[
	'url'=>[
		'plugin'=>'UserManager',
		'controller'=>'Comments',
		'action'=>'create',
		'prefix'=>false
	]);
?>



<?php
	echo $this->Form->end();
?>
