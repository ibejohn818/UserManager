<?php

$this->Html->css(
	[
		'/bs3_unify/assets/css/pages/page_log_reg_v1'
	],
	[
		'block'=>true
	]
);

$loginUrl = $this->Url->build([
	'plugin'=>'UserManager',
	'controller'=>'Login',
	'action'=>'index',
	'prefix'=>null
]);


?>

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs">
	<div class="container">
		<h1 class="pull-left">Registration</h1>
		<ul class="pull-right breadcrumb">
			<li><a href="index.html">Home</a></li>
			<li><a href="">Pages</a></li>
			<li class="active">Registration</li>
		</ul>
	</div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!--=== Content Part ===-->
<div class="container content">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<form class="reg-page">
				<div class="reg-header">
					<h2>Create an account</h2>
					<ul class="social-icons text-center">
						<li><a class="rounded-x social_facebook" data-original-title="Facebook" href="#"></a></li>
						<li><a class="rounded-x social_googleplus" data-original-title="Google Plus" href="#"></a></li>
					</ul>
					<p>Already have an account? <a href="<?php echo $loginPage; ?>" class="color-green">Click here to sign-in</a></p>
				</div>

				<label>First Name</label>
				<input type="text" class="form-control margin-bottom-20">

				<label>Last Name</label>
				<input type="text" class="form-control margin-bottom-20">

				<label>Email Address <span class="color-red">*</span></label>
				<input type="text" class="form-control margin-bottom-20">

				<div class="row">
					<div class="col-sm-6">
						<label>Password <span class="color-red">*</span></label>
						<input type="password" class="form-control margin-bottom-20">
					</div>
					<div class="col-sm-6">
						<label>Confirm Password <span class="color-red">*</span></label>
						<input type="password" class="form-control margin-bottom-20">
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-lg-6 checkbox">
						<label>
							<input type="checkbox">
							I read <a href="page_terms.html" class="color-green">Terms and Conditions</a>
						</label>
					</div>
					<div class="col-lg-6 text-right">
						<button class="btn-u" type="submit">Register</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div><!--/container-->
<!--=== End Content Part ===-->
