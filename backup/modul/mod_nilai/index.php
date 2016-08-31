<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
	 require('view_nilai.php');
	break;

	case 'add':	 
	 require('form.php');
	break;

	case 'import':	 
	 require('import.php');
	break;
}