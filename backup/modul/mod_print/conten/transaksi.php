<?php
//Tampilkan
global $saiki;
$trans          = $_REQUEST['id'];
$d              = GetFields('transaksi', 'TransID', $trans, 'TglSubmit,Transaksi,Debet,Kredit,AccID,Uraian,SubmitBy');
$NamaTransaksi  =strtoupper(GetName("jenistransaksi","id","$d[Transaksi]","Nama"));
$tglTransaksi   =tgl_indo($d['TglSubmit']);
$jum            =($d['Debet']==0)? $d['Kredit']:$d['Debet'];
$jumlah         =digit($jum);
$mhsw           = GetFields('mahasiswa', 'NoReg', $d['AccID'], 'Nama,NIM,kode_jurusan');
$Prodi          =NamaProdi($mhsw['kode_jurusan']);
?>
<div class="widget-header">	
    <h3>PEMBAYARAN MAHASISWA</h3>
        <input id="printer" type="hidden" value="<?php echo siteConfig('printer_default');?>">
        <div class="btn-group pull-right" style='margin-right: 5px;margin-top: 5px;'>	
        <a class='btn btn-inverse' onClick="printHTML5Page()"><i class='icon-print'></i>Cetak </a>
        <a class='btn btn-inverse' href="get-print-transaksi-<?php echo $trans;?>.html"><i class='icon-file'></i>Pdf </a>
        </div> 
</div> 
					
<div class="widget-content">
<div id="yapan">
<?php
if($mhsw['kode_jurusan']=='61101'){
	HeaderS2();
}else{
	HeaderS1($Prodi);
}
echo"<table style='width: 100%; font-size: 4mm; cellpadding:2px;color:#000000'>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <th colspan='4' style='width: 100%; text-align:center;'>$NamaTransaksi <br></th>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;TANGGAL</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $tglTransaksi</td>
            <td style='width: 10%;'>&nbsp;&nbsp;TRANS ID</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $trans</td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;NAMA</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$mhsw[Nama]</td>
            <td style='width: 10%;'>&nbsp;&nbsp;NIM</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $mhsw[NIM]</td>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;URAIAN</td>
            <td colspan='3' style='width: 90%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$d[Uraian]</td>
        </tr>
    </table><br>";
$nowws=tgl_indo($saiki);  
echo"<table cellspacing='0' style='width: 100%;font-size: 10pt;'>
        <tr>
            <td style='width: 10%; text-align: center' >
            &nbsp;&nbsp;<br>
            <b>JUMLAH : </b><br>
            &nbsp;&nbsp;
            </td>
            <td style='width: 50%; text-align: left' >
            -----------------------------------------<br>
            <b>Rp. $jumlah</b><br>
            -----------------------------------------
            </td>
            <td style='width: 40%; text-align: center;border-bottom: dotted 0.5mm #000000;'> 
				<b>Surabaya, $nowws</b><br><br><br><br><br>
				<b> ( $d[SubmitBy] ) </b>
			</td>
        </tr>
    </table>";
?>
    </div>
</div> 