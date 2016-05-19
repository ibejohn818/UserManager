<script type="text/javascript">
jQuery(document).ready(function($) {
    
    var $chk = $("#define_id");
    var $idInput = $("#id");

    $chk.bind("change",function(e) { 
        if($(this).is(":checked")) {
            $idInput.show().attr("disabled",false);
        } else {
            $idInput.hide().attr("disabled",true);
        }
    });

});
</script>
<div class="container-fluid">
    <div class="page-header">
        <h1>
            Add User Account Group
        </h1>
    </div>
    <div class="userAccountGroups form large-10 medium-9 columns">
        <?= $this->Form->create($userAccountGroup) ?>
        
            <?php
                
                echo $this->Form->input("id",['type'=>"text"]);
                echo $this->Form->input('name');

            ?>
        
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>

</div>