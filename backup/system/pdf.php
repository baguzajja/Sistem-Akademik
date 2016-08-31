<?php
ob_start();
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "../librari/koneksi.php";
include "../librari/library.php";
include "../librari/fungsi_combobox.php";
include "../librari/lib.php";
function HeaderKops(){
$t= GetFields('identitas', 'Identitas_ID', $_SESSION[Identitas], '*');
echo"<table class='page_header'>
        <tr>
            <td style='width: 20%; text-align: center;'>
				<br><img style='width: 70%;' src='../yapan/img/logo.png' alt='STIE YAPAN'>
            </td>
            <td style='width: 80%; color: #213699; text-align: center; font-size: 12pt;'>
				<p style='font-size: 14pt;font-weight: bold;'>$t[Nama_Identitas]<br>
              <b>( STIE YAPAN )</b></p>
				<span class='sk'>$t[KodeHukum]</span>
				<h2>TERAKREDITASI &rdquo; B &rdquo;</h2>
				<span class='sk'>E-mail : $t[Email]. Homepage : $t[Website]</span>
            </td>
        </tr>
		<tr style='width: 100%; color: #213699; font-size: 11pt; text-align: center; margin-top:-3mm;'><td colspan='2' class='bord'> Kampus :  $t[Alamat1] Telp: $t[Telepon] Fax : $t[Fax] .$t[Kota] </td></tr>
    </table>";
}
function HeaderS1($PRODI){
$t= GetFields('identitas', 'Identitas_ID', $_SESSION[Identitas], '*');
echo"<page_header><table class='page_header'>
        <tr>
            <td style='width: 20%; text-align: center;'>
				<br><img style='width: 57%;' src='../yapan/img/logo.png' alt='STIE YAPAN'>
            </td>
            <td style='width: 80%; color: #213699; text-align: center; font-size: 12pt;'>
				<p style='font-size: 12pt;font-weight: bold;'>$t[Nama_Identitas]<br>
              <b>( STIE YAPAN )</b></p>
				<span class='sk'>$t[KodeHukum]</span>
				<p style='font-size: 12pt;font-weight: bold; margin-top:-4mm;'>PROGRAM SARJANA (S-1) - $PRODI</p>
				<span class='sk'>E-mail : $t[Email]. Homepage : $t[Website]</span>
            </td>
        </tr>
		<tr style='width: 100%; color: #213699; font-size: 11pt; text-align: center; margin-top:-3mm;'><td colspan='2' class='bord'> Kampus :  $t[Alamat1] Telp: $t[Telepon] Fax : $t[Fax] .$t[Kota] </td></tr>
    </table></page_header>";
}
function HeaderS2(){
$t= GetFields('identitas', 'Identitas_ID', $_SESSION[Identitas], '*');
echo"<page_header><table class='page_header'>
        <tr>
            <td style='width: 20%; text-align: center;'>
				<br><img style='width: 57%;' src='../yapan/img/logo.png' alt='STIE YAPAN'>
            </td>
            <td style='width: 80%; color: #213699; text-align: center; font-size: 12pt;'>
				<p style='font-size: 12pt;font-weight: bold;'>$t[Nama_Identitas]<br>
              <b>( STIE YAPAN )</b></p>
				<span class='sk'>SK. Mendikbud RI No. 347/E/O/2012</span>
				<p style='font-size: 12pt;font-weight: bold; margin-top:-4mm;'>PROGRAM PASCASARJANA (S-2) - MAGISTER MANAJEMEN</p>
				<span class='sk'>E-mail : $t[Email]. Homepage : $t[Website]</span>
            </td>
        </tr>
		<tr style='width: 100%; color: #213699; font-size: 11pt; text-align: center; margin-top:-3mm;'><td colspan='2' class='bord'> Kampus :  $t[Alamat1] Telp: $t[Telepon] Fax : $t[Fax] .$t[Kota] </td></tr>
    </table></page_header>";
}
function HeaderPdf($kiri,$kanan){
echo"<page_header>
        <table class='page_headers'>
            <tr>
                <td style='width: 50%; text-align: left'> $kiri</td>
                <td style='width: 50%; text-align: right'>$kanan</td>
            </tr>
        </table>
    </page_header>";
}
function FooterPdf(){
echo"<page_footer>
        <table class='page_footer'>
            <tr>
                <td style='width: 33%; text-align: left;'>
                   www.akademik.stieyapan.com
                </td>
                <td style='width: 34%; text-align: center'>
                    page [[page_cu]]/[[page_nb]]
                </td>
                <td style='width: 33%; text-align: right'>
                    &copy;  STIE YAPAN 2013
                </td>
            </tr>
        </table>
    </page_footer>";
}?>
<style type="text/css">
<!--
 table.page_headers {width: 100%; border: none; background-color: #fcfcfc; border-bottom: solid 1mm #213699; padding: 1mm;font-weight: bold;color: #213699;}
 table.page_header {width: 100%; border: none; background-color: #fcfcfc; border-bottom: solid 1mm #213699; padding: 1mm; margin-top: -4mm;}
    table.page_footer {width: 100%; border: none; background-color: #fcfcfc; border-top: solid 1mm #213699; padding: 2mm; color:#213699;font-weight: bold;}
    div.note {border: solid 1mm #DDDDDD;background-color: #EEEEEE; padding: 2mm; border-radius: 2mm; width: 100%; }
    
    h1 { text-align: center; font-size: 20mm}
span.sk  {  margin-top: -4mm;}
.bord  {  width: 100%; border-top: dashed 1pt #CCC;}
    h2 {  margin-top: -4mm;}
    h3 { text-align: center; font-size: 14mm}
-->
</style>
<?php
switch($_GET[Action]){

  default:
	break; 
 
  case "Matakuliah":
	include(dirname(__FILE__).'/versiPdf/matakuliah.php');
	$filename="daftar-matakuliah.pdf";
  break;

case "JadwalKuliah":
    include(dirname(__FILE__).'/versiPdf/jadwalkuliah.php');
	$filename="Jadwal-kuliah.pdf";
  break;

case "krs":
	include(dirname(__FILE__).'/versiPdf/krs.php');
	$filename="krs.pdf";
  break;

case "khs":
	include(dirname(__FILE__).'/versiPdf/khs.php');
	$filename="khs.pdf";
  break;

case "transkrip":
	include(dirname(__FILE__).'/versiPdf/transkrip.php');
	$filename="transkrip.pdf";
  break;
case "induk":
	include(dirname(__FILE__).'/versiPdf/bukuinduk.php');
	$filename="bukuInduk.pdf";
  break;

}
    $content = ob_get_clean();
    // convert to PDF
    require_once(dirname(__FILE__).'/../librari/pdf/html2pdf.class.php');
    try
    {
	$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->createIndex('', '', 0, false, false, 1);
        $html2pdf->Output($filename);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }