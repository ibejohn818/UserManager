<script type="text/javascript">
</script>
<?php

$this->Html->addCrumb("User Manager Admin","/");
$this->Html->addCrumb("User Accounts","/");

$this->Html->css(
    [
        'UserManager.admin-user-accounts-index'
    ],
    [
        'block'=>true
    ]
);

 ?>

<?php $this->start("page_header"); ?>

<?php $this->end("page_header"); ?>

<?php if(!$this->request->is('ajax')): ?>
    <div>

        <ul class="nav nav-pills">
            <li><?= $this->Html->link(__('New User Account'), ['action' => 'add']) ?></li>
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
<?php endif; ?>

    <div class="container-fluid">
		<?php echo $this->element("paginator-nav"); ?>
        <div class="userAccounts index ">
        <table cellpadding="0" cellspacing="0" class='table table-stripped table-hover table-bordered'>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('first_name') ?></th>
                <th><?= $this->Paginator->sort('last_name') ?></th>
                <th><?= $this->Paginator->sort('middle_name') ?></th>
                <th align='center'><?= $this->Paginator->sort('active') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($userAccounts as $userAccount): ?>
            <tr>
                <td><?= $this->Number->format($userAccount->id) ?></td>
                <td><?= h($userAccount->created) ?></td>
                <td><?= h($userAccount->modified) ?></td>
                <td><?= h($userAccount->email) ?></td>
                <td><?= h($userAccount->first_name) ?></td>
                <td><?= h($userAccount->last_name) ?></td>
                <td><?= h($userAccount->middle_name) ?></td>
                <td align='center'>
                    <?php
                        switch ($userAccount->active) {
                            case 1:
                                echo "<span class='label label-success'><i class='fa fa-thumbs-up'></i></span>";
                                break;

                            default:
                                echo "<span class='label label-danger'><i class='fa fa-thumbs-down'></i></span>";
                                break;
                        }
                     ?>
                </td>
                <td class="actions">
					<?php if($this->request->is('ajax')): ?>
					<a href="" class="btn btn-success btn-xs" rel='select-user'
						data-user-id='<?php echo $userAccount->id; ?>'
						data-user-email='<?php echo $userAccount->email; ?>'
						data-user-first-name='<?php echo $userAccount->first_name; ?>'
					>
							<i class="fa fa-plus-o"></i>
							Select User
						</a>
					<?php else: ?>
						<?php

							$editUrl = $this->Url->build([
								'action'=>'edit',
								$userAccount->id
							]);

							$passwordUrl = $this->Url->build([
								'action'=>'password',
								$userAccount->id
							]);


						?>

						<a href="<?php echo $editUrl ?>" class="btn btn-primary btn-xs">
						<i class="fa fa-edit"></i>  Edit
						</a>
						<a href="<?php echo $passwordUrl ?>" class="btn btn-info btn-xs">
						<i class="fa fa-key"></i>  Password
						</a>
						<?= $this->Form->postLink("<i class='fa fa-times-circle'></i>  Delete", ['action' => 'delete', $userAccount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccount->id),'class'=>'btn btn-danger btn-xs','escape'=>false]) ?>
					<?php endif; ?>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
        </table>

    </div>
</div>
