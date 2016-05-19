<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $userAccountGroup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountGroup->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List User Account Groups'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List User Account Group Assignments'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Group Assignment'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Account Permissions'), ['controller' => 'UserAccountPermissions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Permission'), ['controller' => 'UserAccountPermissions', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="userAccountGroups form large-10 medium-9 columns">
    <?= $this->Form->create($userAccountGroup) ?>
    <fieldset>
        <legend><?= __('Edit User Account Group') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
