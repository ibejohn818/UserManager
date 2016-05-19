<script type="text/javascript">
jQuery(document).ready(function($) {
    
     $("input[type=checkbox][name=active]").bootstrapSwitch();
     $("input[type=checkbox][name=visible]").bootstrapSwitch();

});
</script>
<?php 
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
<div class="container-fluid">
    <div class="page-header">  
        <h1>
            Edit Custom Field 

        </h1>

    </div>
    <div>
        <a href="<?php echo $this->Url->build(["action"=>"index"]) ?>" class="btn btn-primary btn-sm">
           <i class="fa fa-arrow-circle-left"></i> Browse
        </a>
    </div>
    <?php echo $this->Form->create($customField) ?>
    <div class="edit form">
        <div class="row">
            <div class="col-md-12">

                <?php echo $this->Form->input("id") ?>
                <?php echo $this->Form->input("name") ?>
                <?php echo $this->Form->input("field_type",['options'=>UserAccountCustomField::fieldTypes()]) ?>
                <?php echo $this->Form->input("field_options") ?>
                <?php echo $this->Form->input("active",["data-on-text"=>"Active","data-off-text"=>"Disabled",'label'=>false]) ?>    
                <?php echo $this->Form->input("visible",["data-on-text"=>"Visible","data-off-text"=>"Hidden",'label'=>false]) ?>
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