<?php $this->start("page_header"); ?>
Edit Permission
<?php $this->end("page_header"); ?>

<div class="row">
	<section class="col-md-12">
		<div class="btn-group">
			<a href="<?php echo $this->UserManager->authorizeUri(['action'=>'index']); ?>" class="btn btn-primary">
				<i class="fa fa-arrow-circle-left"></i>
				Back to Index
				</a>
			<a href="<?php echo $this->UserManager->authorizeUri(['action'=>'add']); ?>" class="btn btn-success">
				<i class="fa fa-plus"></i>
				Create new permission
			</a>
		</div>
	</section>
</div>
<hr>
<div class=" edit">
    <?= $this->Form->create($userAccountPermission) ?>
    <?php
        echo $this->Form->input('allowed');
        echo $this->Form->input('user_account_group_id', ['options' => $userAccountGroups, 'empty' => true]);
        echo $this->Form->input('user_account_id', ['options' => $userAccounts, 'empty' => true]);
        echo $this->Form->input('prefix');
        echo $this->Form->input('plugin');
        echo $this->Form->input('controller');
        echo $this->Form->input('action');
    ?>
		<button type="button" class="btn btn-success">
			<i class="fa fa-floppy-o"></i>
			Save
		</button>
    <?= $this->Form->end() ?>
</div>
