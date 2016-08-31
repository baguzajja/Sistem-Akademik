<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{

	default :
		addJs('modul/mod_'.$mod.'/script.js'); 
		addJs(AdminPath.'/js/plugins/datatables/jquery.dataTables.js');
		addJs(AdminPath.'/js/plugins/datatables/DT_bootstrap.js');
		addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
	break;
	case 'edit':	 
		addJs(AdminPath.'/js/plugins/lightbox/jquery.lightbox.js');
	break;

}
	
?>