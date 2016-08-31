<?php
defined('_FINDEX_') or die('Access Denied');
//Input Prsensi Kuliah 
if(isset($_POST['simpanKuliah'])) 
{
	$Tglp           =sprintf("%02d%02d%02d",$_POST['ThnPresensi'],$_POST['BlnPresensi'],$_POST['TglPresensi']);
	$presensi		= $_POST['presensi'];
	$mahasiswa		= $_POST['mahasiswa'];
	$Keterangan	   	= sqling($_POST['keterangan']);
	$dosen			=($_POST['dosen']=='lain')? $_POST['dosenPengganti']: $_POST['dosen'];
if ($presensi=='') {
alert('error','Presensi Gagal di proses.Anda Belum Memilih Prsensi dosen. Silahkan Ulangi Lagi');
}else{
$pre=_query("INSERT INTO presensi (JenisPresensi, TahunID, semester, JadwalID,mtkID, Pertemuan, MhswHadir, DosenID, Tanggal,JamMulai,JamSelesai,Catatan) VALUES 
	('$_POST[JenisPresensi]', '$_POST[TahunID]', '$_POST[semester]','$_POST[JadwalID]', '$_POST[mtkID]', '$presensi', '$mahasiswa', '$dosen', '$Tglp', '$_POST[mulai]', '$_POST[selesai]', '$Keterangan')");	
alert('info','Presensi Dosen Berhasil Di Simpan');
CatatLog($_SESSION[Nama],'Proses Presensi Dosen','Presensi Dosen Berhasil Di Simpan');	
htmlRedirect('go-monitoring.html',2);
	}
}

if(isset($_POST['simpanUjian'])) 
{
	$Tglp           =sprintf("%02d%02d%02d",$_POST['ThnPresensi'],$_POST['BlnPresensi'],$_POST['TglPresensi']);
	$presensi		= $_POST['presensi'];
	$mahasiswa		= $_POST['mahasiswa'];
	$Keterangan	   	= sqling($_POST['keterangan']);
	$dosen			=($_POST['dosen']=='lain')? $_POST['dosenPengganti']: $_POST['dosen'];
if  ($presensi==''){
alert('error','Presensi Gagal di proses.Anda Belum Memilih Prsensi dosen. Silahkan Ulangi Lagi');
}else{
$pre=_query("INSERT INTO presensi (JenisPresensi, TahunID,semester, JadwalID, mtkID, Pertemuan, MhswHadir, DosenID, Tanggal,JamMulai,JamSelesai,Catatan) VALUES 
	('$_POST[JenisPresensi]', '$_POST[TahunID]', '$_POST[semester]','$_POST[JadwalID]','$_POST[mtkID]', '$presensi', '$mahasiswa', '$dosen', '$Tglp', '$_POST[mulai]', '$_POST[selesai]', '$Keterangan')");
alert('info','Presensi Berhasil Di Simpan');
CatatLog($_SESSION[Nama],'Proses Presensi Dosen','Presensi Dosen Berhasil Di Simpan');	
htmlRedirect('aksi-monitoring-ujian.html',2);
	}	
}