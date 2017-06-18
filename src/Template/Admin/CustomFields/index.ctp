<?php

$this->Html->addCrumb("User Manager");
$this->Html->addCrumb("Custom Fields");

use UserManager\Model\Entity\UserAccountCustomField;
$this->Breadcrumbs->add('User Accounts');
$this->Breadcrumbs->add('Custom Fields');
?>
<?php $this->start("heading"); ?>
            User Account Custom Fields
<?php $this->end("heading"); ?>
<?php $this->start("heading_action"); ?>
<?php echo $this->UserManager->authorizeBtn("primary","Create new fields",[
	'controller'=>'CustomFields',
	'action'=>'add',
	'plugin'=>'UserManager',
	'prefix'=>'admin'
],[
	'icon'=>'fa-plus'
]);
?>
<?php $this->end("heading_action"); ?>
			<?php echo $this->element("paginator-nav") ?>
<div class="pagination-wrapper table-responsive index">
        <table cellspacing="0" class="table table-striped">
            <thead>
                <tr>
                    <th>
                        <?php echo $this->Paginator->sort("id") ?>
                    </th>
                    <th>
                        <?php echo $this->Paginator->sort("created") ?>
                    </th>
                    <th>
                        <?php echo $this->Paginator->sort("modified") ?>
                    </th>
                    <th width='1%' nowrap>
                        <?php echo $this->Paginator->sort("active") ?>
                    </th>
                    <th width='1%' nowrap>
                        <?php echo $this->Paginator->sort("visible") ?>
                    </th>
                    <th>
                        <?php echo $this->Paginator->sort("name") ?>
                    </th>
                    <th>
                        <?php echo $this->Paginator->sort("field_type") ?>
                    </th>
                    <th>
                        <?php echo $this->Paginator->sort("slug") ?>
                    </th>
                    <th>
                        -
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customFields as $k => $v): ?>
                <tr>
                    <td><?php echo $v->id ?></td>
                    <td style='white-space: nowrap; width: 1%'><?php echo $this->Time->nice($v->created) ?></td>
                    <td  style='white-space: nowrap; width: 1%'><?php echo $this->Time->nice($v->modified) ?></td>
                    <td class='text-center'>
                        <?php 
                            switch($v->active) {
                                case 1:
                                    echo "<span class='label label-success'><i class='fa fa-thumbs-up'></i></span>";
                                break;
                                default:
                                    echo "<span class='label label-danger'><i class='fa fa-thumbs-down'></i></span>";
                                break;
                            }
                         ?>
                    </td>
                    <td class='text-center'>
                         <?php 
                            switch($v->visible) {
                                case 1:
                                    echo "<span class='label label-success'><i class='fa fa-eye'></i></span>";
                                break;
                                default:
                                    echo "<span class='label label-danger'><i class='fa fa-eye-slash'></i></span>";
                                break;
                            }
                         ?>
                    </td>
                    <td><?php echo $v->name; ?></td>
                    <td><?php echo UserAccountCustomField::fieldTypes()[$v->field_type]; ?></td>
					<td><?= $v->slug; ?></td>
                    <td class='actions'>
                        <a href="<?php echo $this->Url->build(["plugin"=>"UserManager","controller"=>"CustomFields","action"=>"edit",$v->id]); ?>" class="btn btn-primary btn-xs">
                            <i class="fa fa-edit"></i> Edit
                        </a>
						<?= $this->Form->postLink("Delete",['action'=>'delete',$v->id],['method'=>'delete','class'=>'btn btn-danger btn-xs','confirm'=>"Are you sure you want to delete: {$v->name}?"]) ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
</div>
