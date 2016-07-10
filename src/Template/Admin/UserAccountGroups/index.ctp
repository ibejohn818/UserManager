<div class="container-fluid">
    <div class="page-header">
        <h1>
            User Account Groups
        </h1>
    </div>
    <div class="">
        
        <ul class="nav nav-pills">
            <li><?= $this->Html->link(__('New User Account Group'), ['action' => 'add']) ?></li>
            <li><?= $this->Html->link(__('List User Account Group Assignments'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('New User Account Group Assignment'), ['controller' => 'UserAccountGroupAssignments', 'action' => 'add']) ?></li>
            <li><?= $this->Html->link(__('List User Account Permissions'), ['controller' => 'UserAccountPermissions', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('New User Account Permission'), ['controller' => 'UserAccountPermissions', 'action' => 'add']) ?></li>
        </ul>
    </div>
    <?php echo $this->element('paginator-nav') ?>
    <div class=" index">
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
                <td><?= $this->Number->format($userAccountGroup->id) ?></td>
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
    <?php echo $this->element('paginator-nav') ?>
    </div>

</div>
