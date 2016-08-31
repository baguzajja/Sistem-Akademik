<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
	 require('view_matakuliah.php');
	break;
//Matakuliah
	case 'all':	 
	 require('view_all.php');
	break;
	case 'editAll':	 
	 require('form_all.php');
	break;
//Konsentrasi
	case 'konsentrasi':	 
	 require('view_konsentrasi.php');
	break;
	case 'editKonsentrasi':	 
	 require('form_konsentrasi.php');
	break;
//Kurikulum
	case 'kurikulum':	 
	 require('view_kurikulum.php');
	break;
	case 'editKurikulum':	 
	 require('form_kurikulum.php');
	break;
//Kode MTK
	case 'KodeMtk':	 
	 require('view_kodeMtk.php');
	break;
	case 'editKodeMtk':	 
	 require('form_kodemtk.php');
	break;
}