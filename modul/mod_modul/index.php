<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
	 require('view_modul.php');
	break;
	case 'editmodul':	 
	 require('form.php');
	break;
	
}