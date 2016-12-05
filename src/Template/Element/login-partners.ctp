<?php

use UserManager\Config\Config;

?>

<?php if(Config::get("googleLoginEnable")): ?>
	<a href="" class="btn btn-default">
		<i class="fa fa-google"></i>
		Login With Google
	</a>
<?php endif; ?>

<?php if(Config::get("facebookLoginEnable")): ?>
	<a href="" class="btn btn-default">
		<i class="fa fa-facebook"></i>
		Login With Facebook
	</a>
<?php endif; ?>

<?php if(Config::get("githubLoginEnable")): ?>
	<a href="" class="btn btn-default">
		<i class="fa fa-github"></i>
		Login With Github
	</a>
<?php endif; ?>

<?php if(Config::get("twitterLoginEnable")): ?>
	<a href="" class="btn btn-default">
		<i class="fa fa-twitter"></i>
		Login With Twitter
	</a>
<?php endif; ?>
