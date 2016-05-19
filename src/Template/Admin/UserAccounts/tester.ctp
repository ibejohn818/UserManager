<div class="container-fluid">
    <div class="page-header">
    <h1>
        User Accounts - Custom Fields
    </h1>
</div>
<table cellspacing="0" class="table table-stripped table-bordered table-hover">
    <thead>
        <tr>
            <?php foreach ($customFieldsSchema as $k => $v): ?>
                <th>
                    <?php 

                        $sortKey = (!preg_match('/(\.)/',$v)) ? "`{$v}`":$v;

                        echo $this->Paginator->sort($sortKey,$v); 
                    ?>
                </th>
            <?php endforeach ?>
                <th>-</th>
        </tr>
    </thead>
    <?php foreach ($users as $k => $user): ?>
        <tr>
        <?php foreach ($customFieldsSchema as $kk => $vv): ?>
            <td>
                <?php 
                    $key = explode(".", $vv);
                    $key = (isset($key[1])) ? $key[1]:$key[0];
                    echo $user->get($key); 
                ?>
            </td>
        <?php endforeach ?>
            <td class='actions'>
                 <?php 

                        $editUrl = $this->Url->build([
                            'action'=>'edit',
                            $user->id
                        ]);

                        $passwordUrl = $this->Url->build([
                            'action'=>'password',
                            $user->id
                        ]);


                     ?>

                     <a href="<?php echo $editUrl ?>" class="btn btn-primary btn-xs">
                      <i class="fa fa-edit"></i>  Edit
                     </a>
                     <a href="<?php echo $passwordUrl ?>" class="btn btn-info btn-xs">
                      <i class="fa fa-key"></i>  Password
                     </a>
            </td>
        </tr>
    <?php endforeach ?>
</table>
</div>