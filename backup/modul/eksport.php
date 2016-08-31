<?php  
defined('_FINDEX_') or die('Access Denied');
ob_start();
if(!empty($_SESSION['yapane']) AND !empty($_SESSION['Identitas'])){
include "librari/ExportToExcel.class.php";
$exp=new ExportToExcel(); 
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
default:
break;

case "dataMhsw":
$jurusan=GetName("jurusan","kode_jurusan",$_REQUEST['md'],"nama_jurusan");
$namaFile=(empty($_REQUEST['md']))? "DATA-SEMUA-MAHASISWA": "DATA-MAHASISWA-$jurusan";
$exp->exportWithPage("modul/mod_eksport/eksDataMhsw.php","$namaFile.xls");
break;

case "bukuBesar":
$exp->exportWithPage("modul/mod_eksport/eksDataBukuBesar.php","BukuBesar.xls");
break;

case "lapBau":
$exp->exportWithPage("modul/mod_eksport/eksLapbau.php","LapKeuangan.xls");
break;

case "MhswRekanan":
$exp->exportWithPage("modul/mod_eksport/eksMhswRekanan.php","MhswRekanan.xls");
break;

case "transaksi":
$Natrans=NamaTransaksi($_REQUEST['md']);
$namaFile=(empty($_REQUEST['md']))? "DATA-SEMUA-TRANSAKSI": "DATA-TRANSAKSI-$Natrans";
$exp->exportWithPage("modul/mod_eksport/eksTransaksi.php","$namaFile.xls");
break;

case "eksDosen":
$exp->exportWithPage("modul/mod_eksport/eksDosen.php","DataDosen.xls");
break;

}     
 }else{
htmlRedirect('./');
}        
?>
