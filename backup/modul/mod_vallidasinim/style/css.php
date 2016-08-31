<?php 
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
		addCss(AdminPath.'/js/plugins/responsive-tables/responsive-tables.css'); 
		addCss(AdminPath.'/js/plugins/lightbox/themes/evolution-dark/jquery.lightbox.css'); 
	break;
}
	
?>
