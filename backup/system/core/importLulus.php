<?php  
function Defabauimport(){
buka("BAAK :: Import Data Kelulusan");
echo "<legend><div class='row-fluid'>
<div class='span5'>
<form method=post enctype='multipart/form-data' action='go-importLulus.html'>
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
	<a class='btn btn-danger' href='go-dasboard.html'><i class='icon-undo'></i> Batal</a>

</div>
</div>
</div></legend>";
if(isset( $_POST['Import'])){
import();
}else{
echo"<div class='alert'>
			<button class='close' data-dismiss='alert'>&times;</button>
			<strong>Perhatian !! Tools ini Khusus Untuk Meng-Import Data Kelulusan</strong> <br>Perhatikan Format Excel yang Sudah di sediakan. Atau <a href='down-fileContoh-lulus.html'>Download disini</a> Untuk contoh format Excel
		</div>";
}
tutup();

}
function import(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
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

				// cek data, lalu sisipkan ke dalam tabel
				$cek=_query("SELECT * FROM mahasiswa WHERE NIM='$n1'");
				$cekdata = _num_rows($cek);
				if(empty($cekdata)) {
				ErrorMsg("IMPORT DATA KELULUSAN GAGAL","<br> Tidak Ditemukan Mahasiswa Dengan NIM : $n1 ");
				}else{
				$thnLulus=substr($n2,0,4);
				$ipk=GetIpk($n1);
				$TotalSKS=GetTotalSKS($n1);
				$hasil=_query("UPDATE mahasiswa SET
				TahunLulus		= '$thnLulus',
				LulusUjian		= 'Y',
				NilaiUjian		= '$n4',
				GradeNilai		= '$n5',
				TanggalLulus	= '$n2',
				IPK				= '$ipk',
				TotalSKS		= '$TotalSKS',
				skl				= '$n3'
				WHERE NIM	= '$n1'");
				}
		if ($hasil) $sukses++; else $gagal++;
	}
	InfoMsgs("IMPORT DATA KELULUSAN SELESAI","<br> Sukses : $sukses		<br>Gagal : $gagal ");	
}

switch($_GET[PHPIdSession]){
default:
Defabauimport();
break;
}     
        
?>
