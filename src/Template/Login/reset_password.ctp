<?php 

$this->Html->css(
	[
		'UserManager.login/reset-password'
	],
	[
		'block'=>true
	]
);

 ?>


	<div class="jumbotron">
		<h1 class='text-center'>
			<i class="fa fa-refresh"></i>
		</h1>
	</div>
<div class="container">

	 <div class="panel panel-default" id="reset-password-panel">
	 	<div class="panel-heading">
	 		<h1 class='panel-title text-center'>
	 			Reset Password
	 		</h1>
	 	</div>
	 	<div class="panel-body">
	 		<?php if ($errorMessage): ?>
	 			<div class="alert alert-danger">
		 			<?php foreach ($errorMessage['email'] as $k => $v): ?>
		 				<div>
		 					<?php echo $v; ?>
		 				</div>
		 			<?php endforeach ?>
		 		</div>
	 		<?php endif ?>
	 		<?php echo $this->Form->create($resetRequest,[
	 			'url'=>$_SERVER['REQUEST_URI'],
	 			'novalidate'=>true
	 		]); ?>
			<?php echo $this->Form->input("email",['error'=>false]) ?>
			<div class='text-center'>
				<button type="submit" class="btn btn-primary">
					Submit
				</button>
			</div>
	 		<?php echo $this->Form->end(); ?>
	 	</div>
	 </div>
</div>
