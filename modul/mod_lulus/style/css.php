<?php 
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
		addCss(AdminPath.'/css/ui-lightness/jquery-ui-1.8.21.custom.css'); 
		addCss(AdminPath.'/js/plugins/datatables/DT_bootstrap.css'); 
		addCss(AdminPath.'/js/plugins/responsive-tables/responsive-tables.css'); 
	break;
	case 'edit':
		addCss(AdminPath.'/js/plugins/lightbox/themes/evolution-dark/jquery.lightbox.css'); 
	break;
}
	
?>
