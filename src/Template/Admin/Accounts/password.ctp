<?php

$this->Breadcrumbs->add("User Manager",[
	'action'=>'index'
]);

$this->Breadcrumbs->add("Update Password");

?>
<?php $this->start("heading"); ?>
	Update Password
<?php $this->end("heading"); ?>

<?php $this->start("bottom_script"); ?>
<script type="text/javascript">
(function($) {

	$("#show-passwds").bind('change',function(e) {

		var $fields = $("input[id^=passwd]");
		console.log($fields);
		if($(this).is(":checked")) {
			$fields.attr("type","text");
		} else {
			$fields.attr("type","password");
		}

	});

})(jQuery);
</script>
<?php $this->end("bottom_script"); ?>

<?php echo $this->Form->create($userAccount) ?>
<?php echo $this->Form->input("id"); ?>
		<?php echo $this->Form->input("passwd",['type'=>"password",'label'=>'Password']) ?>
		<?php echo $this->Form->input('passwd_confirm',["type"=>"password","label"=>"Confirm Password"]) ?>
		<div class="ibox-content white-bg">
			<?= $this->Form->input("show-passwds",['type'=>'checkbox','hiddenField'=>false]) ?>
		</div>
		<div class="form-action">
			<button type="submit" class="btn btn-success">
				<i class="fa fa-floppy-o"></i> Save
			</button>
		</div>
<?php echo $this->Form->end(); ?>
