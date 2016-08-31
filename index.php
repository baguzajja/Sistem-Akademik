<?php
//error_reporting(0);
//set mulai session
session_start();
//mendefinisikan _FINDEX_ sebagai halaman utama
define('_FINDEX_', 'BACK' );

$sn = substr($_SERVER['PHP_SELF'],1);
$sm = strpos($sn,'/');
$sm = substr($sn,0,$sm);
define('_ADMINPANEL_', $sm );

//memuat file pendukung query dan fungsi lainya
require_once ('librari/core.php');
switch(@$_REQUEST['page']) {
		case 'remember':	 
		//Form Lupa Password
		load_Reset_Password();
		break;
		case 'barcode':	 
		//Form Lupa Password
		load_barcode();
		break;
		case 'eksport':	 
		//Proses Download
		require_once ('modul/eksport.php');
		break;

		case 'download':	 
		//Proses Download
		require_once ('modul/dounlut.php');
		break;
		case 'print':	 
		//Proses Cetak Pdf
		require_once ('modul/mod_cetak/pdf.php');
		break;
        
        case 'prind':	 
		//Proses Cetak Dot Matrix
		require_once ('modul/mod_print/index.php');
		break;
        
		case 'detail':	 
		//Proses Detail
		require_once ('modul/mod_detail/detail.php');
		break;
        
        case 'Web_kalenderAkademik':		 
		//Proses Detail
		require_once ('modul/mod_web/kalenderAkademik.php');
		break;
        
        case 'Web_alumni':		 
		//Proses Detail
		require_once ('modul/mod_web/alumni.php');
		break;
        
		default :
		//melakukan pengecekan login
		check_backend_login();
		break;
	}