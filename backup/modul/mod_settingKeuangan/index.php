<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
default :
	require('view_settingKeuangan.php');
break;
case "editRek":
	require('form_rekening.php');
break;
case "editDos":
	require('form_hdosen.php');
break;
case "editBM":
	require('form_biayamahasiswa.php');
break;
case "editHR":
	require('form_hrektor.php');
break;
case "editGS":
	require('form_gajistaff.php');
break;
}