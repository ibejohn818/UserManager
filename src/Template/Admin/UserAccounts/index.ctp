<script type="text/javascript">
</script>
<?php

$this->Html->addCrumb("User Manager Admin",['action'=>'index']);
$this->Html->addCrumb("User Accounts");

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
User Accounts
<?php $this->end("page_header"); ?>


    <div class="pagination-wrapper index" id="admin-user-accounts-index">
		<div class="row">
			<section class="col-md-6">
				<?php echo $this->element("paginator-nav"); ?>
			</section>
			<section class="col-md-6">
				<?php if(!$this->request->is('ajax')): ?>
					<div class="btn-group pull-right">
						<?php echo $this->UserManager->authorizeBtn("success","New User Account",['action'=>'add'],['icon'=>'fa-user']); ?>
					</div>
				<?php endif; ?>
			</section>
		</div>
        <div class="userAccounts index ">
        <table cellpadding="0" cellspacing="0" class='table table-stripped table-hover table-bordered'>
        <thead>
            <tr>
                <th class='hidden-xs hidden-sm'><?= $this->Paginator->sort('id') ?></th>
                <th class='hidden-xs hidden-sm'><?= $this->Paginator->sort('created') ?></th>
                <th class='hidden-xs hidden-sm'><?= $this->Paginator->sort('modified') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th class='hidden-xs'><?= $this->Paginator->sort('first_name') ?></th>
                <th class='hidden-xs'><?= $this->Paginator->sort('last_name') ?></th>
                <th class='hidden-xs hidden-sm'><?= $this->Paginator->sort('middle_name') ?></th>
                <th align='center'><?= $this->Paginator->sort('active') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($userAccounts as $userAccount): ?>
            <tr>
                <td class='hidden-xs hidden-sm'><?= $this->Number->format($userAccount->id) ?></td>
                <td class='hidden-xs hidden-sm'><?= h($userAccount->created) ?></td>
                <td class='hidden-xs hidden-sm'><?= h($userAccount->modified) ?></td>
                <td><?= h($userAccount->email) ?></td>
                <td class='hidden-xs'><?= h($userAccount->first_name) ?></td>
                <td class='hidden-xs'><?= h($userAccount->last_name) ?></td>
                <td class='hidden-xs hidden-sm'><?= h($userAccount->middle_name) ?></td>
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
