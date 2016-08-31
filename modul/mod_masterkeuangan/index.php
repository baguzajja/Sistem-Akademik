<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
default :
	require('view_masterkeuangan.php');
break;
case "editBuku":
	require('form_buku.php');
break;
case "editTrans":
	require('form_transaksi.php');
break;
}