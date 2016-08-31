<?php 
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
		addCss(AdminPath.'/css/ui-lightness/jquery-ui-1.8.21.custom.css'); 
	break;
	case 'edit':

	break;
}
	
?>
