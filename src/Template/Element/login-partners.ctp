<?php
use UserManager\Lib\GoogleSdk;
    $google = new GoogleSdk();

    if($google->isGoogleLoginConfigured()):
        $googleLoginUrl = $this->Url->build([
            'action'=>'google'
        ]);
 ?>
    <div id="login-google-div">
        <a href="<?php echo $googleLoginUrl; ?>">
            <img src="/user_manager/img/login-google-btn.png" alt="Login With Google" border='0'/>
        </a>
    </div>
<?php endif; ?>
