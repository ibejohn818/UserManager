<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
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
<div class="userAccounts form large-10 medium-9 columns">
    <?= $this->Form->create($userAccount) ?>
    <fieldset>
        <legend><?= __('Add User Account') ?></legend>
        <?php
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('middle_name');
            echo $this->Form->input('active');
            echo $this->Form->input('email');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
