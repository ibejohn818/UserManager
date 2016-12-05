<?php

$this->Html->addCrumb("User Manager");
$this->Html->addCrumb("User Permissions");


$addNewPermUrl = $this->Url->build([
	'action'=>'add'
]);

?>
<?php $this->start("page_header"); ?>
User Permissions
<?php $this->end("page_header"); ?>
<div class="pagination-wrapper index" id="admin-user-permissions">
	<div class="row">
		<div class="col-md-6">
			<?php echo $this->element("paginator-nav"); ?>
		</div>
		<div class="col-md-6">
			<div class="btn-group pull-right">
			<a href="<?= $addNewPermUrl; ?>" class="btn btn-success">
				<i class="fa fa-plus-sign"></i>
				Add New Permission
			</a>
			</div>
		</div>
	</div>
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
</div>
