<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit User Account'), ['action' => 'edit', $userAccount->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Account'), ['action' => 'delete', $userAccount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccount->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Accounts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Account Custom Field Values'), ['controller' => 'UserAccountCustomFieldValues', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Custom Field Value'), ['controller' => 'UserAccountCustomFieldValues', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Account Foreign Credentials'), ['controller' => 'UserAccountForeignCredentials', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Foreign Credential'), ['controller' => 'UserAccountForeignCredentials', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Account Group Assignments'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Group Assignment'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Account Passwds'), ['controller' => 'UserAccountPasswds', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Passwd'), ['controller' => 'UserAccountPasswds', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Account Permissions'), ['controller' => 'UserAccountPermissions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account Permission'), ['controller' => 'UserAccountPermissions', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="userAccounts view large-10 medium-9 columns">
    <h2><?= h($userAccount->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('First Name') ?></h6>
            <p><?= h($userAccount->first_name) ?></p>
            <h6 class="subheader"><?= __('Last Name') ?></h6>
            <p><?= h($userAccount->last_name) ?></p>
            <h6 class="subheader"><?= __('Middle Name') ?></h6>
            <p><?= h($userAccount->middle_name) ?></p>
            <h6 class="subheader"><?= __('Email') ?></h6>
            <p><?= h($userAccount->email) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($userAccount->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($userAccount->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($userAccount->modified) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Active') ?></h6>
            <p><?= $userAccount->active ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related UserAccountCustomFieldValues') ?></h4>
    <?php if (!empty($userAccount->user_account_custom_field_values)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>
            <th><?= __('User Account Id') ?></th>
            <th><?= __('User Account Custom Field Id') ?></th>
            <th><?= __('Field Value') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($userAccount->user_account_custom_field_values as $userAccountCustomFieldValues): ?>
        <tr>
            <td><?= h($userAccountCustomFieldValues->id) ?></td>
            <td><?= h($userAccountCustomFieldValues->created) ?></td>
            <td><?= h($userAccountCustomFieldValues->modified) ?></td>
            <td><?= h($userAccountCustomFieldValues->user_account_id) ?></td>
            <td><?= h($userAccountCustomFieldValues->user_account_custom_field_id) ?></td>
            <td><?= h($userAccountCustomFieldValues->field_value) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'UserAccountCustomFieldValues', 'action' => 'view', $userAccountCustomFieldValues->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'UserAccountCustomFieldValues', 'action' => 'edit', $userAccountCustomFieldValues->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserAccountCustomFieldValues', 'action' => 'delete', $userAccountCustomFieldValues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountCustomFieldValues->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related UserAccountForeignCredentials') ?></h4>
    <?php if (!empty($userAccount->user_account_foreign_credentials)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>
            <th><?= __('User Account Id') ?></th>
            <th><?= __('Service Name') ?></th>
            <th><?= __('Param1') ?></th>
            <th><?= __('Param2') ?></th>
            <th><?= __('Param3') ?></th>
            <th><?= __('Param4') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($userAccount->user_account_foreign_credentials as $userAccountForeignCredentials): ?>
        <tr>
            <td><?= h($userAccountForeignCredentials->id) ?></td>
            <td><?= h($userAccountForeignCredentials->created) ?></td>
            <td><?= h($userAccountForeignCredentials->modified) ?></td>
            <td><?= h($userAccountForeignCredentials->user_account_id) ?></td>
            <td><?= h($userAccountForeignCredentials->service_name) ?></td>
            <td><?= h($userAccountForeignCredentials->param1) ?></td>
            <td><?= h($userAccountForeignCredentials->param2) ?></td>
            <td><?= h($userAccountForeignCredentials->param3) ?></td>
            <td><?= h($userAccountForeignCredentials->param4) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'UserAccountForeignCredentials', 'action' => 'view', $userAccountForeignCredentials->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'UserAccountForeignCredentials', 'action' => 'edit', $userAccountForeignCredentials->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserAccountForeignCredentials', 'action' => 'delete', $userAccountForeignCredentials->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountForeignCredentials->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related UserAccountGroupAssignments') ?></h4>
    <?php if (!empty($userAccount->user_account_group_assignments)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Account Id') ?></th>
            <th><?= __('User Account Group Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($userAccount->user_account_group_assignments as $userAccountGroupAssignments): ?>
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
    <h4 class="subheader"><?= __('Related UserAccountPasswds') ?></h4>
    <?php if (!empty($userAccount->user_account_passwds)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Passwd') ?></th>
            <th><?= __('User Account Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($userAccount->user_account_passwds as $userAccountPasswds): ?>
        <tr>
            <td><?= h($userAccountPasswds->id) ?></td>
            <td><?= h($userAccountPasswds->created) ?></td>
            <td><?= h($userAccountPasswds->passwd) ?></td>
            <td><?= h($userAccountPasswds->user_account_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'UserAccountPasswds', 'action' => 'view', $userAccountPasswds->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'UserAccountPasswds', 'action' => 'edit', $userAccountPasswds->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserAccountPasswds', 'action' => 'delete', $userAccountPasswds->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountPasswds->id)]) ?>

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
    <?php if (!empty($userAccount->user_account_permissions)): ?>
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
        <?php foreach ($userAccount->user_account_permissions as $userAccountPermissions): ?>
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
