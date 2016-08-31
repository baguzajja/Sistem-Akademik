<?php 
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
		addCss(AdminPath.'/js/plugins/lightbox/themes/evolution-dark/jquery.lightbox.css');  
		addCss(AdminPath.'/css/kalender.css'); 
	break;
	case 'Tahun':
		addCss(AdminPath.'/js/plugins/datatables/DT_bootstrap.css'); 
		addCss(AdminPath.'/js/plugins/responsive-tables/responsive-tables.css'); 
	break;
	case 'Event':
		addCss(AdminPath.'/js/plugins/datatables/DT_bootstrap.css'); 
		addCss(AdminPath.'/js/plugins/responsive-tables/responsive-tables.css'); 
	break;
	case 'EditEvent':
		addCss(AdminPath.'/js/plugins/colorpicker/css/colorpicker.css'); 
	break;
}
	
?>
