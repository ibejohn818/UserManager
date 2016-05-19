<?php 

use UserManager\Model\Entity\UserAccountCustomField;

 ?>
<div class="container-fluid">
    <div class="page-header">
        <h1>
            Create New Custom Field
        </h1>
    </div>
    <?php echo $this->Form->create($customField); ?>
    <div class="form create">
        <?php echo $this->Form->input("name") ?>
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