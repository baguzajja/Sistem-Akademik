<?php defined('_FINDEX_') or die('Access Denied'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Lupa Password - STIE YAPAN</title>
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
			<h1>LUPA PASSWORD</h1>		
			<div class="login-fields">
				<?php alert($pesan,$isipesan); ?>
				<div class="field">
					<label for="username">Email:</label>
					<input type="email" name="mail" type="email" autocomplete="OFF" class="login mail-field" placeholder="Masukkan Alamat Email Anda ...." required/>
				</div> <!-- /field -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				<span class="login-checkbox">
					<a href="./" class="btn_1">Login Kembali.</a>
				</span>		
				<button class="button btn btn-info btn-large" type="submit" name='forgot_password'>Kirim</button>
			</div> <!-- .actions -->
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