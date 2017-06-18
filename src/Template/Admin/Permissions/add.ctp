<?php
	
 ?>
<?php $this->start("page_header"); ?>
Create New Permission
<?php $this->end("page_header"); ?>
<?php $this->start("bottom_script"); ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	

	$("#user-name").focus(function() { 

		$(this).blur();

		$.UserAccountsModal({
			onUserSelect:function(u) {

			var email = $(this).data('user-email');
			var name = $(this).data('user-first-name');
			var $id = $("#user-account-id").val($(this).data("user-id"));
				$("#user-name").val($(this).data('user-email'));
			}

		}).open();
	});

});
</script>
<?php $this->end("bottom_script"); ?>
<div class="row">
	<section class="col-md-12">
		<div class="btn-group">
		<a href="<?php echo $this->UserManager->authorizeUri(['action'=>'index']); ?>" class="btn btn-primary">
			<i class="fa fa-arrow-circle-left"></i>
			Back To Index
		</a>
		</div>
	</section>
</div>
<div class="index container-fluid">
    <?= $this->Form->create($userAccountPermission) ?>

        <?php
            echo $this->Form->input('allowed');
            echo $this->Form->input('user_account_group_id', ['options' => $userAccountGroups, 'empty' => true]);
			echo $this->Form->input("user_account_name",['type'=>'text','id'=>'user-name']); 
            echo $this->Form->input('user_account_id', ['type'=>'hidden']);
            echo $this->Form->input('prefix');
            echo $this->Form->input('plugin');
            echo $this->Form->input('controller');
            echo $this->Form->input('action');
        ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
