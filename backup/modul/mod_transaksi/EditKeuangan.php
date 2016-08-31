<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){

$maha=_fetch_array(_query("SELECT * FROM mahasiswa INNER JOIN keuanganmhsw 
ON NIM = KeuanganMhswID WHERE keuanganmhsw.RegID='$_GET[id]'"));
$tahun=substr($maha['NIM'],0,4);
$NamaRekanan=NamaRekanan($maha['RekananID']);
$NamaKelas=NamaKelasa($maha['IDProg']);
if($maha['RekananID']==''){
$biaya=_fetch_array(_query("SELECT SUM(Jumlah) as total FROM biayamhsw WHERE TahunID='$tahun' AND JenjangID='$maha[JenjangID]' AND KelasID='$maha[kelasID]'"));
$totBiaya=Comaa($biaya['total']);
$disable=(empty($biaya['total']))? "disabled":"";
$info=(empty($biaya['total']))? "error":"success";
$rekan="REGULER";
$help=(empty($biaya['total']))? "<i>  Biaya Pendidikan Untuk $maha[JenjangID] - $NamaKelas - Tahun $tahun , <b>Belum Di setting !!</b> </i>":"<i> Biaya Pendidikan $maha[JenjangID] - $NamaKelas - Tahun $tahun</i>";
}else{
$disable="";
$info="";
$totBiaya=Comaa($maha['TotalBiaya']);
$rekan="REKANAN";
$help="<i> Harga Rekanan $NamaRekanan</i>";
}
echo"<div class='widget widget-form'>
<div class='widget-header'>	      				
	<h3><i class='icon-edit'></i> EDIT KEUANGAN MAHASISWA</h3>	
	<div class='widget-actions'>
	  
	</div> 
</div>
<div class='widget-content'>
<form method='post' class='form-horizontal' name=''>
	<input type=hidden name='RegID' value='$_GET[id]'>
<fieldset>
<div class='control-group'>
		<div class='row-fluid'>
				<div class='span4'>
					<label class='control-label'>NIM :</label>
					<div class='controls'>
						<input type='text' value='$maha[NIM]' class='span12' readonly/>
					</div>
				</div>
				<div class='span4'>
					<label class='control-label'>Nama : </label>
					<div class='controls'>
						<input type='text' value='$maha[Nama]' class='span12' readonly/>
					</div>
				</div>
				<div class='span4'>
					<label class='control-label'>Program : </label>
					<div class='controls'>
						<input type='text' value='$rekan' class='span12' readonly/>
					</div>
				</div>
		</div>
</div>";
		
		echo"<div class='control-group $info'>
				<label class='control-label'>Total Biaya</label>
				<div class='controls'>
					<input type=text name='nominal' value='$totBiaya' class='input-xlarge' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\" required $disable/>
					<span class='help-inline'>$help</span>
				</div>
			</div>
</div>
<div class='widget-toolbar' style='text-align: center'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanBiayaMhs'>
	<input type='button' value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-transaksi-pay.html';\">
</div> 
</div></form></fieldset></div>";
 }else{
ErrorAkses();
} ?>