<?php
defined('_FINDEX_') or die('Access Denied');

//Load fungsi 
require_once ('config.php');
require_once ('function.php');
require_once ('lib.php');
require_once ('query.php');

//set default timezone
date_default_timezone_set(siteConfig('timezone'));

//Global Variable
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];
$saiki 			= date("Y-m-d");
$tgl_sekarang 	= date("Ymd");
$today     		= date("d");
$BulanIni 		= date("m");
$TahunIni 		= date("Y");
$jam_sekarang 	= date("H:i:s");
$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
$hitu ="onFocus='startCalc();' 
		onBlur='stopCalc();' 
		onkeyup='formatNumber(this);' 
		onchange='formatNumber(this);'";
//Panggil System
loadSystemApps();