<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
	 require('view_inventaris.php');
	break;
	case 'edit':	 
	 require('form.php');
	break;
	
}