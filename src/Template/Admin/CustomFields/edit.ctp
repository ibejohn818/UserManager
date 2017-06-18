<?php $this->start("bottom_script"); ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    
     $("input[type=checkbox][name=active]").bootstrapSwitch();
     $("input[type=checkbox][name=visible]").bootstrapSwitch();

});
</script>
<?php $this->end("bottom_script"); ?>
<?php $this->start("heading"); ?>
Edit Custom Field
<?php $this->end("heading"); ?>
<?php 

$this->Breadcrumbs->add("User Manager");
$this->Breadcrumbs->add("Custom Fields",['action'=>'index']);
$this->Breadcrumbs->add("Edit Field: {$customField->name}");

use UserManager\Model\Entity\UserAccountCustomField;

$this->Html->css(
    [
        'UserManager.custom-field-edit'
    ],
    [
        'block'=>true
    ]
);


?>
<?php $this->start("heading_action"); ?>
        <a href="<?php echo $this->Url->build(["action"=>"index"]) ?>" class="btn btn-primary btn-sm">
           <i class="fa fa-arrow-circle-left"></i> Browse
        </a>
<?php $this->end("heading_action"); ?>
<div class="container-fluid">
    <div>
    </div>
    <?php echo $this->Form->create($customField) ?>
    <div class="edit form">
        <div class="row">
            <div class="col-md-12">

                <?php echo $this->Form->input("id") ?>
                <?php echo $this->Form->input("name") ?>
                <?php echo $this->Form->input("slug") ?>
                <?php echo $this->Form->input("field_type",['options'=>UserAccountCustomField::fieldTypes()]) ?>
                <?php echo $this->Form->input("field_options") ?>
                <?php echo $this->Form->input("active",["data-on-text"=>"Active","data-off-text"=>"Disabled",]) ?>    
                <?php echo $this->Form->input("visible",["data-on-text"=>"Visible","data-off-text"=>"Hidden",]) ?>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Save Field
            </button>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
