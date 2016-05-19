<div class="page-header">
    <h1>
        Edit User Permissions
    </h1>
</div>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="nav nav-pills">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $userAccountPermission->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountPermission->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List User Account Permissions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List User Account Groups'), ['controller' => 'UserAccountGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Group'), ['controller' => 'UserAccountGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Accounts'), ['controller' => 'UserAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account'), ['controller' => 'UserAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="index container-fluid">
    <?= $this->Form->create($userAccountPermission) ?>
    <?php
        echo $this->Form->input('allowed');
        echo $this->Form->input('user_account_group_id', ['options' => $userAccountGroups, 'empty' => true]);
        echo $this->Form->input('user_account_id', ['options' => $userAccounts, 'empty' => true]);
        echo $this->Form->input('prefix');
        echo $this->Form->input('plugin');
        echo $this->Form->input('controller');
        echo $this->Form->input('action');
    ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
