<?php





$this->Html->css(
    [
        "UserManager.login/login"
    ],
    [
        "block"=>true
    ]
);

?>
<div class="jumbotron">
    <h1 class="text-center">
        <i class="fa fa-user"></i>
    </h1>
</div>
<div class="container">
    <div id="login">
            <?php
                echo $this->Form->create($userAccount,array(
                    "id"=>'UserAccountForm',
                    "url"=>$this->request->here
                ));
             ?>
        <div class="panel panel-default" id='login-panel'>
            <div class="panel-heading">
                <h1 class="panel-title">
                    Login
                </h1>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <?php

                            echo $this->Form->input("email",['label'=>'Email Address']);
                            echo $this->Form->input("passwd",['label'=>'Password']);
                         ?>
                         <div class="text-center">
                             <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                         </div>
                    </div>
                </div>

            </div>

        </div>

        <?php echo $this->Form->end(); ?>
    </div>
    <div class="login-partners">
        <?php echo $this->element('UserManager.login-partners') ?>
    </div>
</div>


<div>
    <?php pr($this->request->session()->read()); ?>
<?php pr($_SERVER); ?>
</div>
