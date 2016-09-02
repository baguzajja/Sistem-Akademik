<?php
defined('_FINDEX_') or die('Access Denied');
$DBName	= 'user';
$DBHost	= 'localhost';
$DBUser	= 'root';
$DBPass	= '';

$koneksi=mysql_connect($DBHost,$DBUser,$DBPass);
if (! $koneksi){
  echo "Gagal Koneksi..!".mysql_error();
  }
mysql_select_db($DBName)
or die ("Database Tidak Ada".mysql_error());
?>
