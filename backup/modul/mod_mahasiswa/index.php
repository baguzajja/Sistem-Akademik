<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
default :
	 require('view_mahasiswa.php');
break;

case 'edit':	 
	 require('edit.php');
break;

case 'add':	 
	 require('add.php');
break;

case 'maba':	 
	 require('view_maba.php');
break;

case 'import':	 
	 require('import.php');
break;
}