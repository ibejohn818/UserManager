<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User Account Permission'), ['action' => 'edit', $userAccountPermission->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Account Permission'), ['action' => 'delete', $userAccountPermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountPermission->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Account Permissions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Permission'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Account Groups'), ['controller' => 'UserAccountGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Group'), ['controller' => 'UserAccountGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Accounts'), ['controller' => 'UserAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account'), ['controller' => 'UserAccounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="userAccountPermissions view large-9 medium-8 columns content">
    <h3><?= h($userAccountPermission->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User Account Group') ?></th>
            <td><?= $userAccountPermission->has('user_account_group') ? $this->Html->link($userAccountPermission->user_account_group->name, ['controller' => 'UserAccountGroups', 'action' => 'view', $userAccountPermission->user_account_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('User Account') ?></th>
            <td><?= $userAccountPermission->has('user_account') ? $this->Html->link($userAccountPermission->user_account->id, ['controller' => 'UserAccounts', 'action' => 'view', $userAccountPermission->user_account->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Prefix') ?></th>
            <td><?= h($userAccountPermission->prefix) ?></td>
        </tr>
        <tr>
            <th><?= __('Plugin') ?></th>
            <td><?= h($userAccountPermission->plugin) ?></td>
        </tr>
        <tr>
            <th><?= __('Controller') ?></th>
            <td><?= h($userAccountPermission->controller) ?></td>
        </tr>
        <tr>
            <th><?= __('Action') ?></th>
            <td><?= h($userAccountPermission->action) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($userAccountPermission->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($userAccountPermission->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Allowed') ?></th>
            <td><?= $userAccountPermission->allowed ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
