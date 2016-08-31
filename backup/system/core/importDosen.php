<?php  
function Defakademikimport(){
buka("BAAK :: Import Data Dosen");
echo "<div class='panel-content panel-tables'>
	<form method=post enctype='multipart/form-data' action='aksi-importDosen-import.html'>
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>
					<div class='fileupload fileupload-new pull-left' data-provides='fileupload'>
						<div class='input-append'>
							<div class='uneditable-input span3'><i class='icon-file fileupload-exists'></i> <span class='fileupload-preview'></span></div><span class='btn btn-file'><span class='fileupload-new'>Pilih file</span><span class='fileupload-exists'>Ganti</span><input type='file' name='import_file'/></span><a href='#' class='btn fileupload-exists' data-dismiss='fileupload'>Hapus</a>
						</div>
					</div>
					<div class='pull-right'>
					<input class='btn btn-success' type=submit name='Import' value='IMPORT DATA'>
					</div>
				</th>
			</tr>
			<tr><th></th></tr>
		</thead>
	</table></form></div>";
tutup();
}
function import(){
$identitas=$_SESSION['Identitas'];
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
				  // cek data, lalu sisipkan ke dalam tabel
				$cekdata =_num_rows(_query("SELECT * FROM dosen WHERE NIDN ='$n1'"));
				if($cekdata >0) {
				lompat_ke("aksi-importDosen-salah.html");
				} else {
				$query = "INSERT INTO dosen
(username,NIDN,nama_lengkap,TempatLahir,TanggalLahir,Identitas_ID,Jurusan_ID,Gelar,Aktif,Skpengankatan,Jabatan_ID) VALUES 
('$n1', '$n1', '$n2','$n4','$n5','$identitas','$n7','$n3','$n8','$n6','$n9')";
				$hasil =_query($query);
if ($hasil){
				$UserYapan ="INSERT INTO useryapan(username,LevelID,Nama,IdentitasID,kodeProdi,Bagian,Jabatan,aktif)VALUES
					('$n1','2','$n2','$identitas','$n7','dosen','$n9','$n8')";
				$InsertUserYapan=_query($UserYapan);
}
				}
			}
	if ($hasil) $sukses++; else $gagal++;
	PesanOk("IMPORT DATA DOSEN","Import Data Dosen Selsesai <br> Sukses : $sukses		<br>Gagal : $gagal ","go-masterdosen.html");	
}

switch($_GET[PHPIdSession]){

default:
Defakademikimport();
break;

case "import":
import();
break;

case "salah":
PesanEror("Proses IMPORT GAGAL..!!", "DATA NIDN ADA YANG SAMA");
break;

}     
        
?>
