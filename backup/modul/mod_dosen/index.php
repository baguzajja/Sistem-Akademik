<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
	 require('view_dosen.php');
	break;
	case 'edit':	 
	 require('edit.php');
	break;
	case 'add':	 
	 require('add.php');
	break;
	case 'penelitian':	 
	 require('penelitian.php');
	break;
	case 'pekerjaan':	 
	 require('pekerjaan.php');
	break;
	case 'pendidikan':	 
	 require('pendidikan.php');
	break;
	case 'import':	 
	 require('import.php');
	break;
	case 'delpendidikan':	 
		$nama_tabel="dosenpendidikan";
		$kondisi="DosenPendidikanID='$_REQUEST[id]'";
		delete($nama_tabel,$kondisi);
		htmlRedirect("actions-dosen-edit-0-$_REQUEST[md].html",1);
		alert('info','Pendidikan Dosen Berhasil Di Hapus');
		CatatLog($_SESSION[Nama],'Hapus Pendidikan Dosen','Pendidikan Dosen Berhasil Di Hapus');
	break;
	case 'delpenelitian':	 
		$nama_tabel="dosenpenelitian";
		$kondisi="DosenPenelitianID='$_REQUEST[id]'";
		delete($nama_tabel,$kondisi);
		htmlRedirect("actions-dosen-edit-0-$_REQUEST[md].html",1);
		alert('info','Penelitian Dosen Berhasil Di Hapus');
		CatatLog($_SESSION[Nama],'Hapus Penelitian Dosen','Penelitian Dosen Berhasil Di Hapus');
	break;
	case 'delpekerjaan':	 
		$nama_tabel="dosenpekerjaan";
		$kondisi="DosenPekerjaanID='$_GET[id]'";
		delete($nama_tabel,$kondisi);
		htmlRedirect("actions-dosen-edit-0-$_REQUEST[md].html",1);
		alert('info','Pekerjaan Dosen Berhasil Di Hapus');
		CatatLog($_SESSION[Nama],'Hapus Pekerjaan Dosen','Pekerjaan Dosen Berhasil Di Hapus');
	break;
}