<?php
function defaultjurusan(){
buka("Master Program Studi");
echo"<div class='row'><p class='pull-right'><a class='btn btn-success' href='aksi-masterjurusan-tambahjurusan.html'>Tambah PRODI</a></p> </div> 
	<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'><thead>
	<tr><th>No</th><th>Institusi</th><th>Kode Prodi</th><th>Program Studi</th><th>Jenjang</th><th>Status</th><th></th></tr></thead><tbody>"; 
	$sql="SELECT t1.*,t2.Nama_Identitas AS NI FROM jurusan t1,identitas t2 WHERE t1.Identitas_ID=t2.Identitas_ID ORDER BY t1.jurusan_ID";
	$qry= _query($sql) or die ();
	while ($data=_fetch_array($qry)){ 
	$sttus = ($data['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$no++;
	echo "<tr>                    
		<td width=10>$no</td>
		<td>$data[NI]</td>
		<td>$data[kode_jurusan]</td>
		<td>$data[nama_jurusan]</td>
		<td>$data[jenjang]</td>
		<td>$sttus</td>
		<td width='10%'> 
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini btn-inverse' href='get-masterjurusan-editjurusan-$data[jurusan_ID].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='get-masterjurusan-exprodi-$data[jurusan_ID].html' onClick=\"return confirm('Anda yakin akan Menghapus Prodi $data[nama_jurusan] ?')\">Hapus</a>
			</div>
		</center>
		</td> 
	</tr>";        
	}
echo "</tbody></table>";
tutup();
}

function tambahjurusan(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("Tambah Program Studi");
	echo"<form method='post' action='aksi-masterjurusan-addprodins.html'>
		<table class='table table-bordered table-striped'><thead> 
		<tr><td align=right class=cc>Institusi</td> <td><div class='row-fluid'><select name=cmbIns1 class='span12'><option value=0>-- Pilih Institusi --</option>";
		$s = "SELECT * FROM identitas ORDER BY Identitas_ID";
		$g = _query($s) or die ();
		while($r = _fetch_array($g)){
		echo "<option value='$r[Identitas_ID]'>$r[Nama_Identitas]</option>";
		}
		echo "</select></div></td></tr>
		<tr><td align=right class=cc>Kode / Nama Program Studi</td>           <td><input type=text name=kode_jurusan size=10> - <input type=text name=nama_jurusan size=30></td></tr>
		<tr><td align=right class=cc>Jenjang</td>    <td><select name=jenjang><option value=0 selected></option>";
		$sql=_query("SELECT * FROM jenjang ORDER BY Jenjang_ID");
		while($data=_fetch_array($sql)){
		echo "<option value=$data[Nama]>$data[Nama]</option>";
			}
		echo "</select></td></tr>
		<tr><td align=right class=cc>Aktif</td>    <td><input type=radio name=Aktif value=Y> Y 
			<input type=radio name=Aktif value=N> N </td></tr>
		<tr><td colspan=2><h3>Surat Keputusan</h3></td></tr>
		<tr><td align=right class=cc>No SK Dikti</td>    <td><input type=text name=NoSKDikti size=30></td></tr>
		<tr><td align=right class=cc>Tanggal SK Dikti</td><td><div class='row-fluid'>";
		combotgl(1,31,'tgl_SKDikti',$today);
		combonamabln(1,12,'bln_SKDikti',$BulanIni);
		combothn($TahunIni-100,$TahunIni+10,'thn_SKDikti',$TahunIni);
		echo "</div></td></tr>
			<tr><td align=right class=cc>No SK BAN</td>    <td><input type=text name=NoSKBAN></td></tr>
			<tr><td align=right class=cc>Tanggal SK BAN</td><td><div class='row-fluid'>"; 
		combotgl(1,31,'tgl_SKBAN',$today);
		combonamabln(1,12,'bln_SKBAN',$BulanIni);
		combothn($TahunIni-100,$TahunIni+10,'thn_SKBAN',$TahunIni);
		echo "</div></td></tr>
			<tr><td align=right class=cc>Akreditasi</td>    <td><select name=Akreditasi><option value=0 selected></option>";
				$sql=_query("SELECT * FROM statusakreditasi ORDER BY statusakreditasi_ID");
				while($data=_fetch_array($sql)){
				echo "<option value=$data[statusakreditasi_ID]>$data[statusakreditasi_ID] - $data[nama]</option>";
				}
		echo "</select></td></tr>
			<tr><td colspan=2>
			<center>
				<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Simpan>
				<input class='btn' type=reset value=Reset>
				<a class='btn btn-small btn-danger' href='go-masterjurusan.html'>Batal</a>
				</div>
			</center>
			</td></tr>
		</thead></table></form>";
tutup();
}
function editjurusan($pesan){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("Edit Program Studi");
$edit = _query("SELECT * FROM jurusan WHERE jurusan_ID='$_GET[id]'");
$r    = _fetch_array($edit);
echo"$pesan
    <form action='aksi-masterjurusan-updpodins.html' method='post'>
	<table class='table table-bordered table-striped'><thead> 
    <input type=hidden name='jurusan_ID' size=10 value='$r[jurusan_ID]'>
    <tr><td align=right>Institusi</td>  <td> <div class='row-fluid'><select name='cmbIns1'id=cmbIns1 class='span12'>";
        $tampil=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
        while($w=_fetch_array($tampil)){
        if ($r[Identitas_ID]==$w[Identitas_ID]){
        echo "<option value=$w[Identitas_ID] selected>$w[Nama_Identitas]</option>";
        }else{echo "<option value=$w[Identitas_ID]>$w[Nama_Identitas]</option>";}}
    echo "</select></div></td></tr>              
    
    <tr><td align=right>Kode/ Nama Program Studi</td>           <td><input type=text name='kode_jurusan' size=10 value='$r[kode_jurusan]'> - <input type=text name='nama_jurusan' size=30 value='$r[nama_jurusan]'></td></tr>

    <tr><td align=right>Jenjang</td>  <td> <select name='jenjang'>";
        $tampil=_query("SELECT * FROM jenjang ORDER BY Jenjang_ID");
        while($w=_fetch_array($tampil)){
        if ($r[jenjang]==$w[Nama]){
        echo "<option value=$w[Nama] selected>$w[Nama]</option>";
        }else{echo "<option value=$w[Nama]>$w[Nama]</option>";}}
    echo "</select></td></tr>";
        if ($r[Aktif]=='Y'){
        echo "<tr><td align=right>Aktif</td> <td>  <input type=radio name='Aktif' value='Y' checked>Y  
        <input type=radio name='Aktif' value='N'> N</td></tr>";
        }else{echo "<tr><td>Aktif</td> <td>  <input type=radio name='Aktif' value='Y'>Y  
        <input type=radio name='Aktif' value='N' checked>N</td></tr>";}
    echo"
    <tr><td colspan=2><h3>Surat Keputusan</h3></td></tr>
    <tr><td align=right>No SK Dikti</td>    <td><input type=text name='NoSKDikti' size=30 value='$r[NoSKDikti]'></td></tr>
    <tr><td align=right>Tanggal SK Dikti</td><td><div class='row-fluid'>"; 
		$get_tgl2=substr("$r[TglSKDikti]",8,2);
		combotgl(1,31,'tgl_SKDikti',$get_tgl2);
        $get_bln2=substr("$r[TglSKDikti]",5,2);
        combonamabln(1,12,'bln_SKDikti',$get_bln2);
        $get_thn2=substr("$r[TglSKDikti]",0,4);
        combothn($TahunIni-100,$TahunIni+5,'thn_SKDikti',$get_thn2);
    echo "</div></td></tr>
    <tr><td align=right>No SK BAN</td>    <td><input type=text name='NoSKBAN' value='$r[NoSKBAN]'></td></tr>
    <tr><td align=right>Tanggal SK BAN</td><td><div class='row-fluid'>"; 
		$get_tgl2=substr("$r[TglSKBAN]",8,2);
		combotgl(1,31,'tgl_SKBAN',$get_tgl2);
        $get_bln2=substr("$r[TglSKBAN]",5,2);
        combonamabln(1,12,'bln_SKBAN',$get_bln2);
        $get_thn2=substr("$r[TglSKBAN]",0,4);
        combothn($TahunIni-100,$TahunIni+5,'thn_SKBAN',$get_thn2);
    echo "</div></td></tr>
    <tr><td align=right>Akreditasi</td>  <td> <select name='Akreditasi'>";
        $tampil=_query("SELECT * FROM statusakreditasi ORDER BY statusakreditasi_ID");
        while($w=_fetch_array($tampil)){
        if ($r[Akreditasi]==$w[statusakreditasi_ID]){
        echo "<option value=$w[statusakreditasi_ID] selected>$w[nama]</option>";
        }else{echo "<option value=$w[statusakreditasi_ID]>$w[nama]</option>";}}
    echo "</select></td></tr>
    <tr><td colspan=2>
	<center>
		<div class='btn-group'>
		<input class='btn btn-success' type=submit value=Update>
		<a class='btn btn-small btn-danger' href='go-masterjurusan.html'>Batal</a>
		</div>
	</center>
	</td></tr></thead></table></form>";     	
}
switch($_GET[PHPIdSession]){

  default:
    defaultjurusan();
  break;  

  case "tambahjurusan":
    tambahjurusan();
  break;
  
  case "editjurusan":
    editjurusan();
  break;
  
  case "addprodins":
        $Identitas_ID     = $_POST['cmbIns1'];
        $kode_jurusan     = $_POST['kode_jurusan'];
        $nama_jurusan     = $_POST['nama_jurusan'];         
        $jenjang        = $_POST['jenjang'];
        $Akreditasi        = $_POST['Akreditasi'];
        $NoSKDikti        = $_POST['NoSKDikti'];
        $TglSKDikti=sprintf("%02d%02d%02d",$_POST[thn_SKDikti],$_POST[bln_SKDikti],$_POST[tgl_SKDikti]);
        $NoSKBAN        = $_POST['NoSKBAN'];
        $TglSKBAN=sprintf("%02d%02d%02d",$_POST[thn_SKBAN],$_POST[bln_SKBAN],$_POST[tgl_SKBAN]);        
        $Aktif        = $_POST['Aktif'];

        $cek=_num_rows(_query("SELECT * FROM jurusan WHERE Identitas_ID='$Identitas_ID' AND kode_jurusan='$kode_jurusan'"));
        if ($cek > 0){
		ErrorMsgs("Opss..! ","Data Sudah Ada dalam database");
        tambahjurusan();
        }else{        
        	_query("INSERT INTO jurusan(Identitas_ID,kode_jurusan,nama_jurusan,jenjang,Akreditasi,
                                      NoSKDikti,
                                      TglSKDikti,
                                      NoSKBAN,
                                      TglSKBAN,
                                      Aktif)VALUES ('$Identitas_ID',
                                      '$kode_jurusan',
                                      '$nama_jurusan',
                                      '$jenjang',
                                      '$Akreditasi',
                                      '$NoSKDikti',
                                      '$TglSKDikti',
                                      '$NoSKBAN',
                                      '$TglSKBAN',
                                      '$Aktif')");
		SuksesMsgs("Program Studi Berhasi Di simpan ","");							  
	    defaultjurusan();
          }  

  break;

  case "updpodins":
        $TglSKDikti=sprintf("%02d%02d%02d",$_POST[thn_SKDikti],$_POST[bln_SKDikti],$_POST[tgl_SKDikti]);
        $TglSKBAN=sprintf("%02d%02d%02d",$_POST[thn_SKBAN],$_POST[bln_SKBAN],$_POST[tgl_SKBAN]);               
        $update=_query("UPDATE jurusan SET Identitas_ID ='$_POST[cmbIns1]',
                                      kode_jurusan      ='$_POST[kode_jurusan]',
                                      nama_jurusan      ='$_POST[nama_jurusan]',
                                      jenjang           ='$_POST[jenjang]',
                                      Akreditasi        ='$_POST[Akreditasi]',
                                      NoSKDikti         ='$_POST[NoSKDikti]',
                                      TglSKDikti        ='$TglSKDikti',
                                      NoSKBAN           ='$_POST[NoSKBAN]',
                                      TglSKBAN          ='$TglSKBAN',
                                      Aktif             ='$_POST[Aktif]'
                                  WHERE jurusan_ID     ='$_POST[jurusan_ID]'");
          $data=_fetch_array($update);
	SuksesMsgs("Data Prodi Berhasil Di Update ","");
    defaultjurusan();
  break;

  case "exprodi":
       $sql="DELETE FROM jurusan WHERE jurusan_ID='$_GET[id]'";
       $qry=_query($sql) or die();
    defaultjurusan();
}
?>
