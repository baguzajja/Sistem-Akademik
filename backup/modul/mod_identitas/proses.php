<?phpdefined('_FINDEX_') or die('Access Denied');//Tambah dan Edit Modulif(isset($_POST['simpanIdentitas'])) {		$md			= $_POST['md']+0;		$TglMulai	=sprintf("%02d%02d%02d",$_POST[thn_mulai],$_POST[bln_mulai],$_POST[tgl_mulai]);        $TglAkta	=sprintf("%02d%02d%02d",$_POST[thn_akta],$_POST[bln_akta],$_POST[tgl_akta]);        $TglSah		=sprintf("%02d%02d%02d",$_POST[thn_sah],$_POST[bln_sah],$_POST[tgl_sah]);if ($md == 0) {	   $update=_query("UPDATE identitas SET 			Identitas_ID	= '$_POST[Kode]',			KodeHukum		= '$_POST[KodeHukum]',			Nama_Identitas	= '$_POST[Nama]',			TglMulai		= '$TglMulai',			Alamat1			= '$_POST[Alamat1]',			Kota			= '$_POST[Kota]',			KodePos			= '$_POST[KodePos]',			Telepon			= '$_POST[Telepon]',			Fax				= '$_POST[Fax]',			Email			= '$_POST[Email]',			Website			= '$_POST[Website]',			NoAkta			= '$_POST[NoAkta]',			TglAkta			= '$TglAkta',			NoSah			= '$_POST[NoSah]',			TglSah			= '$TglSah',			Aktif			= '$_POST[NA]'			WHERE ID		= '$_POST[ID]'");		$data=_fetch_array($update);		if($update){		alert('info','Data Institusi Berhasil Diupdate');		CatatLog($_SESSION['Nama'],'Update Institusi','Data Institusi Berhasil Diupdate');		htmlRedirect('go-identitas.html',2);		}  } else {	$cek=_num_rows(_query ("SELECT * FROM identitas  WHERE Identitas_ID='$_POST[Kode]'"));        if ($cek > 0){			alert("error", "Kode : $_POST[Kode] Sudah ada dalam database");			CatatLog($_SESSION['Nama'],'Tambah Institusi baru',"Gagal menambah Institusi..Data Sudah ada dalam database");			htmlRedirect('go-identitas.html',2);        }else{	$insert =_query("INSERT INTO identitas(Identitas_ID,KodeHukum,Nama_Identitas,TglMulai,Alamat1,Kota,KodePos,Telepon,Fax,Email,Website,NoAkta,TglAkta,NoSah,TglSah,Aktif)VALUES('$_POST[Kode]','$_POST[KodeHukum]','$_POST[Nama]','$TglMulai','$_POST[Alamat1]','$_POST[Kota]','$_POST[KodePos]','$_POST[Telepon]','$_POST[Fax]','$_POST[Email]','$_POST[Website]','$_POST[NoAkta]','$TglAkta','$_POST[NoSah]','$TglSah','$_POST[NA]')");	if($insert){			alert('info','Data Institusi Berhasil Disimpan');			CatatLog($_SESSION['Nama'],'Tambah Institusi','Data Institusi Berhasil Disimpan');			htmlRedirect('go-identitas.html',2);			}           }  }	}// Hapus Identitasif(isset($_POST['delete'])){	$source = @$_POST['check'];	$source = multipleSelect($source);	$delete = multipleDelete('identitas',$source);		if(isset($delete)){		alert('info','Institusi Berhasil di Hapus');		CatatLog($_SESSION['Nama'],'Hapus Institusi','Institusi Berhasil di Hapus');	}else{		alert('error','Pilih Institusi yang Akan di Hapus');		CatatLog($_SESSION[Nama],'Hapus Institusi','Gagal Menghapus Institusi, Pilih Institusi yang Akan di Hapus');	}}