<?phpdefined('_FINDEX_') or die('Access Denied');//simpan NIlaiif (isset($_POST['nilai'])){	$sqls="SELECT * FROM nilai WHERE Nilai_ID='$_POST[nilai]'";	$query=_query($sqls) or die();	$w=_fetch_array($query);	$masukkanNilai=_query("UPDATE krs SET GradeNilai='$w[grade]',BobotNilai='$w[bobot]' WHERE KRS_ID= '$_POST[idKrs]'");	alert('info','Nilai Mahasiswa Berhasil Disimpan ..!');	CatatLog($_SESSION[Nama],'Input Nilai','Nilai Mahasiswa Berhasil Disimpan ..!');}// IMPOR NILAIif(isset($_POST['ImportNilai'])){$identitas=$_SESSION['Identitas'];include "librari/excel_reader.php";	$data = new Spreadsheet_Excel_Reader($_FILES['import_file']['tmp_name']);	$baris = $data->rowcount($sheet_index=0);	$sukses = 0;	$gagal = 0;		for ($i=2; $i<=$baris; $i++)			{				$n1 = trimed($data->val($i, 1));				$n2 = trimed($data->val($i, 2));				$n3 = trimed($data->val($i, 3));				$n4 = trimed($data->val($i, 4));				$n5 = trimed($data->val($i, 5));			// cek data, lalu sisipkan ke dalam tabel				$cek=_query("SELECT * FROM krs WHERE NIM='$n1' AND Tahun_ID='$n2' AND Jadwal_ID='$n3' AND semester='$n4'");				$cekdata = _num_rows($cek);				if($cekdata > 0) {					while ($n=_fetch_array($cek)){					$sqldel= _query("DELETE FROM krs WHERE KRS_ID='$n[KRS_ID]'");						}				}				$mtk = GetFields('matakuliah', 'Matakuliah_ID', $n3, '*');				$mhs = GetFields('mahasiswa', 'NIM', $n1, '*');				$nilai = GetFields('nilai', 'grade', $n5, '*');				$hasil =_query("INSERT INTO krs (NIM,Tahun_ID,Jadwal_ID,SKS,semester,kelas,GradeNilai,BobotNilai) VALUES ('$n1', '$n2', '$n3','$mtk[SKS]','$n4','$mhs[IDProg]','$n5','$nilai[bobot]')");			if ($hasil) $sukses++; else $gagal++;			alert("info","Import Data Nilai Selesai Sukses : $sukses | Gagal : $gagal ");			CatatLog($_SESSION[Nama],"Import Data Nilai","Import Data Nilai Selesai | Sukses : $sukses | Gagal : $gagal "); 	}}