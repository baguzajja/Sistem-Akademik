<style type="text/css">
<!--
table.month{
	width: 100%; 
    border:1px solid #ccc;
    margin-bottom:10px;
    border-collapse:collapse;
}
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }

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

    table.page_header {width: 100%; border: none; background-color: #208bbd; color:#fff; border-bottom: solid 1mm #086d8e; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #208bbd; color:#fff; border-top: solid 1mm #086d8e; padding: 2mm}
   div.zone { border: none; border-radius: 6mm; background: #FFFFFF; border-collapse: collapse; padding:3mm; font-size: 2.7mm;}
    h1 { padding: 0; margin: 0; color: #DD0000; font-size: 7mm; }
    h2 { padding: 0; margin: 0; color: #222222; font-size: 5mm; position: relative; }
-->
</style>
<?php
//Tampilkan
global $tgl_sekarang;
echo"<page format='100x200' orientation='L' backcolor='#edf6f9' style='font: arial;'>";
$trans = $_REQUEST['id'];

$s="SELECT * FROM transaksi WHERE TransID='$trans' ";
$hasil = _query($s) or die();
$d=_fetch_array($hasil);
$tr = GetFields('jenistransaksi', 'id', $d[Transaksi], '*');
$NamaTransaksi=$tr[Nama];
$tglTransaksi=tgl_indo($d[TglSubmit]);
$jum=($d[Debet]==0)? $d[Kredit]:$d[Debet];
$jumlah=digit($jum);

$mhsw = GetFields('mahasiswa', 'NoReg', $d[AccID], '*');
echo"<table style='width: 100%;border: none;' cellspacing='2mm' cellpadding='0'>
        <tr>
            <td style='width: 100%'>
                <div class='zone' style='height: 28mm;position: relative;font-size: 5mm;'>
                    
					<div style='position: absolute; right: 3mm; top: 3mm; text-align: right; font-size: 4mm; '>
                        <i>$NamaTransaksi - ID : $trans</i><br><br><br><br>
						<span><i> Nama : $mhsw[Nama]</i></span><br>
						<span><i> Nim : $mhsw[NIM]</i></span><br>
                    </div>
                    <img src='themes/img/logo.png' alt='logo' style='margin-top: 2mm; margin-left: 2mm; width: 14%'/>
                  
                </div>
            </td>
        </tr>
        <tr>
        <td style='width: 100%'>";
echo"<table cellspacing='0' style='width: 100%; border: solid 1px #208bbd; background: #208bbd; font-size: 10pt; color: #FFF;'>
        <tr>
            <th style='width: 60%'>URAIAN</th>
            <th style='width: 40%; text-align: right'>JUMLAH</th>
        </tr>
    </table>";
	
echo"<table cellspacing='0' style='width: 100%; border: solid 1px #F7F7F7; background: #F7F7F7; font-size: 10pt;'>
        <tr>
            <td style='width: 60%; text-align: left' >$d[Uraian]</td>
            <td style='width: 40%; text-align: right'>$jumlah</td>
        </tr>
    </table>";

echo"<table cellspacing='0' style='width: 100%; border: solid 1px #FFF; background: #FFF; text-align: center; font-size: 10pt; color: #333;'>
        <tr>
            <th style='width: 60%; text-align: right;'>TOTAL :</th>
            <th style='width: 40%; text-align: right;'>$jumlah</th>
        </tr>
    </table>";
echo"</td></tr>";

echo"<tr>
		<td style='width: 100%;'>
<table cellspacing='0' style='width: 100%; border: solid 1px #F7F7F7;font-size: 10pt;'>
        <tr>
            <td style='width: 50%; text-align: left' > </td>
            <td style='width: 50%; text-align: right'> 
				<br><i>Surabaya, $tglTransaksi</i><br><br><br><br><br>
				<b> ( $d[SubmitBy] ) </b>
			</td>
        </tr>
    </table>
            </td>
        </tr></table>";
FooterPdf(); 
echo"</page>";
?>