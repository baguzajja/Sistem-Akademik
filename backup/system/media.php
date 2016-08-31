<?php 
session_start();
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
include "../librari/koneksi.php";
include "../librari/library.php";
include "../librari/fungsi_combobox.php";
include "../librari/lib.php";
if (empty($_SESSION[yapane]) AND empty($_SESSION[passwordte])){
	lompat_ke('../');
} else {
$page=$_GET[page];
CatatLog($_SESSION[Nama],$_GET[PHPIdSession]);
$judul=strtoupper(JudulSitus($page));
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
	<title><?php echo "$judul"; ?> - STIE YAPAN SURABAYA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Akademik 2013">
    <meta name="author" content="Achtanaputra.com">
	<link rel="shortcut icon" href="../favicon.ico" />
    <link href="../yapan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../yapan/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="../yapan/css/yapan-bootstrap.min.css" rel="stylesheet">
    <link href="../yapan/css/yapan-bootstrap-responsive.min.css" rel="stylesheet">
    <link href="../yapan/css/font-awesome.css" rel="stylesheet">
	<link href='../yapan/css/font.css' rel='stylesheet' type='text/css'>
<link href="http://fonts.googleapis.com/css?family=Pontano+Sans" rel='stylesheet' type='text/css'> 
    <link href="../yapan/css/admin.css" rel="stylesheet">
  <link href="../yapan/css/redactor.css" rel="stylesheet">
	<link href="../yapan/css/jquery.fileupload-ui.css" rel="stylesheet">
<link rel="stylesheet" href="../yapan/js/colorbox/colorbox.css" type="text/css" media="screen" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="stylesheet" href="../yapan/js/bootstrap-colorpicker/css/colorpicker.css">
	<link href="../yapan/style/style.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="./img/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="./img/ico/apple-touch-icon-57-precomposed.png">
  </head>

<body>
<?php 
if (empty($_SESSION[yapane]) AND empty($_SESSION[passwordte])){
echo"";
} else {
include "menu.php";
}
?>
<div id="subnav-strip">
    <div class="container">
        <div class="row">
            <div class="span12">
			<div class='subnav'>
				<ul class='nav nav-pills'>
				<li><a>.:: SISTEM INFORMASI AKADEMIK - STIE YAPAN SURABAYA ::.</a></li>
				<li class="pull-right"><a>.:: V.01 ::.</a></li>
				</ul>
            </div>
            </div>
        </div>
    </div>
</div>

<div id="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="panel">
				<?php include "content.php"; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="footer">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="divider"></div>
                <div class="pull-right">
                    <p>Achtanaputra</p>
                </div>
                <div class="pull-left">
                    <p>&copy; 2013 STIE YAPAN - SURABAYA</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../yapan/js/jquery-1.7.2.min.js"></script>
<script src="../yapan/js/jquery.flot.js"></script>
<script src="../yapan/js/jquery.flot.pie.js"></script>
<script src="../yapan/js/jquery.flot.resize.js"></script>
<script src="../yapan/js/jquery.sparkline.min.js"></script>
<script src="../yapan/js/yapan.js"></script>
<script src="../yapan/js/jquery.dataTables.min.js"></script>
<script src="../yapan/js/dataTables.bootstrap.js"></script>
<script src="../yapan/js/bootstrap.js"></script>
<script src="../yapan/js/redactor.min.js"></script>
<script src="../yapan/js/jquery.validate.min.js"></script>
<script src="../yapan/js/bootstrap-fileupload.js"></script>
<script src="../yapan/js/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="../yapan/js/colorbox/jquery.colorbox.js"></script>
</body>
</html>
<?php } ?>
