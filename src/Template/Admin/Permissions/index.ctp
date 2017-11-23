<?php

$this->Html->addCrumb("User Manager");
$this->Html->addCrumb("User Permissions");


$addNewPermUrl = $this->Url->build([
	'action'=>'add'
]);

$this->Breadcrumbs->add("User Manager");
$this->Breadcrumbs->add("Permissions");

?>
<?php $this->start("heading"); ?>
User Permissions
<?php $this->end("heading"); ?>
<?php $this->start("heading_action"); ?>
<a href="<?= $addNewPermUrl ?>" class="btn btn-primary">
	<i class="fa fa-plus"></i>
	Add new permission
</a>
<?php $this->end("heading_action"); ?>
	<?= $this->element("paginator-nav") ?>
<div class="pagination-wrapper table-response index" id="admin-user-permissions">
    <table cellpadding="0" cellspacing="0" class='table table-striped table-hover'>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('weight') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('allowed') ?></th>
                <th><?= $this->Paginator->sort('user_account_group_id') ?></th>
                <th><?= $this->Paginator->sort('user_account_id') ?></th>
                <th><?= $this->Paginator->sort('prefix') ?></th>
                <th><?= $this->Paginator->sort('plugin') ?></th>
                <th><?= $this->Paginator->sort('controller') ?></th>
                <th><?= $this->Paginator->sort('action') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userAccountPermissions as $userAccountPermission): ?>
            <tr>
                <td><?= $this->Number->format($userAccountPermission->id) ?></td>
                <td><?= $this->Number->format($userAccountPermission->weight) ?></td>
                <td><?= h($userAccountPermission->created) ?></td>
				<td>
					<?php
						switch($userAccountPermission->allowed) {
							case '1':
								echo "<span class='label label-success'><i class='fa fa-check'></i></span>";
								break;
							default:
								echo "<span class='label label-danger'><i class='fa fa-times'></i></span>";
								break;
						}
					?>
				</td>
                <td><?= $userAccountPermission->has('user_account_group') ? $this->Html->link($userAccountPermission->user_account_group->name, ['controller' => 'Groups', 'action' => 'view', $userAccountPermission->user_account_group->id]) : '' ?></td>
                <td><?= $userAccountPermission->has('user_account') ? $this->Html->link($userAccountPermission->user_account->id, ['controller' => 'UserAccounts', 'action' => 'view', $userAccountPermission->user_account->id]) : '' ?></td>
                <td><?= h($userAccountPermission->prefix) ?></td>
                <td><?= h($userAccountPermission->plugin) ?></td>
                <td><?= h($userAccountPermission->controller) ?></td>
                <td><?= h($userAccountPermission->action) ?></td>
                <td class="actions" nowrap >
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userAccountPermission->id],['class'=>'btn btn-xs btn-primary']) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userAccountPermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccountPermission->id),'class'=>'btn btn-danger btn-xs']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
