<?php  
use UserManager\Lib\GoogleSdk;

$google = new GoogleSdk();


if($google->isGoogleLoginConfigured()):
    $googleLoginUrl = $this->Url->build([
        'action'=>'google',
        'plugin'=>'UserManager',
        'controller'=>'Login'
    ]);
 ?>
<a href="<?php echo $googleLoginUrl; ?>">
    Login with Google
</a>
<?php endif; ?>
