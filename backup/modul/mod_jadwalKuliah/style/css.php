<?php 
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
		addCss(AdminPath.'/css/ui-lightness/jquery-ui-1.8.21.custom.css'); 
		addCss(AdminPath.'/js/plugins/datatables/DT_bootstrap.css'); 
		addCss(AdminPath.'/js/plugins/responsive-tables/responsive-tables.css'); 
		addCss(AdminPath.'/js/plugins/lightbox/themes/evolution-dark/jquery.lightbox.css'); 
	break;
	case 'EditJadwal':
		addCss(AdminPath.'/js/plugins/timepicker/jquery.ui.timepicker.css'); 
	break;
	case 'EditUjian':
		addCss(AdminPath.'/js/plugins/timepicker/jquery.ui.timepicker.css'); 
	break;
}
	
?>
