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
echo"<page format='130x200' orientation='L' backcolor='#edf6f9' style='font: arial;'>";
$trans = $_REQUEST['id'];

$d = GetFields('transaksihnrektor', 'Notrans', $trans, '*');
$tglTransaksi=tgl_indo($d[TglBayar]);
$gajipokok=digit($d['gajipokok']);
$transport=digit($d['transport']);
$jabatan=digit($d['jabatan']);
$potongan=digit($d['potongan']);
$Total=digit($d['Total']);

$rektor = GetFields('karyawan', 'id', $d['userid'], '*');
$NamaJabatan=JabatanStaff($rektor['Jabatan']);
echo"<table style='width: 100%;border: none;' cellspacing='2mm' cellpadding='0'>
        <tr>
            <td style='width: 100%'>
                <div class='zone' style='height: 28mm;position: relative;font-size: 5mm;'>
                    
					<div style='position: absolute; right: 3mm; top: 3mm; text-align: right; font-size: 4mm; '>
                        <i>PEMBAYARAN HONOR REKTORAT - ID : $trans</i><br><br><br><br>
						<span><i>Tanggal : $tglTransaksi</i></span><br>
						<span><i> Nama : $rektor[nama_lengkap]</i></span><br>
						<span><i> Jabatan : $NamaJabatan</i></span>
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
            <td style='width: 60%; text-align: left' >Gaji Pokok</td>
            <td style='width: 40%; text-align: right'>$gajipokok</td>
        </tr>
		<tr>
            <td style='width: 60%; text-align: left' >Tunjangan Transport</td>
            <td style='width: 40%; text-align: right'>$transport</td>
        </tr>
		<tr>
            <td style='width: 60%; text-align: left' >Tunjangan Jabatan</td>
            <td style='width: 40%; text-align: right'>$jabatan</td>
        </tr>
		<tr>
            <td style='width: 60%; text-align: left' >Potongan</td>
            <td style='width: 40%; text-align: right'>$potongan</td>
        </tr>
    </table>";

echo"<table cellspacing='0' style='width: 100%; border: solid 1px #FFF; background: #FFF; text-align: center; font-size: 10pt; color: #333;'>
        <tr>
            <th style='width: 60%; text-align: right;'>TOTAL :</th>
            <th style='width: 40%; text-align: right;'>$Total</th>
        </tr>
    </table>";
echo"</td></tr>";

echo"<tr>
		<td style='width: 100%;'>
	<table cellspacing='0' style='width: 100%; border: solid 1px #F7F7F7;font-size: 10pt;'>
        <tr>
            <td style='width: 60%; text-align: left'> 
			<p style='text-align: left'> <br>&nbsp;&nbsp;<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PENERIMA
				<br><br><br><br><br><br>
				<b> ( $rektor[nama_lengkap] ) </b>
				</p>
			</td>
            <td style='width: 40%; text-align: right'> 
				<p style='text-align: right'> <br><i>Surabaya, $tglTransaksi</i><br>
				BAU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<br><br><br><br><br><br>
				<b> ( $d[SubmitBy] )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
				</p>
			</td>
        </tr>
    </table>
            </td>
        </tr></table>";
FooterPdf(); 
echo"</page>";
?>