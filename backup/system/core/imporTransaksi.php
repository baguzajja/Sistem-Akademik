<?php  
function Defabauimport(){
$id = $_REQUEST['PHPIdSession'];
$Natrans=NamaTransaksi($id);
if($id=='17' OR $id=='18'){
$file="transaksiMhsw";
}else{
$file="transaksi";
}
buka("BAU :: Import Data Transaksi $Natrans");
echo "<legend><div class='row-fluid'>
<div class='span5'>
<form method=post enctype='multipart/form-data' action='aksi-imporTransaksi-$id.html'>
<input type=hidden name='jenistransaksi' value='$id'>
<div class='fileupload fileupload-new' data-provides='fileupload'>
						<div class='input-append input-prepend'>
							<div class='uneditable-input span3'><i class='icon-file fileupload-exists'></i> <span class='fileupload-preview'></span></div><span class='btn btn-file'><span class='fileupload-new'>Pilih file</span><span class='fileupload-exists'>Ganti</span><input type='file' name='import_file'/></span><a href='#' class='btn fileupload-exists' data-dismiss='fileupload'>Hapus</a>
						
						</div>
					</div>
</div>
<div class='span3'>
<input class='btn btn-success' type=submit name='Import' value='IMPORT DATA'>
</form>
</div>

<div class='span4'>
<div class='pull-right'>
	<a class='btn btn-danger' href='get-transaksiKeuangan-jurnalTrans-$id.html'><i class='icon-undo'></i> Kembali</a>

</div>
</div>
</div></legend>";
if(isset( $_POST['Import'])){
$trans=$_POST['jenistransaksi'];
import($trans);
}else{
echo"<div class='alert'>
			<button class='close' data-dismiss='alert'>&times;</button>
			<strong>Perhatian !! Tools ini Khusus Untuk Meng-Import Transaksi $Natrans</strong> <br>Perhatikan Format Excel yang Sudah di sediakan. Atau <a href='down-fileContoh-$file.html'>Download disini</a> Untuk contoh format $Natrans
		</div>";
}
tutup();

}
function import($trans){
global $tgl_sekarang;
$waktu=time(); 
include "../librari/excel_reader.php";
if($trans=='17' OR $trans=='18' ){
	$data = new Spreadsheet_Excel_Reader($_FILES['import_file']['tmp_name']);
	$baris = $data->rowcount($sheet_index=0);
	$sukses = 0;
	$gagal = 0;
		for ($i=2; $i<=$baris; $i++)
		{ 
				$n1 = trimed($data->val($i, 1));
				$n2 = trimed($data->val($i, 2));
				$n3 = trimed($data->val($i, 3));
				$n4 = trimed($data->val($i, 4));
				$n5 = trimed($data->val($i, 5));
				$n6 = trimed($data->val($i, 6));
		// cek data keuangan mahasiswa.
		$transID=GenerateID('transaksi','TransID',$n4,'BAU');
		$cekkeu=_query("SELECT * FROM mahasiswa a, keuanganmhsw b WHERE a.NIM=b.KeuanganMhswID AND a.NIM='$n1'");
		$cekkeuangan = _num_rows($cekkeu);
if(!empty($cekkeuangan)) {
	$w=_fetch_array($cekkeu);
		$book=($w[JenjangID]=='S1')? 4: 7;
		$buku=($w[JenjangID]=='S1')? 1: 9;
		$tahun=substr($n1,0,4);
			if($w[TotalBiaya]==0){
				if($n2=='REGULER'){
				$biaya=_fetch_array(_query("SELECT SUM(Jumlah) as total FROM biayamhsw WHERE TahunID='$tahun'"));
				$tot=$biaya[total];
				$Upkeuangan= _query("UPDATE keuanganmhsw SET 
				Total='$tot', 
				TotalBiaya ='$tot', 
				Aktif ='Y', 
				ApproveDate='$n4',
				Keterangan='Mahasiswa Baru'
				WHERE KeuanganMhswID='$n1'");
				}else{
				$Upkeuangan= _query("UPDATE keuanganmhsw SET 
				Total='$n6', 
				TotalBiaya ='$n6',Aktif ='Y',  
				ApproveDate='$n4', Keterangan='Mahasiswa Baru' WHERE KeuanganMhswID='$n1'");
				}
			$msukPiutang=_query("INSERT INTO transaksi (TransID,Buku,Transaksi,Debet,Kredit,AccID,TglBayar,SubmitBy,TglSubmit,Uraian,TanggalCatat,IDpiutang) VALUES ('$transID','$book','19','$tot','0','$w[NoReg]','$n4','$_SESSION[Nama]','$n4', 'Penerimaan Mahasiswa Baru NO REGISTRASI :$w[NoReg]', '$waktu', '')");
			}
//masukkan transaksi
	$hasil=_query("INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
	('$transID', '$buku', '$trans', '$n5', '0', '$w[NoReg]', '$n4', '$_SESSION[Nama]', '$n4', '$n3', '$waktu', '$book','')");
//masukkan Piutang
if ($hasil){
	$hasil1=_query("INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
	('$transID', '$book', '$trans', '0', '$n5', '$w[NoReg]', '$n4', '$_SESSION[Nama]', '$n4', '$n3', '$waktu', '$book','')");
		}
if ($hasil) $sukses++; else $gagal++;
	}
	
	}
InfoMsgs("IMPORT DATA TRANSAKSI SELESAI","<br> Sukses : $sukses		<br>Gagal : $gagal ");	
	}else{
// Transaksi Lainya
	$data = new Spreadsheet_Excel_Reader($_FILES['import_file']['tmp_name']);
	$baris = $data->rowcount($sheet_index=0);
	$sukses = 0;
	$gagal = 0;
		for ($i=2; $i<=$baris; $i++)
		{ 
				$n1 = trimed($data->val($i, 1));
				$n2 = trimed($data->val($i, 2));
				$n3 = trimed($data->val($i, 3));
if(!empty($n1)){
	$transID=GenerateID('transaksi','TransID',$n1,'BAU');
	$cekTransaksi=_query("SELECT * FROM jenistransaksi WHERE id='$trans'");
	if (_num_rows($cekTransaksi)>0)
		{
			$row			=_fetch_array($cekTransaksi);
			$NamaTransaksi	=$row['nama'];
			$d				=$row['BukuDebet'];
			$k				=$row['BukuKredit'];
			$deb			= explode(',',$d);
			$kredt			= explode(',',$k);
			if (!empty($d))
			{
				foreach($deb as $vald => $debet)
				{
				$transd = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat) VALUES 
				('$transID', '$debet', '$trans', '$n3', '0', '', '$n1', '$_SESSION[Nama]', '$tgl_sekarang', '$n2', '$waktu')";
				$hasil=_query($transd);	

				}
			}
			if (!empty($k))
			{
				foreach($kredt as $vald => $kredit)
				{
				$transk = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat) VALUES 
				('$transID', '$kredit', '$trans', '0', '$n3', '', '$n1', '$_SESSION[Nama]', '$n1', '$n2', '$waktu')";
				$hasil=_query($transk);
				
				}
			}
		}
}
if ($hasil) $sukses++; else $gagal++;
	}
InfoMsgs("IMPORT DATA TRANSAKSI $NamaTransaksi SELESAI","<br> Sukses : $sukses		<br>Gagal : $gagal ");	
	}
}

switch($id ){

default:
Defabauimport();
break;

case "import":
import($trans);
break;

}     
        
?>
