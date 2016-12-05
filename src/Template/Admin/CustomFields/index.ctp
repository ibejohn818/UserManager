<style type="text/css">
.index span.label {
    font-size:16px;
}
</style>
<?php

$this->Html->addCrumb("User Manager");
$this->Html->addCrumb("Custom Fields");

use UserManager\Model\Entity\UserAccountCustomField;
?>
<?php $this->start("page_header"); ?>
            User Custom Fields
<?php $this->end("page_header"); ?>
<div class="pagination-wrapper index">
	<div class="row">
		<div class="col-md-6">
			<?php echo $this->element("paginator-nav") ?>
		</div>
		<div class="col-md-6">
			<div class="btn-group pull-right">
				<a class='btn btn-success'  href="<?php echo $this->Url->build(['plugin'=>'UserManager','controller'=>'CustomFields','action'=>'add']) ?>">
					<i class="fa fa-plus"></i>
					Create New Field
				</a>
			</div>
		</div>
	</div>
        <table cellspacing="0" class="table table-striped table-bordered table-hover">
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
                    <td><?php echo $this->Time->nice($v->created) ?></td>
                    <td><?php echo $this->Time->nice($v->modified) ?></td>
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
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
</div>
