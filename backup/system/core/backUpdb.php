<?php
$files	  =date("d_M_Y_H_i_s").'.sql';
$database = 'stieyapa_sia2013';
$dir = '../backups/';
$tables='admin,agama,beritaawal,biayamhsw,buku,departemen,dosen,dosenpekerjaan,dosenpendidikan,dosenpenelitian,groupmodul,hakmodul,hari,hidup,honordosen,honorrektorat,honorstaff,identitas,inventaris,jabatan,jabatandikti,jadwal,jenise,jeniskurikulum,jenismk,jenissekolah,jenistransaksi,jenis_ujian,jenjang,jurusan,jurusansekolah,kampus,karyawan,kelompokmtk,keuanganmhsw,krs,kurikulum,lapbau,lapbaak,level,mahasiswa,master_nilai,matakuliah,modul,nilai,nilai1,pekerjaanortu,pendidikanortu,perhatian,presensi,program,regmhs,rekanan,rekening,ruang,rumahtangga,statusakreditasi,statusaktivitasdsn,statusawal,statuskerja,statusmhsw,statusmtk,statussipil,tahun,transaksi,transaksibaak,transaksihnrstaff,useryapan';
function defbackUp(){
buka("System :: Backup Database");
echo "<div class='panel-content panel-tables'>";
        
echo"<form method=post enctype='multipart/form-data' action='aksi-backUpdb-Restore.html'>
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>
			<div class='fileupload fileupload-new pull-left' data-provides='fileupload'>
				<div class='input-append input-prepend'>
							<div class='uneditable-input span3'><i class='icon-file fileupload-exists'></i> <span class='fileupload-preview'></span></div><span class='btn btn-file'><span class='fileupload-new'>Pilih file</span><span class='fileupload-exists'>Ganti</span><input type='file' name='backup_file'/></span><a href='#' class='btn fileupload-exists' data-dismiss='fileupload'>Hapus</a>
	<input class='btn btn-inverse' type=submit value='Restore'>			
</div>
			</div>
		
		<div class='pull-right'>
			<a class='btn btn-success' href='aksi-backUpdb-backUp.html'>BACKUP DATABASE </a>
		</div>
		</th>
		</tr>
			<tr><th></th></tr>
		</thead>
	</table></form></div>";

echo"<div class='row-fluid'>
<div class='span8'>
<div class='panel'>
	<div class='panel-header'><i class='icon-bar-chart'></i> DATA BACKUP</div>
		<div class='panel-content panel-tables'>
			<table class='table table-bordered table-striped'>                          
				<tbody>";
$folder = '../backups';
if ($folder = opendir($folder)) {
    $i = 0;
    while (($f = readdir($folder)) !== false) {
        $i++;
        if ($f != '.' && $f != '..' && $f != 'index.php') {
	echo"<tr>
		<td class='description'>". $f ."</td>
		<td class='value'><center><div class='btn-group'><a class='btn btn-mini' href='down-Database-" . $f .".html' title='DOWNLOAD: ". $f ."'>DOWNLOAD</a><a class='btn btn-mini btn-danger' href='get-backUpdb-HpusBackup-" . $f .".html' onClick=\"return confirm('Anda yakin akan Menghapus Data BackUp $f ?')\" title='Delete: ". $f . "'>HAPUS</a></div></center></td>
	</tr>";
        }
        }
        }

echo"</tbody>
			</table>

		</div>
	</div>
</div>
</div>";
tutup();
}
function restore($files) {
	global $rest_dir;
	
	$nama_file	= $files['name'];
	$ukrn_file	= $files['size'];
	$tmp_file	= $files['tmp_name'];
	
	if ($nama_file == "")
	{
PesanEror("Fatal Error..!!", "Fatal Error.... Mohon Periksa dan ulangi lagi");
	}
	else
	{
		$alamatfile	= $rest_dir.$nama_file;
		$templine	= array();
		
		if (move_uploaded_file($tmp_file , $alamatfile))
		{
			
			$templine	= '';
			$lines		= file($alamatfile);

			foreach ($lines as $line)
			{
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;
			 
				$templine .= $line;

				if (substr(trim($line), -1, 1) == ';')
				{
					mysql_query($templine) or print('Query gagal \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');

					$templine = '';
				}
			}
PesanOk("Restore database telah selesai","Database Berhasil Di Restore","go-backUpdb.html");
		
		}else{
PesanEror("Proses upload GAGAL..!!", "kode error = " . $file['error']);
		}	
	}
	
}

function backup($nama_file,$tables = '')
{
	global $return, $tables, $dir, $database ;
	
	if($tables == '')
	{
		$tables = array();
		$result = @mysql_list_tables($database);
		while($row = @mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}else{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	$return	= '';
	
	foreach($tables as $table)
	{
		$result	 = @mysql_query('SELECT * FROM '.$table);
		$num_fields = @mysql_num_fields($result);
		
		//menyisipkan query drop table untuk nanti hapus table yang lama
		$return	.= "DROP TABLE IF EXISTS ".$table.";";
		$row2	 = @mysql_fetch_row(mysql_query('SHOW CREATE TABLE  '.$table));
		$return	.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = @mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';

				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = @addslashes($row[$j]);
					$row[$j] = @ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	$nama_file;
	
	$handle = fopen($dir.$nama_file,'w+');
	fwrite($handle, $return);
	fclose($handle);
}
switch($_GET[PHPIdSession]){

  default:
    defbackUp();
  break;  
	  
  case "backUp":
backup($files,$tables);

PesanOk3("Backup database telah selesai","BackUp Berhasil dibuat","go-backUpdb.html","down-Database-$files.html");	
  break; 

case "Restore":
   restore($_FILES['backup_file']);
  break;

case "HpusBackup":
	$dir = '../backups/';
	$file = $dir.$_GET['id'];
 unlink($file);
lompat_ke("go-backUpdb.html");
  break;
}
?>
