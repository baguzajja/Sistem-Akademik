<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
	 require('view_kelas.php');
	break;
	case 'edit':	 
	 require('form.php');
	break;
	
}