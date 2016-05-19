<div class="container">
    <?php echo $this->Form->create($userAccount) ?>
    <?php echo $this->Form->input("id"); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">
               <i class="fa fa-key"></i> Update Password
            </h1>
        </div>
        <div class="panel-body">
            <?php echo $this->Form->input("passwd",['type'=>"password",'label'=>'Password']) ?>
            <?php echo $this->Form->input('passwd_confirm',["type"=>"password","label"=>"Confirm Password"]) ?>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-floppy-o"></i> Save
            </button>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>