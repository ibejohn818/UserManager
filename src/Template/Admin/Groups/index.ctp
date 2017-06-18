<?php
$this->Html->addCrumb("User Manager");
$this->Html->addCrumb("User Groups");
$newGroupUrl = $this->Url->build([
	'action'=>'add'
]);

$this->Breadcrumbs->add("User Accounts");
$this->Breadcrumbs->add("Groups");

?>
<?php $this->start("heading"); ?>
UserAccount Groups
<?php $this->end("heading"); ?>
<?php $this->start("heading_action"); ?>
	<?php echo $this->UserManager->authorizeBtn("success","New Group",['action'=>'add'],['icon'=>'fa-users']); ?>
<?php $this->end("heading_action"); ?>

		<?php echo $this->element('paginator-nav') ?>
<div class="pagination-wrapper table-responsive index">
        <table cellpadding="0" cellspacing="0" class='table table-striped'>
        <thead>
            <tr>
                <th style='width: 10%; '><?= $this->Paginator->sort('id') ?></th>
                <th style='width: 10%;'><?= $this->Paginator->sort('created') ?></th>
                <th style=' width:10%;  white-space: nowrap; text-align:center;'><?= $this->Paginator->sort('default_group') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($userAccountGroups as $userAccountGroup): ?>
            <tr>
                <td><?= $userAccountGroup->id ?></td>
                <td>
                    <?php echo $this->Time->nice($userAccountGroup->created) ?>
                </td>
				<td style='text-align:center; width:1%; white-space:nowrap;'>
				<?php
					switch($userAccountGroup->default_group){
						case 1:
							echo "<span class='label label-success'><i class='fa fa-check'></i></span>";
							break;
						default:
							echo "<span class='label'><i class='fa fa-times'></i></span>";
							break;
					}
				?>
				</td>
                <td><?= h($userAccountGroup->name) ?></td>
                <td class="actions">
                <?php 
                    $editUrl = $this->Url->build(['action' => 'edit', $userAccountGroup->id]);
                 ?>
                    <a href="<?php echo $editUrl ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
        </table>
</div>
