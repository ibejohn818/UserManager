<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="nav nav-pills">

        <li><?= $this->Html->link(__('New User Account Permission'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Account Groups'), ['controller' => 'UserAccountGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Group'), ['controller' => 'UserAccountGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Accounts'), ['controller' => 'UserAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account'), ['controller' => 'UserAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="index container-fluid">
    <h3><?= __('User Account Permissions') ?></h3>
    <table cellpadding="0" cellspacing="0" class='table table-striped table-bordered table-hover'>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('allowed') ?></th>
                <th><?= $this->Paginator->sort('user_account_group_id') ?></th>
                <th><?= $this->Paginator->sort('user_account_id') ?></th>
                <th><?= $this->Paginator->sort('prefix') ?></th>
                <th><?= $this->Paginator->sort('plugin') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userAccountPermissions as $userAccountPermission): ?>
            <tr>
                <td><?= $this->Number->format($userAccountPermission->id) ?></td>
                <td><?= h($userAccountPermission->created) ?></td>
                <td><?= h($userAccountPermission->allowed) ?></td>
                <td><?= $userAccountPermission->has('user_account_group') ? $this->Html->link($userAccountPermission->user_account_group->name, ['controller' => 'UserAccountGroups', 'action' => 'view', $userAccountPermission->user_account_group->id]) : '' ?></td>
                <td><?= $userAccountPermission->has('user_account') ? $this->Html->link($userAccountPermission->user_account->id, ['controller' => 'UserAccounts', 'action' => 'view', $userAccountPermission->user_account->id]) : '' ?></td>
                <td><?= h($userAccountPermission->prefix) ?></td>
                <td><?= h($userAccountPermission->plugin) ?></td>
                <td class="actions" nowrap >
                    <?= $this->Html->link(__('View'), ['action' => 'view', $userAccountPermission->id],['class'=>'btn btn-xs btn-info']) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userAccountPermission->id],['class'=>'btn btn-xs btn-primary']) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userAccountPermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountPermission->id),'class'=>'btn btn-danger btn-xs']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
