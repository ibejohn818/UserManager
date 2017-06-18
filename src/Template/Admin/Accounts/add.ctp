<?php

$this->Breadcrumbs->add("User Manager");
$this->Breadcrumbs->add("Accounts",['action'=>'index']);
$this->Breadcrumbs->add("Create new account");

?>
<?php $this->start("heading"); ?>
Create New Account
<?php $this->end("heading"); ?>
<div class="userAccounts form ibox-content white-bg">
    <?= $this->Form->create($userAccount) ?>
        <?php
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('middle_name');
            echo $this->Form->input('active');
            echo $this->Form->input('email');
        ?>
	
    <?= $this->Form->end() ?>
</div>
