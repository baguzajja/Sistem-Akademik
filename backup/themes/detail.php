<?php defined('_FINDEX_') or die('Access Denied');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo loadJudul(); ?> - STIE YAPAN SURABAYA</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="favicon.ico" />
<!-- Styles -->
<?php 
	addCss(AdminPath.'/css/bootstrap.css'); 
	addCss(AdminPath.'/css/bootstrap-responsive.css');  
	addCss(AdminPath.'/css/bootstrap-overrides.css');  
	addCss(AdminPath.'/css/ui-lightness/jquery-ui-1.8.21.custom.css');  
	addCss(AdminPath.'/css/yapan.css');  
	addCss(AdminPath.'/css/yapan-responsive.css');  
	loadAdminCss();
?>
</head>
<body>
<?php require("menu.php"); ?>
<div id="content">
	<div class="container">
		<div class="row">
		
		<div class="span12">
			
			<div class="error-container">
				<h1>Oops!</h1>
				
				<h2><?php echo $pesan; ?></h2>
				
				<div class="error-details">
					<?php echo $isipesan; ?>
					
				</div> <!-- /error-details -->
				
				<div class="error-actions">
					<a href="./" class="btn btn-large btn-primary">
						<i class="icon-chevron-left"></i>
						&nbsp;
						Kembali Ke Home						
					</a>
				</div> <!-- /error-actions -->
							
			</div> <!-- /error-container -->			
			
		</div> <!-- /span12 -->
		
	</div> <!-- /row -->

	</div> <!-- /.container -->
</div> <!-- /#content -->

<div id="footer">	
	<div class="container">
		&copy; 2013 STIE YAPAN - SURABAYA	
	</div> <!-- /.container -->		
</div> <!-- /#footer -->
<!-- Javascript -->
	<?php 
		addJs(AdminPath.'/js/jquery-1.7.2.min.js'); 
		addJs(AdminPath.'/js/jquery-ui-1.8.21.custom.min.js'); 
		addJs(AdminPath.'/js/jquery.ui.touch-punch.min.js'); 
		addJs(AdminPath.'/js/bootstrap.js'); 
		addJs(AdminPath.'/js/yapan.js'); 
		loadAdminJs();
	?>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
  </body>
</html>