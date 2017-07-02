<?php

$this->Breadcrumbs->add("User Manager");
$this->Breadcrumbs->add("User Groups",['action'=>'index']);

?>
<?php $this->start("heading"); ?>
Edit User Group
<?php $this->end("heading"); ?>
<div class="edit">
	<div class="row">
		<div class="col-md-12">
			<?= $this->Form->create($userAccountGroup) ?>
				<?php echo $this->Form->input("name"); ?>
				<?php echo $this->Form->input("active"); ?>
				<?php echo $this->Form->input("default_group"); ?>
			<div class="form-actions">
				<button class="btn btn-primary" type='submit'>
					<i class="fa fa-floppy-o"></i>
					Save Group
				</button>
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
