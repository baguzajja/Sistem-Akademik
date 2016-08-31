<?php defined('_FINDEX_') or die('Access Denied'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>LOGIN AKADEMIK - STIE YAPAN</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
	<link rel="shortcut icon" href="favicon.ico" />
    <!-- Styles -->
    <link href="<?php echo AdminPath; ?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo AdminPath; ?>/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo AdminPath; ?>/css/bootstrap-overrides.css" rel="stylesheet">
    <link href="<?php echo AdminPath; ?>/css/yapan.css" rel="stylesheet">
	<link href="<?php echo AdminPath; ?>/css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href="<?php echo AdminPath; ?>/css/components/signin.css" rel="stylesheet" type="text/css">   
</head>
<body>
<div class="container">
<div class="row">
<div class="BigLogo span6">
	<div class="contentBG clearfix">
		<img src='<?php echo AdminPath; ?>/img/logo.png' alt="Sekolah Tinggi Ilmu Ekonomi"/>
		<p>Sekolah Tinggi Ilmu Ekonomi<br>STIE YAPAN - SURABAYA</p>
	</div>
</div>
<div class="account-container span6">
	<div class="content clearfix">
		<form method="post">
			<h1>LOGIN AKADEMIK</h1>		
			<div class="login-fields">
				<?php alert($pesan,$isipesan); ?>
				<div class="fieldt">
				<select name="KodeId" class="login"><option value=0 selected>STIE YAPAN - SURABAYA</option></select>
				</div><!-- /field -->
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" id="username" placeholder='Username' name='yapane' autocomplete='off' class="login username-field" required/>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" placeholder='Password' name='passwordte' autocomplete='off' class="login password-field" required/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			<div class="login-actions">
				<span class="login-checkbox">
					<a href="go-remember.html" class="">Lupa Password...?</a><br>
					<a href="go-barcode.html" class="">Scan Barcode</a>
				</span>	
				<button class="button btn btn-info btn-large" type="submit" name='go_login'>Masuk   <i class="icon-signin"></i></button>
			</div>
		</form>
	</div> <!-- /content -->
</div> <!-- /account-container -->
</div>
</div>
<!-- Javascript -->
    <script src="<?php echo AdminPath; ?>/js/jquery-1.7.2.min.js"></script>
	<script src="<?php echo AdminPath; ?>/js/jquery-ui-1.8.18.custom.min.js"></script>    
	<script src="<?php echo AdminPath; ?>/js/jquery.ui.touch-punch.min.js"></script>
	<script src="<?php echo AdminPath; ?>/js/bootstrap.js"></script>
</body>
</html>