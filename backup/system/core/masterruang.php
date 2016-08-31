<script language="javascript" type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php
function defaultRuang(){
buka("Master Ruangan");
$id= $_REQUEST['codd'];
$idk= $_REQUEST['kode'];
echo "<div class='panel-content panel-tables'>
	<table class='table table-striped'><thead>
	<tr><th>
		<div class='input-prepend input-append pull-left'>
			<span class='add-on'>Program Studi</span>
			<select name='codd' onChange=\"MM_jumpMenu('parent',this,0)\">
			<option value='go-masterruang.html'>- Pilih Jurusan -</option>";
			$sqlp="SELECT * FROM jurusan ORDER BY jurusan_ID";
			$qryp=_query($sqlp) or die();
			while ($d=_fetch_array($qryp)){
			if ($d['kode_jurusan']==$id){ $cek="selected";}else{ $cek="";}
			echo "<option value='in-masterruang-$d[kode_jurusan].html' $cek> $d[nama_jurusan]</option>";
			}
			echo "</select>
			<input name='codd' type='hidden' value='$id'>
			<span class='add-on'>Kampus</span>
			<select name='kampus' onChange=\"MM_jumpMenu('parent',this,0)\">
			<option value='go-masterruang.html'>- Pilih Kampus -</option>";
			$sqlp="SELECT t1.* FROM kampus t1, jurusan t2 WHERE t1.Identitas_ID=t2.Identitas_ID AND t2.kode_jurusan='$id' ORDER BY Kampus_ID";
			$qryp=_query($sqlp) or die();
			while ($d=_fetch_array($qryp)){
			if ($d['Kampus_ID']==$idk){$cek="selected";}else{$cek="";}
			echo "<option value='on-masterruang-$id-$d[Kampus_ID].html' $cek> $d[Nama]</option>";
			}
			echo "</select>
			<input name='kampus' type='hidden' value='$idk'>
		</div>
		<div class='btn-group pull-right'>
			<a class='btn btn-success' href='aksi-masterruang-tambahRuang.html'>Tambah Ruangan</a>
			<a class='btn btn-inverse' href='go-masterruang.html'>Refresh</a>
		</div>
	</th></tr>
	<tr><th></th></tr>
	</thead></table></div>";				  
				    
	echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'><thead>
		<tr><th>No</th><th>Kode</th><th>Nama</th><th>Prodi</th><th>Ruang Kelas ? </th><th>Kapasitas</th><th>Keterangan</th><th>Aktif</th><th></th></tr></thead><tbody>"; 
		$sql="SELECT * FROM ruang WHERE Kode_Jurusan='$id' AND Kampus_ID='$idk' GROUP BY Ruang_ID ORDER BY ID";
		$qry= _query($sql) or die ();
		while ($data=_fetch_array($qry)){
		$sttus = ($data['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
		$kelas = ($data['RuangKuliah'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
		$no++;
	echo"<tr><td>$no</td>
		<td>$data[Ruang_ID]</td>
		<td>$data[Nama]</td>
		<td>$data[Kode_Jurusan]</td>
		<td><center>$kelas</center></td>
		<td>$data[KapasitasUjian] - $data[Kapasitas]</td>
		<td>$data[Keterangan]</td>
		<td><center>$sttus</center></td>
		<td>
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini btn-inverse' href='get-masterruang-editruang-$data[Ruang_ID].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='get-get-masterruang-delRuang-$data[ID].html' onClick=\"return confirm('Anda yakin akan Menghapus $data[Nama] ?')\">Hapus</a>
			</div>
		</center>
		</td></tr>";        
	}
	echo"</tbody></table>";
tutup();   
}

function tambahRuang(){
buka("Tambah Ruangan");
 echo"<form method=post action=aksi-masterruang-inputRuang.html>
	<table class='table table-bordered table-striped'><thead>          
	<tr><td class=cc>Kode Ruang</td>       <td><input type=text name=Ruang_ID></td></tr>                  
	<tr><td class=cc>Nama Ruang</td>       <td><input type=text name=Nama></td></tr>
	<tr><td class=cc>Untuk Prodi</td>       <td>";
	$sql = "SELECT kode_jurusan,nama_jurusan FROM jurusan t1 ORDER BY jurusan_ID";
	$cmbJur = _query($sql) or die ();
	while($data = _fetch_array($cmbJur)){
	echo "<input name=CekJurusan[] type=checkbox value='$data[kode_jurusan]'>  $data[nama_jurusan]<br>";
	}
	echo"</td></tr>
		<tr><td class=cc>Kampus</td>       <td><select name=Kampus_ID>
		<option value=>- Pilih Kampus -</option>";
		$sql = "SELECT t1.*,t2.Nama_Identitas FROM kampus t1, identitas t2 WHERE t1.Identitas_ID=t2.Identitas_ID ORDER BY t1.Kampus_ID";
		$cmbKmp = _query($sql)or die ();
		while($data = _fetch_array($cmbKmp)){
	echo "<option value='$data[Kampus_ID]'>  $data[Nama]</option>";
		}
	echo" </select></td></tr>
		<tr><td class=cc>Lantai</td>       <td><input type=text name=Lantai value=1 size=2></td></tr>
		<tr><td class=cc>Untuk Kuliah</td>  <td ><input type=radio name=RuangKuliah value=Y> Y 
		<input type=radio name=RuangKuliah value=N> N  </td></tr>
		<tr><td class=cc>Kapasitas</td>       <td ><input type=text name=Kapasitas value=0 size=2></td></tr>
		<tr><td class=cc>Kapasitas Ujian</td>       <td><input type=text name=KapasitasUjian value=0 size=2></td></tr>                          
		<tr><td class=cc>Keterangan</td>       <td><textarea name='Keterangan' cols=30 rows=5></textarea></td></tr>
		<tr><td class=cc>Aktif</td>         <td><input type=radio name=Aktif value=Y>Y 
		<input type=radio name=Aktif value=N>N  </td></tr>           
		<tr><td colspan=2 align=center>
			<center>
				<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Simpan>
				<input class='btn' type=reset value=Reset>
				<a class='btn btn-small btn-danger' href='go-masterruang.html'>Batal</a>
				</div>
			</center>
		</td></tr>
                              
	</thead></table></form>";
tutup();
}
function editruang(){
buka("Edit Ruangan");
$e=_query("SELECT * FROM ruang WHERE Ruang_ID='$_GET[id]'");
$d=_fetch_array($e);

echo"<form action='aksi-masterruang-inputRuang.html' method='post'>
    <table class='table table-bordered table-striped'><thead>
	<input type=hidden name=codd value='$d[Ruang_ID]'>              
	<tr><td class=cc>Kode Ruang</td>
	<td><input type=hidden name=Ruang_ID value='$d[Ruang_ID]'><strong> $d[Ruang_ID]</strong></td></tr>                  
	<tr><td class=cc>Nama Ruang</td>       <td><input type=text name=Nama value='$d[Nama]'></td></tr>
	<tr><td class=cc>Untuk Prodi </td>       <td>";
	$sql = "SELECT kode_jurusan,nama_jurusan FROM jurusan ORDER BY jurusan_ID";
	$cmbJur = _query($sql) or die ();
	while($data1 = _fetch_array($cmbJur)){
	$sqlr="SELECT kode_jurusan FROM ruang WHERE Ruang_ID='$_GET[id]' AND kode_jurusan='$data1[kode_jurusan]'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	if ($cocok==1){$cek="checked";}else{$cek="";}     
	echo "<input name=CekJurusan[] type=checkbox value='$data1[kode_jurusan]' $cek>  $data1[nama_jurusan]<br>";
	}
echo"</td></tr>
	<tr><td class=cc>Kampus</td><td><select name=Kampus_ID>";
	$tampil=_query("SELECT Kampus_ID,Nama FROM kampus ORDER BY Kampus_ID");
	while($w=_fetch_array($tampil)){
	if ($d[Kampus_ID]==$w[Kampus_ID]){
	echo "<option value=$w[Kampus_ID] selected> $w[Nama]</option>";
	}else{
	echo "<option value=$w[Kampus_ID]> $w[Nama]</option>";
	}
	}
echo "</select></td></tr>
	<tr><td class=cc>Lantai</td>       <td><input type=text name=Lantai  size=2 value='$d[Lantai]'></td></tr>";
	if ($d[RuangKuliah]=='Y'){
	echo "<tr><td class=cc>Untuk Kuliah</td>    <td><input type=radio name=RuangKuliah value=Y checked>Y
	<input type=radio name=RuangKuliah value=N>N</td></tr>";
	}else{
	echo "<tr><td class=cc>Aktif</td>    <td><input type=radio name=RuangKuliah value=Y>Y
	<input type=radio name=RuangKuliah value=N checked>N</td></tr>";
	}
    echo"<tr><td class=cc>Kapasitas</td>       <td><input type=text name=Kapasitas size=2 value='$d[Kapasitas]'></td></tr>
	<tr><td class=cc>Kapasitas Ujian</td>       <td><input type=text name=KapasitasUjian size=2 value='$d[KapasitasUjian]'></td></tr>
	<tr><td class=cc>Keterangan</td>       <td><textarea name='Keterangan' cols=30 rows=5>$d[Keterangan]</textarea></td></tr>";
	if ($d[Aktif]=='Y'){
		echo "<tr><td class=cc>Aktif</td>    <td><input type=radio name=Aktif value=Y checked>Y
					<input type=radio name=Aktif value=N>N</td></tr>";
		}else{
		echo "<tr><td class=cc>Aktif</td>    <td><input type=radio name=Aktif value=Y>Y
				<input type=radio name=Aktif value=N checked>N</td></tr>";
		}
      echo"<tr><td colspan=2>
			<center>
				<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Simpan>
				<input class='btn' type=reset value=Reset>
				<a class='btn btn-small btn-danger' href='go-masterruang.html'>Batal</a>
				</div>
			</center>
		</td></tr>
	</thead></table></form>";
}
switch($_GET[PHPIdSession]){

  default:
    defaultRuang();
  break;  

  case "tambahRuang":
    tambahRuang();		  
  break;

  case"inputRuang":
        $Ruang_ID =$_REQUEST['Ruang_ID'];
        $CekJurusan =$_REQUEST['CekJurusan'];

        $jum=count($CekJurusan);        
        $Ruang_ID     = $_POST['Ruang_ID'];
        $Nama     = $_POST['Nama'];
        $Kampus_ID     = $_POST['Kampus_ID'];
        $Lantai     = $_POST['Lantai'];
        $RuangKuliah     = $_POST['RuangKuliah'];
        $Kapasitas     = $_POST['Kapasitas'];
        $KapasitasUjian    = $_POST['KapasitasUjian'];
        $Keterangan     = $_POST['Keterangan'];
        $Aktif     = $_POST['Aktif'];

          $sqlpil= "SELECT * FROM ruang WHERE Ruang_ID='$Ruang_ID'";
          $qrypil= _query($sqlpil);
          while ($datapil=_fetch_array($qrypil)){
          for($i=0; $i < $jum; ++$i){
          if ($datapil['kode_jurusan'] !=$CekJurusan[$i]){
          $sqldel= "DELETE FROM ruang WHERE Ruang_ID='$Ruang_ID' AND NOT kode_jurusan IN ('$CekJurusan[$i]')";   
          _query($sqldel);

          }
          }
          }        
        for($i=0; $i < $jum; ++$i){
          $sqlr="SELECT * FROM ruang WHERE Ruang_ID='$Ruang_ID'AND kode_jurusan='$CekJurusan[$i]'";
        	$qryr= _query($sqlr);
        	$cocok= _num_rows($qryr);
    
       	
        	
        	if (! $cocok==1){        
        	$sql = "INSERT INTO ruang(Ruang_ID,Nama,Kampus_ID,Lantai,kode_jurusan,RuangKuliah,Kapasitas,KapasitasUjian,Keterangan,Aktif)VALUES ('$Ruang_ID','$Nama','$Kampus_ID','$Lantai','$CekJurusan[$i]','$RuangKuliah','$Kapasitas','$KapasitasUjian','$Keterangan','$Aktif')";
          _query($sql)
          or die ();
          }	
          }  
    defaultRuang();
  break;

  case "editruang":
    editruang();
  break;
  
  case "delRuang":
       $sql="DELETE FROM ruang WHERE ID='$_GET[id]'";
       $qry=_query($sql)
       or die();
    defaultRuang();
  break;
}
?>
