<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit User Account Group'), ['action' => 'edit', $userAccountGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Account Group'), ['action' => 'delete', $userAccountGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountGroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Account Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Group'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Account Group Assignments'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Group Assignment'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Account Permissions'), ['controller' => 'UserAccountPermissions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Permission'), ['controller' => 'UserAccountPermissions', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="userAccountGroups view large-10 medium-9 columns">
    <h2><?= h($userAccountGroup->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($userAccountGroup->name) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($userAccountGroup->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($userAccountGroup->created) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related UserAccountGroupAssignments') ?></h4>
    <?php if (!empty($userAccountGroup->user_account_group_assignments)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Account Id') ?></th>
            <th><?= __('User Account Group Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($userAccountGroup->user_account_group_assignments as $userAccountGroupAssignments): ?>
        <tr>
            <td><?= h($userAccountGroupAssignments->id) ?></td>
            <td><?= h($userAccountGroupAssignments->user_account_id) ?></td>
            <td><?= h($userAccountGroupAssignments->user_account_group_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'view', $userAccountGroupAssignments->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'edit', $userAccountGroupAssignments->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'delete', $userAccountGroupAssignments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountGroupAssignments->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related UserAccountPermissions') ?></h4>
    <?php if (!empty($userAccountGroup->user_account_permissions)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Allowed') ?></th>
            <th><?= __('User Account Group Id') ?></th>
            <th><?= __('User Account Id') ?></th>
            <th><?= __('Plugin') ?></th>
            <th><?= __('Controller') ?></th>
            <th><?= __('Action') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($userAccountGroup->user_account_permissions as $userAccountPermissions): ?>
        <tr>
            <td><?= h($userAccountPermissions->id) ?></td>
            <td><?= h($userAccountPermissions->created) ?></td>
            <td><?= h($userAccountPermissions->allowed) ?></td>
            <td><?= h($userAccountPermissions->user_account_group_id) ?></td>
            <td><?= h($userAccountPermissions->user_account_id) ?></td>
            <td><?= h($userAccountPermissions->plugin) ?></td>
            <td><?= h($userAccountPermissions->controller) ?></td>
            <td><?= h($userAccountPermissions->action) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'UserAccountPermissions', 'action' => 'view', $userAccountPermissions->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'UserAccountPermissions', 'action' => 'edit', $userAccountPermissions->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserAccountPermissions', 'action' => 'delete', $userAccountPermissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountPermissions->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
