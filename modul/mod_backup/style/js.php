<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{

	default :
		addJs('modul/mod_'.$mod.'/script.js'); 
	break;
	case 'editmodul':	 
	 

	break;

}
	
?>