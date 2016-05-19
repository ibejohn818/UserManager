<?php

 ?>
<script type="text/javascript">
var autoCompleteAjax=false;
jQuery(document).ready(function($) {

    $("#user-account-id").autocomplete({
      source:function(request,response) {
        var url = "/admin/user-manager/user-accounts/user-account-auto-complete";
        if(autoCompleteAjax) {
            autoCompleteAjax.abort();
        }
        autoCompleteAjax = $.ajax({
            url:url,
            data:{
                'term':request.term
            },
            dataType:'json',
            type:"get",
            success:function(data) {
                response(data);
            }
        });
      }
    //   focus: function( event, ui ) {
    //     $( "#project" ).val( ui.item.label );
    //     return false;
    //   },
    //   select: function( event, ui ) {
    //     $( "#project" ).val( ui.item.label );
    //     $( "#project-id" ).val( ui.item.value );
    //     $( "#project-description" ).html( ui.item.desc );
    //     $( "#project-icon" ).attr( "src", "images/" + ui.item.icon );
      //
    //     return false;
      
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.name + "<br>" + item.email + "</a>" )
        .appendTo( ul );
    };

});
</script>
<div class="page-header">
    <h1>
        Create New User Permission
    </h1>
</div>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="nav nav-pills">

        <li><?= $this->Html->link(__('List User Account Permissions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List User Account Groups'), ['controller' => 'UserAccountGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account Group'), ['controller' => 'UserAccountGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Accounts'), ['controller' => 'UserAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Account'), ['controller' => 'UserAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="index container-fluid">
    <?= $this->Form->create($userAccountPermission) ?>

        <?php
            echo $this->Form->input('allowed');
            echo $this->Form->input('user_account_group_id', ['options' => $userAccountGroups, 'empty' => true]);
            echo $this->Form->input('user_account_id', ['type'=>'text']);
            echo $this->Form->input('prefix');
            echo $this->Form->input('plugin');
            echo $this->Form->input('controller');
            echo $this->Form->input('action');
        ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
