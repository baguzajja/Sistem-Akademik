<?php
ob_start();
if(!empty($_SESSION['yapane']) AND !empty($_SESSION['Identitas'])){
function HeaderKops(){
$t= GetFields('identitas', 'Identitas_ID', $_SESSION[Identitas], 'Nama_Identitas,KodeHukum,Email,Website,Alamat1,Telepon,Fax,Kota');
echo"<table class='page_header'>
        <tr>
            <td style='width: 10%;border-bottom: solid 0.5mm #000000; text-align: center;'>
				<img style='width: 80pt;' src='modul/mod_print/img/logoyapan.png' alt='STIE YAPAN'>
            </td>
            <td style='width: 90%; color: #000000; text-align: center;border-bottom: solid 0.5mm #000000;padding-bottom: 4mm;'>
				<span style='font-size: 12pt;font-weight: bold;'>$t[Nama_Identitas] ( STIE YAPAN ) SURABAYA<br>
                <span class='sk'>$t[KodeHukum]</span><br>
                TERAKREDITASI &rdquo; B &rdquo;<br>
                <span class='sk'>E-mail : $t[Email]. Homepage : $t[Website]</span>
                </span><br>
                <span class='bord'>Kampus :  $t[Alamat1] Telp: $t[Telepon] Fax : $t[Fax] .$t[Kota]</span>
            </td>
        </tr>
    </table>";
}
function HeaderS1($PRODI){
$t= GetFields('identitas', 'Identitas_ID', $_SESSION[Identitas], 'Nama_Identitas,KodeHukum,Email,Website,Alamat1,Telepon,Fax,Kota');
echo"<table class='page_header'>
        <tr>
            <td style='width: 10%;border-bottom: solid 0.5mm #000000;'  valign='middle'>
				<img style='width: 80pt;' src='modul/mod_print/img/logoyapan.png' alt='STIE YAPAN'>
            </td>
            <td style='width: 90%; color: #000000; text-align: center;border-bottom: solid 0.5mm #000000;padding-bottom: 4mm;'>
				<span style='font-size: 12pt;font-weight: bold;'>$t[Nama_Identitas] ( STIE YAPAN ) SURABAYA<br>
                <span class='sk'>$t[KodeHukum]</span><br>
                PROGRAM SARJANA (S-1) - $PRODI<br>
                <span class='sk'>E-mail : $t[Email]. Homepage : $t[Website]</span>
                </span><br>
                <span class='bord'>Kampus :  $t[Alamat1] Telp: $t[Telepon] Fax : $t[Fax] .$t[Kota]</span>
            </td>
        </tr>
    </table>";
}
function HeaderS2(){
$t= GetFields('identitas', 'Identitas_ID', $_SESSION[Identitas], 'Nama_Identitas,KodeHukum,Email,Website,Alamat1,Telepon,Fax,Kota');
echo"<table class='page_header'>
        <tr>
            <td style='width: 10%;border-bottom: solid 0.5mm #000000;'>
				<img style='width: 80pt;' src='modul/mod_print/img/logoyapan.png' alt='STIE YAPAN'>
            </td>
            <td style='width: 90%; color: #000000; text-align: center;border-bottom: solid 0.5mm #000000;padding-bottom: 4mm;'>
				<span style='font-size: 12pt;font-weight: bold;'>$t[Nama_Identitas] ( STIE YAPAN ) SURABAYA<br>
                <span class='sk'>$t[KodeHukum]</span><br>
               PROGRAM PASCASARJANA (S-2) - MAGISTER MANAJEMEN<br>
                <span class='sk'>E-mail : $t[Email]. Homepage : $t[Website]</span>
                </span><br>
                <span class='bord'>Kampus :  $t[Alamat1] Telp: $t[Telepon] Fax : $t[Fax] .$t[Kota]</span>
            </td>
        </tr>
    </table>";
}
function HeaderPdf($kiri,$kanan){
echo"<table class='page_headers'>
            <tr>
                <td style='width: 50%; text-align: left'> $kiri</td>
                <td style='width: 50%; text-align: right'>$kanan</td>
            </tr>
        </table>";
}
function FooterPdf(){
echo"<table class='page_footer'>
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
        </table>";
}
?>
<html>
<head>
  <title>Cetak</title>
  <?php 
	addCss('themes/css/bootstrap.css');  
	 addCss('themes/css/detail.css');   
    ?>
  <style type="text/css">
<!--

table.month{
	width: 100%; 
    border:1px solid #ccc;
    margin-bottom:10px;
    border-collapse:collapse;
}

table.month td{
    border:1px solid #ddd;
    color:#333;
    padding:3px;
    text-align:left;
}

table.month th {
    padding:5px;
	background-color:#208bbd;
    color:#fff;
	text-align:center;
}
table.month th.head{
	background-color:#EEE;
	text-align:center;
	 color:#444444;
}
 table.page_header {width: 100%;border-bottom: solid 0.5mm #000000;margin-top:1mm}
table.page_footer {width: 100%; border: none; background-color: #fcfcfc; border-top: solid 1mm #213699; padding: 2mm; color:#213699;font-weight: bold;}
    div.note {border: solid 1mm #DDDDDD;background-color: #EEEEEE; padding: 2mm; border-radius: 2mm; width: 100%; }
    div.barcode {border: solid 1mm #DDDDDD;}   
    h1 { text-align: center; font-size: 20mm}
    span.sk  {  margin-top: 1mm;}
    span.bord  {  width: 100%;font-size: 11pt}
    p {}     
    h3 { text-align: center; font-size: 14mm}
    table.page_code {width: 100%; border: none; padding: 2mm; font-weight: bold;}
    div.special { margin: auto; width:90%; padding: 5px; }
    div.special table { width:100%; font-size:10px; border-collapse:collapse; }
    .pagebreak {
    page-break-after: always;
    }
    *{
    font-family: 'Open Sans', arial, sans-serif; 
    margin:0px;
    padding:1pt;
    }
    @page {
     margin-left:3cm 2cm 2cm 2cm; 
    }
-->
</style>

</head>
<body>
<div class="widget highlight">
<input id="printer" type="hidden" value="<?php echo siteConfig('printer_default');?>">
<?php
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act){

    default:
	break; 

    case "mhsDetpay":
        include('conten/mhsDetpay.php');
    break;
    
    case "mhspay":
        include('conten/mhspay.php');
    break;
    case "transaksi":
        include('conten/transaksi.php');
    break;
    
    case "transaksiStaff":
        include('conten/transaksiStaff.php');
    break;
    case "transaksiDosen":
        include('conten/transaksiDosen.php');
    break;
    case "transaksiRektorat":
        include('conten/transaksiRektorat.php');
    break;
    case "transaksiPakai":
        include('conten/transaksiPakai.php');
    break;
    
    case "transaksiBeli":
        include('conten/transaksiBeli.php');
    break;
    
    case "transaksiJual":
        include('conten/transaksiJual.php');
    break;
    
    case "rekananpay":
        include('conten/rekpay.php');
    break;
}
?>
</div>
<script type="text/javascript" src="./modul/mod_print/js/deployJava.js"></script>
<script type="text/javascript" src="./modul/mod_print/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="./modul/mod_print/script.js"></script>
<script type="text/javascript">
function printFile() {
    if (findPrinter()) { return; }
        qz.setAutoSize(true);
        qz.appendFile("http://akademik.stieyapan.com/media/files/dataprint/<?php echo $_REQUEST['id'];?>.txt");
        qz.print();
    }
</script>
</body><canvas id="hidden_screenshot" style="display:none;"></canvas>
</html>
<?php
}else{
htmlRedirect('./');
}   