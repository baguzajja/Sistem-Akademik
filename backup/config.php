<?php
defined('_FINDEX_') or die('Access Denied');
$DBName	= 'stieyapa_sia2014';
$DBHost	= 'localhost';
$DBUser	= 'stieyapa_mift4';
$DBPass	= 'mift4p1j4t';

$koneksi=mysql_connect($DBHost,$DBUser,$DBPass);
if (! $koneksi){
  echo "Gagal Koneksi..!".mysql_error();
  }
mysql_select_db($DBName)
or die ("Database Tidak Ada".mysql_error());
?>
