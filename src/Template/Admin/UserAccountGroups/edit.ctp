<?php

$this->Html->addCrumb("User Manager");
$this->Html->addCrumb("User Groups",['action'=>'index']);



?>
<?php $this->start("page_header"); ?>
Edit User Group
<?php $this->end("page_header"); ?>
<div class="edit">
	<div class="row">
		<div class="col-md-12">
			<?= $this->Form->create($userAccountGroup) ?>
				<?php echo $this->Form->input("name"); ?>
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
<?php pr($userAccountGroup); ?>
