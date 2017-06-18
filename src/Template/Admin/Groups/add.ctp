<?php

$this->Breadcrumbs->add("User Manager");
$this->Breadcrumbs->add("User Groups",[
	'action'=>'index'
]);
$this->Breadcrumbs->add("Create New Group"); 

?>
<?php $this->start("heading"); ?>
Create New User Group
<?php $this->end("heading"); ?>
<?php $this->start("heading_action"); ?>
	<?= $this->UserManager->authorizeBtn('danger','Cancel',[
		'action'=>'index'
	],[
		'icon'=>'fa-times'
	]);
	?>
<?php $this->end("heading_action"); ?>
<?= $this->Form->create($userAccountGroup) ?>
	<?php
		echo $this->Form->input("define_id",['label'=>'Define ID','type'=>'checkbox','hiddenField'=>false]);
	?>
	<div id="id-div">
		<?= $this->Form->input("id",['type'=>"number"]); ?>
	</div>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input("default_group");
	?>
<div class="form-actions">
	<button type="submit" class="btn btn-primary">Save</button>
</div>
<?= $this->Form->end() ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    
    var $chk = $("#define-id");
    var $idInput = $("#id-div");

    $chk.bind("change",function(e) { 
        if($(this).is(":checked")) {
            $idInput.show().attr("disabled",false);
        } else {
            $idInput.hide().attr("disabled",true);
        }
    }).trigger("change");

});
</script>
