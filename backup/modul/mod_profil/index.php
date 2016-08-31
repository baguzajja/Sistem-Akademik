<?php
defined('_FINDEX_') or die('Access Denied');
	$level= ceklevel($_SESSION[yapane]);
	$tbl = GetaField('level', 'id_level', $level, 'TabelUser');
	if ($tbl=='admin'){
require('form_admin.php');
	}
	elseif ($tbl=='karyawan'){
require('form_karyawan.php');
	}
	elseif ($tbl=='dosen'){
require('form_dosen.php');
	}
	elseif ($tbl=='mahasiswa'){
require('form_mahasiswa.php');
	}