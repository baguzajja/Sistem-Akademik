<?phpdefined('_FINDEX_') or die('Access Denied');// Proses Simpan Bukuif(isset($_POST['simpanBuk'])){	$md		= $_POST['md']+0;	$id		= $_POST['id'];	$Nama	= sqling($_POST['namaBuku']);if ($md == 0) {		$update = _query("UPDATE  buku SET nama='$Nama' WHERE id='$id' ");		alert('info','Master Buku Berhasil Di Update');		CatatLog($_SESSION[Nama],'Update Master Buku','Data Master Buku Berhasil Di Update');		htmlRedirect('go-masterkeuangan.html',2);  } else {    $ada = GetFields('buku', 'id', $id, '*');    if (empty($ada)) {		$insert = _query("INSERT INTO buku (nama) values('$Nama')");		alert('info','Data Master Buku Berhasil Di Simpan');		CatatLog($_SESSION[Nama],'Tambah Master Buku','Data Master Buku Berhasil Di Simpan');		htmlRedirect('go-masterkeuangan.html',2);    } else{		alert('error','Gagal Menambah Master Buku. Data Master Buku Sudah ada dalama database');		CatatLog($_SESSION[Nama],'Tambah Master Buku','Gagal Menambah Master Buku. Data Master Buku Sudah ada dalama database');		htmlRedirect('go-masterkeuangan.html',2);	}}}// Hapus Bukuif(isset($_POST['deleteBuku'])){$source = @$_POST['checkBuk'];$source = multipleSelect($source);	if(empty($source)){	alert('error','Pilih Data yang Akan di hapus');	CatatLog($_SESSION[Nama],'Hapus Buku','Gagal. Data Belum Dipilih');	htmlRedirect('go-masterkeuangan.html',2);	}else{	$reg = explode(",",$source);	foreach($reg as $id)	{		$tabel	="buku";		$kondisi="id='$id'";		$delete = delete($tabel,$kondisi);	 	}		alert('info','Master Buku Berhasil Di Hapus');		CatatLog($_SESSION[Nama],'Hapus Data Buku','Data Buku Berhasil Di Hapus');		htmlRedirect('go-masterkeuangan.html',2);	}}//Simpan Master Transaksiif(isset($_POST['simpanTrans'])){	$md			= $_POST['md']+0;	$id 		= $_POST['id'];	$Nama		= sqling($_POST['namaTransaksi']);	$Jenis		= sqling($_POST['jenis']);if (!empty($_POST[BukuDebet])){	$deb = $_POST[BukuDebet];	$debet=implode(',',$deb);}if (!empty($_POST[BukuKredit])){	$kred = $_POST[BukuKredit];	$kredit=implode(',',$kred);}    if ($md == 0) {    $update = _query( "UPDATE  jenistransaksi SET BukuDebet='$debet',BukuKredit='$kredit',Nama='$Nama',Jenis='$Jenis' WHERE id='$id' ");	alert('info','Master Transaksi Berhasil Di Update');	CatatLog($_SESSION[Nama],'Update Master Transaksi','Data Master Transaksi Berhasil Di Update');	htmlRedirect('aksi-masterkeuangan-trans.html',2);  } else {    $ada = GetFields('jenistransaksi', 'id', $id, '*');    if (empty($ada)) {      $insert = _query("INSERT INTO jenistransaksi (BukuDebet,BukuKredit,Nama,Jenis) values	  ('$debet','$kredit','$Nama','$Jenis')");		alert('info','Data Master Transaksi Berhasil Di Simpan');		CatatLog($_SESSION[Nama],'Tambah Master Transaksi','Data Master Transaksi Berhasil Di Simpan');		htmlRedirect('aksi-masterkeuangan-trans.html',2);    } else {		alert('error','Gagal Menambah Master Transaksi. Data Master Transaksi Sudah ada dalama database');		CatatLog($_SESSION[Nama],'Tambah Master Transaksi','Gagal Menambah Master Transaksi. Data Master Transaksi Sudah ada dalama database');		htmlRedirect('aksi-masterkeuangan-trans.html',2);	}  }}// Hapus Master Transaksiif(isset($_POST['deleteTrans'])){$source = @$_POST['checkTrans'];$source = multipleSelect($source);	if(empty($source)){	alert('error','Pilih Data yang Akan di hapus');	CatatLog($_SESSION[Nama],'Hapus Master Transaksi','Gagal. Data Belum Dipilih');	htmlRedirect('aksi-masterkeuangan-trans.html',2);	}else{	$reg = explode(",",$source);	foreach($reg as $id)	{		$tabel	="jenistransaksi";		$kondisi="id='$id'";		$delete = delete($tabel,$kondisi);	 	}		alert('info','Master Transaksi Berhasil Di Hapus');		CatatLog($_SESSION[Nama],'Hapus Master Transaksi','Master Transaksi Berhasil Di Hapus');		htmlRedirect('aksi-masterkeuangan-trans.html',2);	}}