<?php defined('_FINDEX_') or die('Access Denied');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>STIE YAPAN SURABAYA</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="favicon.ico" />
<!-- Styles -->
<?php 
	addCss('themes/css/bootstrap.css');  
	addCss('themes/css/detail.css');   
?>
</head><body><div id="content"><div class="container"><div class="row"><div class="span12">
<?php 
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default:
	break;

	case "alumni":
		require('detail/alumni.php');
	break;

	case "BukuInduk":
		require('detail/bukuinduk.php');
	break;

	case "Gbpp":
		require('detail/gbpp.php');
	break;

	case "Sap":
		require('detail/sap.php');
	break;

	case "Mtk":
	require('detail/matakuliah.php');
	break;
	
	case "ijazah":
	require('detail/ijazah.php');
	break;
	
}?>
</div></div></div></div> 
<!-- Javascript -->
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
  </body>
</html>