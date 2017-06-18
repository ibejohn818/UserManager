<?php 

use UserManager\Model\Entity\UserAccountCustomField;

?>
<?php $this->start("heading"); ?>
	Create new custom field
<?php $this->end("heading"); ?>
<?php

	$this->Breadcrumbs->add("UserManager");
	$this->Breadcrumbs->add("Custom Fields",[
		'action'=>'index'
	]);
	$this->Breadcrumbs->add("Create New Field");

?>
<div class="container-fluid">
    <?php echo $this->Form->create($customField); ?>
    <div class="form create">
        <?php echo $this->Form->input("name") ?>
        <?php echo $this->Form->input("slug") ?>
        <?php echo $this->Form->input('field_type',['options'=>UserAccountCustomField::fieldTypes()]) ?>
        <?php echo $this->Form->input('active',['type'=>'hidden','value'=>0]) ?>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            Create Field
        </button>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
