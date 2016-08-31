<?php  
function NoReg($id){
$w = GetFields('tahun', 'Tahun_ID', $id, '*');
$tgle=substr("$w[TglBuka]",8,2);
$blne=substr("$w[TglBuka]",5,2);
$thne=substr("$w[TglBuka]",0,4);
$tglNIM=$thne.$blne.$tgle;
// cari id registrasi terakhir yang berawalan tanggal hari ini
$query = "SELECT max(NoReg) AS last FROM mahasiswa WHERE NoReg LIKE 'REG$tglNIM%'";
$hasil = _query($query);
$data  = _fetch_array($hasil);
$lastNoTransaksi = $data['last'];
$lastNoUrut = substr($lastNoTransaksi, 11, 4); 
$nextNoUrut = $lastNoUrut + 1;
$nextNoTransaksi = "REG".$tglNIM.sprintf('%04s', $nextNoUrut);
return $nextNoTransaksi;
}
function Defakademikimport(){
buka("BAAK :: Import Data Mahasiswa");
echo "<legend><div class='row-fluid'>
<div class='span5'>
<form method=post enctype='multipart/form-data' action='go-akademikimportMhsw.html'>
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
	<a class='btn btn-danger' href='go-akademikmahasiswa.html'><i class='icon-undo'></i> Kembali</a>

</div>
</div>
</div></legend>";
if(isset( $_POST['Import'])){
import();
}else{
echo"<div class='alert'>
			<button class='close' data-dismiss='alert'>&times;</button>
			<strong>Perhatian !! Tools ini Khusus Untuk Meng-Import Data Mahasiswa</strong> <br>Perhatikan Format Excel yang Sudah di sediakan. Atau <a href='down-fileContoh-mahasiswa.html'>Download disini</a> Untuk contoh format Excel.
		</div>";
}
tutup();
}

function import(){
global $tgl_sekarang;
include "../librari/excel_reader.php";
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
				$n7 = trimed($data->val($i, 7));
				$n8 = trimed($data->val($i, 8));
				$n9 = trimed($data->val($i, 9));
				$n10 = trimed($data->val($i, 10));
				$n11 = trimed($data->val($i, 11));
				$n12 = trimed($data->val($i, 12));
				$n13 = trimed($data->val($i, 13));
				$n14 = trimed($data->val($i, 14));
				$n15 = trimed($data->val($i, 15));
				$n16 = trimed($data->val($i, 16));
				$n17 = trimed($data->val($i, 17));
				$n18 = trimed($data->val($i, 18));
				$n19 = trimed($data->val($i, 19));
				$n20 = trimed($data->val($i, 20));
				$n21 = trimed($data->val($i, 21));
				$n22 = trimed($data->val($i, 22));
				$n23 = trimed($data->val($i, 23));
				$n24 = trimed($data->val($i, 24));
				$n25 = trimed($data->val($i, 25));
				$n26 = trimed($data->val($i, 26));
				$n27 = trimed($data->val($i, 27));
				$n28 = trimed($data->val($i, 28));
				$n29 = trimed($data->val($i, 29));
				$n30 = trimed($data->val($i, 30));
				$aktif	= (empty($n1))? 'N' : 'Y';
				$jenjang = GetaField('jurusan', 'kode_jurusan', $n8, 'jenjang');
				  // cek data, lalu sisipkan ke dalam tabel
				$cek=_query("SELECT * FROM mahasiswa WHERE NIM='$n1'");
				$cekdata = _num_rows($cek);
				if($cekdata > 0) {
				while ($n=_fetch_array($cek)){
					$sqldel= _query("DELETE FROM mahasiswa WHERE NIM='$n[NIM]'");
					}
				}
$cekTahun=_query("SELECT * FROM tahun WHERE Tahun_ID='$n3'");
$hasilCekTahun = _num_rows($cekTahun);
if(empty($hasilCekTahun)) {
ErrorMsg("GAGAL..!! TIDAK ADA TAHUN DENGAN ID : $n3","Silahkan Buat Dulu <a href='action-akademiktahun-editTahun-1.html'>DISINI</a> ");
}else{
				$noReg=NoReg($n3);
				$query = "INSERT INTO mahasiswa (NIM,username,NoReg,level_ID,Identitas_ID 	,Angkatan,Kurikulum_ID,RekananID,Nama,IDProg,kode_jurusan,PenasehatAkademik,Kelamin,WargaNegara,TempatLahir,TanggalLahir,Agama,Alamat,Kota,RT,RW,KodePos,Propinsi,Negara,Telepon,Handphone,Email,aktif,LulusUjian,NilaiUjian,GradeNilai,TanggalLulus,IPK,TotalSKS) VALUES ('$n1', '$n1', '$noReg','4','$n2','$n3','$n4','$n5','$n6','$n7','$n8','$n9','$n10','$n11','$n12','$n13','$n14','$n15','$n16','$n17','$n18','$n19','$n20','$n21','$n22','$n23','$n24','$aktif','$n25','$n26','$n27','$n28','$n29','$n30')";
				$hasil =_query($query);
if ($hasil){
				$pass=md5(123456);
				$UserYapan ="INSERT INTO useryapan(username,password,LevelID,Nama,IdentitasID,kodeProdi,Bagian,Jabatan,email,aktif,SessionID)VALUES
					('$n1','$pass','4','$n6','$n2','$n8','mahasiswa','19','$n24','$aktif','$n2')";
				$InsertUserYapan=_query($UserYapan);
				if($n25=='N'){
				$cekkeu=_query("SELECT * FROM keuanganmhsw WHERE KeuanganMhswID='$n1'");
				$cekdatakeu = _num_rows($cekkeu);
				if($cekdatakeu > 0) {
				while ($n=_fetch_array($cekkeu)){
					$sqldelkeuangan= _query("DELETE FROM keuanganmhsw WHERE KeuanganMhswID='$n[KeuanganMhswID]'");
					}
				}
				$s ="INSERT INTO keuanganmhsw (KeuanganMhswID,RegID,IdentitasID,ProdiID,TahunID,JenjangID,Aktif,SubmitOleh,TglSubmit,Keterangan)
					values('$n1','$noReg','$n2','$n8','$n3','$jenjang','$aktif','$_SESSION[Nama]','$tgl_sekarang','Diimport Oleh BAAK')";
				$go = _query($s);
				}
}
if ($hasil) $sukses++; else $gagal++;
}
			}
InfoMsgs("IMPORT DATA MAHASISWA SELESAI","<br> Sukses : $sukses		<br>Gagal : $gagal ");	
}
switch($_GET[PHPIdSession]){
default:
Defakademikimport();
break;
}     
        
?>
