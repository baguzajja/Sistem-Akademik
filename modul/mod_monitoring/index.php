<?php
defined('_FINDEX_') or die('Access Denied');
global $TahunIni,$today,$BulanIni;
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
		require('view_monitoring.php');
	break;
	case "ujian":
		require('view_ujian.php');
	break; 
	case "rekap":
		require('view_rekap.php');
	break; 
	case "presensiKuliah":
		require('form_kuliah.php');
	break;
	case "presensiUjian":
		require('form_ujian.php');
	break; 
}