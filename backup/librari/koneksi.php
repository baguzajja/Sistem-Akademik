<?php
$my['host'] = "localhost";
$my['user'] = "stieyapa_y4p4ne";
$my['pass'] = "y4p4np1j4t";
$my['dbs'] = "stieyapa_sia2013";

$koneksi=mysql_connect($my['host'],$my['user'],$my['pass']);
if (! $koneksi){
  echo "Gagal Koneksi..!".mysql_error();
  }
mysql_select_db($my['dbs'])
or die ("Database Tidak Ada".mysql_error());
?>
