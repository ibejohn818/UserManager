<?php

use Cake\Core\Configure;


$providers = [
	'Google',
	'Github',
	'Facebook',
	'Twitter',
	'Yahoo'
];
?>
<div class='login-providers'>
<?php foreach($providers as $k=>$v):
	$url = $this->Url->build([
        'plugin'=>'UserManager',
        'controller'=>'Login',
		'action'=>'provider',
		$v
	]);
	if(Configure::read("UserManager.{$v}LoginEnable")):
?>
	<div class='login-provider <?= $v ?>'>
		<a href="<?= $url; ?>" class="btn btn-default">
			<i class="fa fa-<?= $v ?>"></i>
			<?= ucfirst($v) ?>
		</a>
	</div>
<?php endif; endforeach; ?>
</div>
