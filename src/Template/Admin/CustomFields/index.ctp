<style type="text/css">
.index span.label {
    font-size:16px;
}
</style>
<?php 
use UserManager\Model\Entity\UserAccountCustomField;
?>
<div class="container-fluid">
    <div class="page-header">
        <h1>
            User Custom Fields
        </h1>
    </div>
    <ul class="nav nav-pills">
        <li>
            <a href="<?php echo $this->Url->build(['plugin'=>'UserManager','controller'=>'CustomFields','action'=>'add']) ?>">
                Create New Field
            </a>
        </li>
    </ul>
    <?php echo $this->element("paginator-nav") ?>
    <div class="index">
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
</div>