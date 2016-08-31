<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
$mhs = GetFields('mahasiswa', 'MhswID', $_GET['id'], '*');
//tampilkan form transaksi
echo"<div class='widget-content'>
<form method='post' class='form-horizontal' name=''>
	<input type=hidden name='id' value='$_GET[id]'>
<fieldset>
			<div class='control-group'>
			</div>";
		
		echo"<div class='control-group'>
				<label class='control-label'>NIM</label>
				<div class='controls'>
					<input type=text value='$mhs[NIM]' class='input-xxlarge' readonly/>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>NAMA</label>
				<div class='controls'>
					<input type=text value='$mhs[Nama]' class='input-xxlarge' readonly/>
				</div>
			</div>
            <div class='control-group'>
				<label class='control-label'>GANTI REKANAN</label>
				<div class='controls'>
					<select name='Grekan' class='input-xxlarge'>
						<option value='0'>- Pilih Rekanan -</option>";
						$sqlp="select RekananID,NamaRekanan from rekanan ORDER BY NamaRekanan DESC";
						$qryp=_query($sqlp) or die();
						while ($r=_fetch_array($qryp)){
                        
						if ($r['RekananID']==$mhs['RekananID']){ $cek="selected"; } else{ $cek=""; }
						echo "<option value='$r[RekananID]' $cek> $r[NamaRekanan]</option>";
						}
						echo"</select>
				</div>
			</div>
</div>
<div class='widget-toolbar' style='text-align: center'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='UPDATE' name='ChangeRekanan'>
	<input type='button' value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-AkademikRekanan.html';\">
</div> 
</div></form></fieldset>";
 }else{
ErrorAkses();
} ?>