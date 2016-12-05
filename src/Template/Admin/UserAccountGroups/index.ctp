<?php
$this->Html->addCrumb("User Manager");
$this->Html->addCrumb("User Groups");
$newGroupUrl = $this->Url->build([
	'action'=>'add'
]);

?>
<?php $this->start("page_header"); ?>
User Account Groups
<?php $this->end("page_header"); ?>
<div class="pagination-wrapper index">
	<div class="row">
		<div class="col-md-6">
				<?php echo $this->element('paginator-nav') ?>
		</div>
		<div class="col-md-6">
			<div class="btn-group pull-right">
			<a href="<?php echo $newGroupUrl; ?>" class="btn btn-success">Add New Group</a>
			</div>
		</div>
	</div>
        <table cellpadding="0" cellspacing="0" class='table table-bordered table-striped table-hover'>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('default') ?></th>
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
                <td><?= h($userAccountGroup->name) ?></td>
				<td><?php echo $userAccountGroup->default; ?></td>
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
