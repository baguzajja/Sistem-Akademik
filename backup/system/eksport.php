<?php  
session_start();
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
include "../librari/koneksi.php";
include "../librari/lib.php";
include "../librari/library.php";
include "../librari/fungsi_combobox.php";
include "../librari/ExportToExcel.class.php";
$exp=new ExportToExcel();
function Defeksport(){ }

switch($_GET[PHPIdSession]){

default:
Defeksport();
break;

case "dataMhsw":
$exp->exportWithPage("core/eksDataMhsw.php","DataMahasiswa.xls");
break;

case "bukuBesar":
$exp->exportWithPage("core/eksDataBukuBesar.php","BukuBesar.xls");
break;

case "lapBau":
$exp->exportWithPage("core/eksLapbau.php","LapKeuangan.xls");
break;

case "MhswRekanan":
$exp->exportWithPage("core/eksMhswRekanan.php","MhswRekanan.xls");
break;

case "eksTransaksi":
$exp->exportWithPage("core/eksTransaksi.php","Transaksi.xls");
break;

case "eksDosen":
$exp->exportWithPage("core/eksDosen.php","DataDosen.xls");
break;

}     
        
?>
