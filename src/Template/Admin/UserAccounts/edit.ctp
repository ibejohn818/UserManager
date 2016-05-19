<?php

use Cake\Collection\Collection;

 ?>
<?php $this->start("bottom_script"); ?>
<script type="text/javascript">
$(document).ready(function($) {

    $("input[type=checkbox][name=active]").bootstrapSwitch();

});
</script>
<?php $this->end("bottom_script"); ?>
<div class="container-fluid">
    <div class="page-header">
        <h1>
            Edit User Account
        </h1>
    </div>
<div class="actions columns large-2 medium-3">

    <ul class="nav nav-pills">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $userAccount->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $userAccount->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List User Accounts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List User Account Custom Field Values'), ['controller' => 'UserAccountCustomFieldValues', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Custom Field Value'), ['controller' => 'UserAccountCustomFieldValues', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Account Foreign Credentials'), ['controller' => 'UserAccountForeignCredentials', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Foreign Credential'), ['controller' => 'UserAccountForeignCredentials', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Account Group Assignments'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Group Assignment'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Account Passwds'), ['controller' => 'UserAccountPasswds', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Passwd'), ['controller' => 'UserAccountPasswds', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Account Permissions'), ['controller' => 'UserAccountPermissions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Permission'), ['controller' => 'UserAccountPermissions', 'action' => 'add']) ?></li>
    </ul>
</div>
<?= $this->Form->create($userAccount) ?>
    <div class="row">
        <div class="col-md-6">
                        <fieldset>
                            <legend>Account Status</legend>
                              <?php
                                echo $this->Form->input('active',['label'=>false,'data-on-text'=>'Active','data-off-text'=>'Off','data-on-color'=>'success']);
                               ?>
                        </fieldset>
            <?php

                    echo $this->Form->input('first_name');
                    echo $this->Form->input('middle_name');
                    echo $this->Form->input('last_name');
                    echo $this->Form->input('email');
                    echo $this->Form->input('profile_uri');
                ?>
                <h3>Group</h3>
                <?php
                    $groupsCollection = new Collection($userAccount->user_account_groups);
                    $selectedGroups = $groupsCollection->extract("id")->toArray();
                    // pr($selectedGroups);
                    foreach ($userGroups as $k => $v):
                        $selected = false;
                        if(in_array($k,$selectedGroups)) {
                            $selected = true;
                        }
                ?>
                    <?php echo $this->Form->input("user_account_groups.{$k}.id",['type'=>'checkbox','hiddenField'=>false,'value'=>$k,'label'=>$v,'checked'=>$selected]) ?>
                <?php endforeach; ?>
        </div>
        <div class="col-md-6">
            <h3>Custom Fields</h3>
            <?php foreach ($userAccount->custom_fields as $k => $field): ?>
                <div class="custom-field">

                    <?php echo $this->UserManager->customFieldEdit($field,$field->user_value,$k) ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-floppy-o"></i> Save
        </button>
    </div>
<?= $this->Form->end() ?>
</div>
<?php pr($userAccount) ?>
