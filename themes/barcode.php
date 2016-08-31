<?php defined('_FINDEX_') or die('Access Denied'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>VALIDASI - STIE YAPAN</title>
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
<body onload="document.getElementById('readBarcode').focus();">
<div class="container">
<div class="row"> 
<?php if($pesan=='info'){?>
<?=$isipesan; ?>
<?php }else{ ?>
<div class="BigLogo span6">
	<div class="contentBG clearfix">
		<img src='<?php echo AdminPath; ?>/img/logo.png' alt="Sekolah Tinggi Ilmu Ekonomi"/>
		<p>Sekolah Tinggi Ilmu Ekonomi<br>STIE YAPAN - SURABAYA</p>
	</div>
</div>
<div class="account-container span6">
	<div class="content clearfix"> 
		<form method="post">
		<h1>VALIDASI</h1>		
			<div class="login-fields">
				<?php alert($pesan,$isipesan); ?>
				<div class="field">
					<label for="username">Barcode </label>
					<input type="text" id="readBarcode" name="readBarcode" onChange='this.form.submit()'/>
				</div>  
			</div>  
			<div class="login-actions">
				<span class="login-checkbox">
					<a href="./" class="btn btn-danger"> Kembali.</a>
				</span>		 
			</div>  
		</form>
	</div>  
</div>
<?php } ?>

</div>
</div>
</body>
</html>