<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
	 require('view_jadwalKuliah.php');
	break;
	case 'AllJadwal':	
	 require('view_all.php');
	break;
	case 'EditJadwal':	 
	 require('form_jadwal.php');
	break;
	case 'EditUjian':	 
	 require('form_ujian.php');
	break;
	
}