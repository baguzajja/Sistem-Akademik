<script language='javascript' type='text/javascript'>
  <!--
  function MM_jumpMenu(targ,selObj,restore){// v3.0
   eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
  }
  //-->
</script>
<?php
function defakademikmatakuliah(){
global $buat,$baca,$tulis,$hapus;
if($baca){
$id      	= $_SESSION[Identitas];
$jabatan 	= $_SESSION[Jabatan];
$kode		= ($jabatan==18 OR $jabatan==19)? $_SESSION[prodi]: $_POST['jurusan'];
$diasbeld	= ($jabatan==18 OR $jabatan==19)? 'disabled' : '';
$diasbelt	= ($jabatan==19)? 'disabled' : '';
$kr=_query("SELECT * FROM jeniskurikulum WHERE Jurusan_ID='$kode' AND Aktif='Y'")or die();
$krl=_fetch_array($kr);
$kurikulum = (empty($_POST['kuriklm']))? $krl[JenisKurikulum_ID]: $_POST['kuriklm'];
if($jabatan==19){
$m = GetFields('mahasiswa', 'NIM', $_SESSION[yapane], '*');
$konsentrasi = $m['Kurikulum_ID'];
}else{
$konsentrasi = (empty($_POST['konsentrasi']))? '': $_POST['konsentrasi'];
}
$PRODI=NamaProdi($kode);
$NamaKonsentrasi=strtoupper(GetName("kurikulum","Kurikulum_ID",$konsentrasi,"Nama"));
buka("DAFTAR MATAKULIAH");
echo"<div class='row-fluid'> 
		<div class='span8'>
			<form action='go-akademikmatakuliah.html' method='post'><div class='row-fluid'>  
						<select name='jurusan' onChange='this.form.submit()' class='span4' $diasbeld>
						<option value=''> -- Pilih Program Studi --</option>";
							$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$id'";
							$qryp=_query($sqlp)or die();
							while ($d1=_fetch_array($qryp)){
							if ($d1['kode_jurusan']==$kode){ $cek="selected";  }  else{ $cek=""; }
						echo "<option value='$d1[kode_jurusan]' $cek>$d1[nama_jurusan]</option>";
							}
						echo"</select> 
						<select name='kuriklm' onChange='this.form.submit()' class='span4' $diasbeld>
						<option value=''> -- Pilih Kurikulum --</option>";
							$sqlp="SELECT * FROM jeniskurikulum WHERE Jurusan_ID='$kode' ORDER BY JenisKurikulum_ID DESC";
							$qryp=_query($sqlp)or die();
							while ($k=_fetch_array($qryp)){
							if ($k['JenisKurikulum_ID']==$kurikulum){ $cek="selected";  }  else{ $cek="";}
							echo "<option value='$k[JenisKurikulum_ID]' $cek>$k[Nama]</option>";
							}
						echo"</select>
						<select name='konsentrasi' onChange='this.form.submit()' class='span4' $diasbelt>
						<option value=''> -- Pilih Konsentrasi --</option>";
							$sqlp="SELECT * FROM kurikulum WHERE Identitas_ID='$id' AND Jurusan_ID='$kode'";
							$qryp=_query($sqlp)or die();
							while ($k=_fetch_array($qryp)){
							if ($k['Kurikulum_ID']==$konsentrasi){ $cek="selected";  }  else{ $cek="";}
							echo "<option value='$k[Kurikulum_ID]' $cek>$k[Nama]</option>";
							}
						echo"</select>
			</div></form>
		
		</div>
<div class='span4'> 
<div class='btn-group pull-right'>";
if($buat){
	echo"<a class='btn btn-success' href='action-akademikmatakuliah-EditMtk-1.html'>Tambah Matakuliah</a>";
}
if($baca){
if(!empty($konsentrasi) AND !empty($kode)){
echo"<button type='submit' class='btn btn-inverse iframe' title='DAFTAR MATA KULIAH - PRODI $PRODI' href='mtk-Matakuliah-$konsentrasi-$kode-$kurikulum.html'>Cetak</button>";
}
echo"<button class='btn dropdown-toggle' data-toggle='dropdown'>Menu&nbsp;&nbsp;<span class='caret'></span></button>
	<ul class='dropdown-menu'>
		<li><a href=aksi-akademikmatakuliah-SemuaMtk.html>Semua Matakuliah</a></li>
		<li><a href=aksi-akademikmatakuliah-DaftarKurikulum.html>Daftar Kurikulum</a></li>
		<li><a href=di-akademikmatakuliah-Daftarkonsentrasi-$id-$kode.html> Daftar Konsentrasi</a></li>
	</ul>";
}		
echo"</div>
</div>
</div>";
echo "<div class='tab-pane list-pane'>
<div class='list-pagination row-fluid'>
	<span class='pull-left'>PROGRAM STUDI : <strong>$PRODI</strong></span>
	<span class='pull-right'>KONSENTRASI : <strong>$NamaKonsentrasi</strong></span>
</div>
</div><br>";
if (!empty($konsentrasi) AND !empty ($kode)) {
$jumlahsemester= ($kode=='61101')? '4': '8';
for ($num = 1; $num <= $jumlahsemester; $num++){
MatakuliahPerSemester($num,$id,$kode,$konsentrasi,$kurikulum);
}
$Ttot=TotalSks($id,$kode,$konsentrasi);
	$jumlasemua="<span class='badge badge-success'>$Ttot</span><b> SKS</b>";
	echo"<div class='row-fluid'><div class='panel'>
	<div class='panel-header'><center><i class='icon-tasks'></i> TOTAL SELURUHNYA : $jumlasemua</center></div>
	</div></div>";  
}
}else{
ErrorAkses();
}
tutup();	
}
function TotalSks($id,$kode,$konsentrasi){
$prodi=($kode=='61101') ? 42:41;
$T11 = "0";

if($konsentrasi=='41'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.Kurikulum_ID IN ('41') AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Kode_mtk,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
}elseif($konsentrasi=='40'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.Kurikulum_ID IN ($konsentrasi) AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Kode_mtk,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
}else{
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.Kurikulum_ID IN ($prodi,$konsentrasi) AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Kode_mtk,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
}
return $T11;
}

function MatakuliahPerSemester($semester,$id,$kode,$kons,$kur){
global $buat,$baca,$tulis,$hapus;
$prodi=($kode=='61101') ? 42:41;
echo"<div class='row-fluid'><div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> Semester $semester</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'><thead>
		<tr>
			<th>NO</th>
			<th>ID</th>
			<th>KODE</th>
			<th>NAMA</th>
			<th><center>GBPP</center></th>
			<th><center>SAP</center></th>
			<th><center>SKS</center></th>
			<th><center>STATUS</center></th>
			<th></th>
		</tr>
		</thead>                        
		<tbody>";
if($kons=='41'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Kurikulum_ID IN ('41') AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' AND t1.JenisKurikulum_ID='$kur' GROUP BY t1.Matakuliah_ID ORDER BY t1.Kode_mtk,t1.Semester";
}elseif($kons=='40'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Kurikulum_ID IN ($kons) AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' AND t1.JenisKurikulum_ID='$kur' GROUP BY t1.Matakuliah_ID ORDER BY t1.Kode_mtk,t1.Semester";
} else {
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Kurikulum_ID IN ($prodi,$kons) AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B'  AND t1.JenisKurikulum_ID='$kur' GROUP BY t1.Matakuliah_ID ORDER BY t1.Kode_mtk,t1.Semester";
}
	
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$KelompokMtk=KelompokMtk($r[KelompokMtk_ID]);
	$n11++;
	echo "<tr>                            
		<td>$n11</td>
		<td>$r[Matakuliah_ID]</td>
		<td>$KelompokMtk <span class='pull-right'>$r[Kode_mtk]</span></td>
		<td>$r[Nama_matakuliah]</td>  
		<td><center><a class='btn btn-mini iframe' href='detail-Gbpp-$r[Matakuliah_ID].html'>GBPP</a></center></td>
		<td><center><a class='btn btn-mini iframe' href='detail-Sap-$r[Matakuliah_ID].html'>SAP</a></center></td>    		         
		<td><center>$r[SKS]</center></td>
		<td><center>$sttus</center></td>
		<td width='5%'>
		<center>
			<div class='btn-group'>";
if($baca){
echo"<a class='btn btn-mini iframe' href='detail-Mtk-$r[Matakuliah_ID].html'>Detail</a>";
}
if($tulis){
echo"<a class='btn btn-mini btn-inverse' href='actions-akademikmatakuliah-EditMtk-0-$r[Matakuliah_ID].html'>Edit</a>";
}
if($hapus){
echo"<a class='btn btn-mini btn-danger' href='get-akademikmatakuliah-delMtk-$r[Matakuliah_ID].html' onClick=\"return confirm('Anda yakin akan Menghapus Matakuliah  $r[Nama_matakuliah] ?')\">Hapus</a>";
}
	echo"</div>
		</center>
		</td>";
	$T11=$T11+$r[SKS];
	$jt11=number_format($T11,0,',','.');
	$jumlah11="<span class='badge badge-info'>$jt11</span><b> SKS</b>";
	echo "</tr>";        
	}
    echo "<tfoot><tr>                            
		<td colspan=6 ><b class='pull-right'>Total :</b></td>
		<td colspan=3>$jumlah11</td>
		</tr></tfoot>";
	echo "</tbody></table></div></div></div>";
}

function SemuaMtk(){
global $buat,$baca,$tulis,$hapus;
$kurikulumAktif=strtoupper(GetName("jeniskurikulum","Aktif",'Y',"JenisKurikulum_ID"));
$prodi = ($_SESSION[Jabatan]==18 OR $_SESSION[Jabatan]==19)? "AND Jurusan_ID='$_SESSION[prodi]'": "";
$kprodi = ($_SESSION[Jabatan]==18 OR $_SESSION[Jabatan]==19)? "WHERE Jurusan_ID='$_SESSION[prodi]'": "";
$kurikulum = (empty($_POST[kuriklm]))? $kurikulumAktif: $_POST['kuriklm'];
$m = GetFields('mahasiswa', 'NIM', $_SESSION[yapane], '*');
$konsentrasi =($_SESSION[Jabatan]==19)? "AND Kurikulum_ID='$m[Kurikulum_ID]'" : "";
if($baca){
echo"<div class='panel-header'>
<div class='row-fluid'>
	<div class='span6'><i class='icon-sign-blank'></i> Daftar Semua Matakuliah</div>
	<div class='span6'>
		<form action='aksi-akademikmatakuliah-SemuaMtk.html' method='post'>
						<select name='kuriklm' onChange='this.form.submit()' class='pull-right' $diasbeld>
						<option value=''> -- Pilih Kurikulum --</option>";
							$sqlp="SELECT * FROM jeniskurikulum $kprodi ORDER BY JenisKurikulum_ID DESC";
							$qryp=_query($sqlp)or die();
							while ($k=_fetch_array($qryp)){
							if ($k['JenisKurikulum_ID']==$kurikulum){ $cek="selected";  }  else{ $cek="";}
							echo "<option value='$k[JenisKurikulum_ID]' $cek>$k[Nama]</option>";
							}
						echo"</select>
		</form></div>
</div></div>
	<div class='panel-content'>
	<table class='table table-bordered table-striped' id='example'><thead>
		<tr>
			<th>NO</th>
			<th>ID</th>
			<th>KODE</th>
			<th>NAMA</th>
			<th>KONSENTRASI</th>
			<th><center>GBPP</center></th>
			<th><center>SAP</center></th>
			<th><center>SKS</center></th>
			<th><center>STATUS</center></th>
			<th><center>AKSI</center></th>
		</tr>
		</thead>                        
		<tbody>";
$sql="SELECT * FROM matakuliah WHERE Identitas_ID='$_SESSION[Identitas]' AND JenisKurikulum_ID='$kurikulum' $prodi $konsentrasi ORDER BY Nama_matakuliah, Semester, Kode_mtk ASC";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$KelompokMtk=KelompokMtk($r[KelompokMtk_ID]);
	$NamaKonsentrasi=strtoupper(GetName("kurikulum","Kurikulum_ID",$r[Kurikulum_ID],"Nama"));
	$n11++;
	echo "<tr>                            
		<td>$n11</td>
		<td>$r[Matakuliah_ID]</td>
		<td>$KelompokMtk <span class='pull-right'>$r[Kode_mtk]</span></td>
		<td>$r[Nama_matakuliah]</td>  
		<td>$NamaKonsentrasi</td>  
		<td><center><a class='btn btn-mini iframe' href='detail-Gbpp-$r[Matakuliah_ID].html'>GBPP</a></center></td>
		<td><center><a class='btn btn-mini iframe' href='detail-Sap-$r[Matakuliah_ID].html'>SAP</a></center></td>    		         
		<td><center>$r[SKS]</center></td>
		<td><center>$sttus</center></td>
		<td width='5%'>
		<center>
			<div class='btn-group'>";
if($baca){
echo"<a class='btn btn-mini iframe' href='detail-Mtk-$r[Matakuliah_ID].html'>Detail</a>";
}
if($tulis){
echo"<a class='btn btn-mini btn-inverse' href='actions-akademikmatakuliah-EditMtk-0-$r[Matakuliah_ID].html'>Edit</a>";
}
if($hapus){
echo"<a class='btn btn-mini btn-danger' href='get-akademikmatakuliah-delMtk-$r[Matakuliah_ID].html' onClick=\"return confirm('Anda yakin akan Menghapus Matakuliah  $r[Nama_matakuliah] ?')\">Hapus</a>";
}
	echo"</div>
		</center>
		</td>";
	$T11=$T11+$r[SKS];
	$jt11=number_format($T11,0,',','.');
	$jumlah11="<span class='badge badge-info'>$jt11</span><b> SKS</b>";
	echo "</tr>";        
	}
	echo "</tbody></table></div>";
	}else{
	ErrorAkses();
	}
}

function EditMtk(){
global $buat,$baca,$tulis,$hapus;
if($tulis){
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $r = GetFields('matakuliah', 'Matakuliah_ID', $id, '*');
    $jdl = "Edit Matakuliah";
	$Prodi = ($_SESSION[Jabatan]==18)? "AND Jurusan_ID='$_SESSION[prodi]'": "";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='ID' value='$r[Matakuliah_ID]'>";
  } else {
    $r = array();
    $r['Identitas_ID'] 		= $_SESSION[Identitas];
	$r['JenisMTK_ID']		='';
	$r['KelompokMtk_ID']	='';
	$r['StatusMtk_ID']		='';
	$r['JenisKurikulum_ID']	='';
	$r['Kurikulum_ID']		='';
	$r['Semester']			='';
	$r['Penanggungjawab']	='';
	$r['Aktif']				='';
	$r['SKS']				='';
	$r['gbpp']				='';
	$r['sap']				='';
	$Prodi = ($_SESSION[Jabatan]==18)? "AND Jurusan_ID='$_SESSION[prodi]'": "";
    $jdl 					= "Tambah Matakuliah";
    $btn 					= "SIMPAN";
    $hiden 					= "";
  }

buka($jdl);
echo"<form action='aksi-akademikmatakuliah-upMtk.html' method='post' class='form-horizontal'>
<input type=hidden name='md' value='$md'>
	$hiden
		<fieldset>
		<div class='row-fluid'>
		<div class='control-group'>
		<label class='control-label'>Institusi</label>
			<div class='controls'>
				<select name='i' id='identitas' class='span12'>
                <option value=''>- Pilih Institusi -</option>";
                $t=_query("SELECT * FROM identitas ORDER BY ID");
                while($w=_fetch_array($t)){
				$cek=($r[Identitas_ID]==$w[Identitas_ID]) ? 'selected': '';
				echo "<option value=$w[Identitas_ID] $cek>$w[Identitas_ID] - $w[Nama_Identitas]</option>";
					}
				echo "</select>
			</div>
		</div>

		<div class='control-group'>
		<label class='control-label'>Program Studi</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span6'>
				<select name='jur' id='jurusan' class='span12'>
                <option value=''>- Pilih Program Studi -</option>";
                $t=_query("SELECT * FROM jurusan ORDER BY kode_jurusan");
                while($w=_fetch_array($t)){
				$cek=($r[Jurusan_ID]==$w[kode_jurusan]) ? 'selected': '';
				echo "<option value=$w[kode_jurusan] $cek>$w[kode_jurusan] - $w[nama_jurusan]</option>";
				}
				echo "</select></div>
			<div class='span6'>
				<label class='control-label'>Kode Matakuliah</label>
				<div class='controls'>
				<input type=text name='kmk' value='$r[Kode_mtk]' class='span12' Placeholder=''>
			</div>
			</div>
			</div>
			</div>
		</div>

		<div class='control-group'>
		<label class='control-label'>Nama Matakuliah</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span6'><input type=text name='nm' class='span12' value='$r[Nama_matakuliah]'></div>
			<div class='span6'>
				<label class='control-label'>Jenis Matakuliah</label>
				<div class='controls'>
					<select name='jmk' class='span12'>
					<option value=''>- Pilih Jenis Matakuliah -</option>";
					$tampil=_query("SELECT * FROM jenismk ORDER BY JenisMK_ID");
					while($w=_fetch_array($tampil)){
					$cek=($r[JenisMTK_ID]==$w[JenisMK_ID]) ? 'selected': '';
					echo "<option value=$w[JenisMK_ID] $cek>$w[JenisMK_ID] - $w[Nama]</option>";
					}
					echo "</select>
				</div>
			</div>
			</div>
			</div>
		</div>

		<div class='control-group'>
		<label class='control-label'>Kelompok Matakuliah</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span6'> <select name='klmptk' class='span12'>
                <option value=''>- Pilih Kelompok Matakuliah -</option>";
                $tampil=_query("SELECT * FROM kelompokmtk ORDER BY KelompokMtk_ID");
                while($w=_fetch_array($tampil)){
				$cek=($r[KelompokMtk_ID]==$w[KelompokMtk_ID]) ? 'selected': '';
				echo "<option value=$w[KelompokMtk_ID] $cek>  $w[Nama]</option>";
				}
				echo "</select></div>
			<div class='span6'>
				<label class='control-label'>Status Matakuliah</label>
				<div class='controls'><select name='stmk' class='span12'>
                <option value=''>- Pilih Status -</option>";
                $tampil=_query("SELECT * FROM statusmtk ORDER BY StatusMtk_ID");
                while($w=_fetch_array($tampil)){
				$cek=($r[StatusMtk_ID]==$w[StatusMtk_ID]) ? 'selected': '';
                echo "<option value=$w[StatusMtk_ID] $cek>$w[StatusMtk_ID] - $w[Nama]</option>";
				}
				echo "</select>
				</div>
			</div>
			</div>
			</div>
		</div>

		<div class='control-group'>
			<label class='control-label'>Konsentrasi</label>
				<div class='controls'>
				<div class='row-fluid'>
				<div class='span6'><select name='nkur' class='span12'>
						<option value=''>- Pilih Nama Konsentrasi -</option>";
						$tampil=_query("SELECT * FROM kurikulum WHERE Identitas_ID='$_SESSION[Identitas]' $Prodi ORDER BY Nama ASC");
						while($w=_fetch_array($tampil)){
						$cek=($r[Kurikulum_ID]==$w[Kurikulum_ID]) ? 'selected': '';
						echo "<option value=$w[Kurikulum_ID] $cek>$w[Jurusan_ID] -  $w[Nama]</option>";
						}
				echo "</select></div>
				<div class='span6'>
					<label class='control-label'>Kurikulum</label>
					<div class='controls'><select name='jkur' class='span12'>
                <option value=''>- Pilih Kurikulum -</option>";
                $tampil=_query("SELECT * FROM jeniskurikulum ORDER BY JenisKurikulum_ID");
                while($w=_fetch_array($tampil)){
				$cek=($r[JenisKurikulum_ID]==$w[JenisKurikulum_ID]) ? 'selected': '';
				echo "<option value=$w[JenisKurikulum_ID] $cek>$w[Nama]</option>";  
				}
				echo "</select>
					</div>
				</div>
				</div>
				</div>
		</div>

	<div class='control-group'>
			<label class='control-label'>Semester</label>
				<div class='controls'>
				<div class='row-fluid'>
				<div class='span6'><input type=text name='sesi' class='span12' value='$r[Semester]'></div>
				<div class='span6'>
					<label class='control-label'>Jumlah Sks</label>
					<div class='controls'> <input type=text name='sks' class='span12' value='$r[SKS]'>
					</div>
				</div>
				</div>
				</div>
		</div>

		<div class='control-group'>
			<label class='control-label'>Penanggung Jawab</label>
				<div class='controls'>
				<div class='row-fluid'>
				<div class='span6'><select name='pj' class='span12'>
                <option value=''>- Pilih Penanggung Jawab -</option>";
                $tampil=_query("SELECT * FROM dosen ORDER BY nama_lengkap ASC");
                while($w=_fetch_array($tampil)){
				$cek=($r[Penanggungjawab]==$w[dosen_ID]) ? 'selected': '';
				 echo "<option value=$w[dosen_ID] $cek>$w[nama_lengkap],$w[Gelar]</option>";
                 }
				echo "</select></div>
				<div class='span6'>
					<label class='control-label'>Status</label>
					<div class='controls'>";
					if ($r[Aktif]=='Y'){
					  echo "<input type=radio name='ak' value='Y' checked>Y  
							<input type=radio name='ak' value='N'> N";
					}
					else{
					  echo "<input type=radio name='ak' value='Y'>Y  
							<input type=radio name='ak' value='N' checked>N";
					}
					echo"</div>
				</div>
				</div>
				</div>
		</div>
		</div>

		<div class='control-group'>
			<label class='control-label'>GBPP</label>
				<div class='controls'>
					<textarea id='GBPP' name='gbpp'>$r[gbpp]</textarea>
				</div>
		</div>
		<div class='control-group'>
			<label class='control-label'>SAP</label>
				<div class='controls'>
					<textarea id='SAP' name='sap'>$r[sap]</textarea>
				</div>
		</div>

		<div class='form-actions'>
			<input class='btn btn-success' type=submit value='$btn'>
			<a class='btn btn-small btn-danger pull-right' href='go-akademikmatakuliah.html'>Batal</a>
		</div>

	</fieldset>
    </form>"; 
}else{
ErrorAkses();
}   
tutup();	
} 
function upMtk(){
	$md 			= $_POST['md']+0;
	$kode			= $_POST['i'];
	$jur			= $_POST['jur'];
	$nkur			= $_POST['nkur'];
if ($md == 0) {
	$update=_query("UPDATE matakuliah SET Identitas_ID  = '$kode',
		Kode_mtk  			= '$_POST[kmk]',
		Nama_matakuliah  	= '$_POST[nm]',
		Semester  			= '$_POST[sesi]',
		SKS  				= '$_POST[sks]',
		Jurusan_ID  		= '$jur',
		KelompokMtk_ID  	= '$_POST[klmptk]',
		JenisMTK_ID  		= '$_POST[jmk]',
		JenisKurikulum_ID  	= '$_POST[jkur]',
		StatusMtk_ID  		= '$_POST[stmk]',
		Kurikulum_ID 		= '$nkur',
		Penanggungjawab  	= '$_POST[pj]',
		gbpp  				= '$_POST[gbpp]',
		sap  				= '$_POST[sap]',
		Aktif  				= '$_POST[ak]'
		WHERE Matakuliah_ID = '$_POST[ID]'");
	PesanOk("Update Matakuliah","Matakuliah Berhasil di Update ","go-akademikmatakuliah.html");   
	}else{
		$cek=_num_rows(_query("SELECT * FROM matakuliah WHERE Kode_mtk='$_POST[kmk]' AND Jurusan_ID='$jur' AND Nama_matakuliah='$_POST[nm]' AND Kurikulum_ID='$nkur'"));
       if ($cek > 0){
		PesanEror("Error.. !! ","Data matakuliah Sudah ada dalam database");
		}else{        
        $masuk=_query("INSERT INTO matakuliah(Identitas_ID,Kode_mtk,Nama_matakuliah,Semester,SKS,Jurusan_ID,KelompokMtk_ID,JenisMTK_ID,JenisKurikulum_ID,StatusMtk_ID,Kurikulum_ID,Penanggungjawab,gbpp,sap,Aktif)
        VALUES('$kode','$_POST[kmk]','$_POST[nm]','$_POST[sesi]','$_POST[sks]','$jur','$_POST[klmptk]','$_POST[jmk]','$_POST[jkur]','$_POST[stmk]','$nkur','$_POST[pj]','$_POST[gbpp]','$_POST[sap]','$_POST[ak]')");

		PesanOk("Tambah Matakuliah","Matakuliah Berhasil di Simpan ","go-akademikmatakuliah.html");  
		}
	}
}
function Daftarkonsentrasi(){
global $buat,$baca,$tulis,$hapus;
if($baca){
$id= $_SESSION['Identitas'];
$kode= $_REQUEST['kode'];
$diasbeld	= ($_SESSION[Jabatan]==18 OR $_SESSION[Jabatan]==19)? 'disabled' : '';
buka("Daftar Konsentrasi");
echo "<div class='row-fluid'><div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>
					<div class='input-prepend input-append pull-left'>
					<span class='add-on'> Program Studi </span>
					<select name='jurusan' onChange=\"MM_jumpMenu('parent',this,0)\" $diasbeld>
					<option value='aksi-akademikmatakuliah-Daftarkonsentrasi.html'> </option>";
						$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$id'";
						$qryp=_query($sqlp)or die();
						while ($d1=_fetch_array($qryp)){
						if ($d1['kode_jurusan']==$kode){ $cek="selected";  }  else{ $cek=""; }
					echo "<option value='di-akademikmatakuliah-Daftarkonsentrasi-$id-$d1[kode_jurusan].html' $cek>  $d1[nama_jurusan]</option>";
						}
					echo"</select> <input name='TxtKodeH' type='hidden' value='$kode'>
					</div>
					<div class='btn-group pull-right'>";
if($buat){
					echo"<a class='btn btn-success' href='action-akademikmatakuliah-EditKonsentrasi-1.html'> Tambah Konsentrasi</a>";
}
					echo"<a class='btn btn-danger' href='go-akademikmatakuliah.html'><i class'icon-undo'></i>Kembali</a>
					</div>
				</th>
			</tr>";
echo"<tr><th></th></tr></thead></table></div></div>";
$PRODI=NamaProdi($kode);
echo"<div class='row-fluid'><div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> Daftar Konsentrasi :: Prodi $PRODI</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>     
	<thead>
		<tr>
			 <th>ID</th>
			 <th>Konsentrasi</th>
			 <th>Sesi</th>
			 <th>Jml/tahun</th>
			 <th>Aktif</th>
			 <th>Aksi</th>
		</tr>
	</thead>                       
	<tbody>";
	$sql="SELECT * FROM kurikulum WHERE Identitas_ID='$id' AND Jurusan_ID='$kode' ORDER BY Kurikulum_ID";
	$qry= _query($sql) or die ();
	while ($d=_fetch_array($qry)){ 
	$sttus = ($d['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$n18++;
	echo "<tr>                            
		<td align=center>$d[Kurikulum_ID]</td>
		<td>$d[Nama]</td>
		<td>$d[Sesi]</td>
		<td>$d[JmlSesi]</td>
		<td><center>$sttus</center></td>
		<td>
	<center>
		<div class='btn-group'>";
if($tulis){
echo"<a class='btn btn-mini btn-inverse' href='actions-akademikmatakuliah-EditKonsentrasi-0-$d[Kurikulum_ID].html'>Edit</a>";
}if($hapus){
echo"<a class='btn btn-mini btn-danger' href='get-akademikmatakuliah-delkurklm-$d[Kurikulum_ID].html' onClick=\"return confirm('Anda yakin akan Menghapus data Konsentrasi $d[Nama] ?')\">Hapus</a>";
}
echo"</div>
	</center>
		</td></tr>";        
	}
    echo "</tbody>";
	echo "</table></div></div></div>";
}else{
ErrorAkses();
}
tutup();	
}

function EditKonsentrasi(){
global $buat,$baca,$tulis,$hapus;
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('kurikulum', 'Kurikulum_ID', $id, '*');
    $jdl = "Edit Konsentrasi";
    $hiden = "<input type=hidden name='id' value='$w[Kurikulum_ID]'>";
  } else {
    $w = array();
    $w['Kode']= '';
    $w['Nama']= '';
    $w['Identitas_ID'] = $_SESSION[Identitas];
    $w['Jurusan_ID'] = '';
    $w['Sesi'] = '';
    $w['JmlSesi'] = '';
    $w['Aktif'] = 'N';
    $jdl = "Tambah Konsentrasi";
    $hiden = "";
  }
if($tulis){
buka("BAAK :: $jdl");
echo"<form action='aksi-akademikmatakuliah-simpanKonsentrasi.html' method='post'>
<input type=hidden name='md' value='$md'>
$hiden
	<table class='table table-bordered table-striped'><thead>
	<tr>
		<td>Institusi</td><td colspan=2>
		<select name='identitas'>
		<option value=''>- Pilih Institusi -</option>";
        $sqlp="SELECT * FROM identitas ORDER BY Identitas_ID";
		$qryp=_query($sqlp) or die();
		while ($d=_fetch_array($qryp)){
		if ($d['Identitas_ID']==$w['Identitas_ID']){ $cek="selected"; } else{ $cek=""; }
		echo "<option value='$d[Identitas_ID]' $cek>$d[Nama_Identitas]</option>";
		}
		echo "</select>
	</tr>
	<tr>
		<td>Program Studi</td><td colspan=2>
		<select name='jurusan'>
		<option value=''>- Pilih Program Studi -</option>";
		$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$w[Identitas_ID]'";
		$qryp=_query($sqlp) or die();
		while ($d1=_fetch_array($qryp)){
		if ($d1['kode_jurusan']==$w['Jurusan_ID']){ $cek="selected"; } else{ $cek=""; }
		echo "<option value='$d1[kode_jurusan]' $cek> $d1[nama_jurusan]</option>";
		}
    echo"</select>
		</td>
		</tr>
		<tr><td class=cc>Kode Konsentrasi </td>
		<td> <input type=text name='Kode' value='$w[Kode]'></td>
		</tr>
		<tr><td class=cc>Nama Konsentrasi</td>
			<td><input type=text name='Nama' value='$w[Nama]'></td>
		</tr>
		<tr><td class=cc>Nama Sesi </td>
		<td>  <input type=text name='Sesi' value='$w[Sesi]'></td></tr>
		<tr><td class=cc>Jumlah Sesi/ Tahun :</td>
		<td><input type=text name='JmlSesi' value='$w[JmlSesi]'></td></tr>
		<tr><td class=cc>Status </td> 
		<td>";
if($w['Aktif'] == 'Y'){
	echo"<input type=radio name=Aktif value='Y' checked>Y 
		<input type=radio name=Aktif value='N'>N ";
}else{
	echo"<input type=radio name=Aktif value='Y'>Y 
		<input type=radio name=Aktif value='N' checked>N ";
}
	echo"</td></tr>
		<tr><td colspan=2><center>
			<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Simpan>
				<a class='btn btn-small btn-danger' href='di-akademikmatakuliah-Daftarkonsentrasi-$w[Identitas_ID]-$w[Jurusan_ID].html'>Batal</a>
			</div>                     
			</center></td>
         </tr>
       </thead></table>
      </form>"; 
}else{
ErrorAkses();
} 
tutup();	
}

function simpanKonsentrasi(){
	$md 			= $_POST['md']+0;
	$id				= $_POST['id'];
	$identitas 		= $_POST['identitas']; 
	$jurusan		= $_POST['jurusan'];   
	$kode			= $_POST['Kode'];        
	$nama		 	= $_POST['Nama'];
	$Sesi		 	= $_POST['Sesi'];
	$JmlSesi		= $_POST['JmlSesi'];
	$aktif 			= $_POST['Aktif'];
if ($md == 0) {
	$update=_query("UPDATE kurikulum SET
			Kode			= '$kode',
			Nama			= '$nama',
			Identitas_ID	= '$identitas',
			Jurusan_ID		= '$jurusan',
			Sesi			= '$Sesi',
			JmlSesi			= '$JmlSesi',
			Aktif			= '$aktif'
			WHERE Kurikulum_ID	= '$id'");
	PesanOk("Update Konsentrasi","Konsentrasi Berhasil di Update ","di-akademikmatakuliah-Daftarkonsentrasi-$identitas-$jurusan.html");
}else{
	$cek=_num_rows(_query("SELECT * FROM kurikulum WHERE Kode='$kode' AND Identitas_ID='$identitas' AND Jurusan_ID='$jurusan'"));
        if ($cek > 0){
	PesanEror("Konsentrasi Gagal disimpan", "Konsentrasi Sudah ada dalam database");
	}else{
       $insert= _query("INSERT INTO kurikulum(Kode,Nama,Identitas_ID,Jurusan_ID,Sesi,JmlSesi,Aktif)
        VALUES('$kode','$nama','$identitas','$jurusan','$Sesi','$JmlSesi','$aktif')");
	PesanOk("Tambah Konsentrasi Baru","Konsentrasi Baru Berhasil di Simpan ","di-akademikmatakuliah-Daftarkonsentrasi-$identitas-$jurusan.html"); 
	   }
}
}
function DaftarKurikulum(){
global $buat,$baca,$tulis,$hapus;
if($baca){
$id= $_SESSION['Identitas'];
$kode= $_REQUEST['kode'];
$diasbeld	= ($_SESSION[Jabatan]==18 OR $_SESSION[Jabatan]==19)? 'disabled' : '';
$where	= ($_SESSION[Jabatan]==18)? "WHERE Jurusan_ID='$kode'": '';
buka("Daftar Kurikulum");
echo "<div class='row-fluid'><div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>
					<div class='btn-group pull-right'>";
if($buat){
					echo"<a class='btn btn-success' href='action-akademikmatakuliah-EditKurikulum-1.html'> Tambah Kurikulum</a>";
}
					echo"<a class='btn btn-danger' href='go-akademikmatakuliah.html'><i class'icon-undo'></i>Kembali</a>
					</div>
				</th>
			</tr>";
echo"<tr><th></th></tr></thead></table></div></div>";
echo"<div class='row-fluid'><div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> Daftar Kurikulum</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>     
	<thead>
		<tr>
			 <th>NO</th>
			 <th>Nama Kurikulum</th>
			 <th>Program Studi</th>
			 <th><center>Status</center></th>
			 <th><center>Aksi</center></th>
		</tr>
	</thead>                       
	<tbody>";
	$no=0;
	$sql="SELECT * FROM jeniskurikulum $where ORDER BY Nama";
	$qry= _query($sql) or die ();
	while ($d=_fetch_array($qry)){ 
	$sttus = ($d['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$PRODI=NamaProdi($d[Jurusan_ID]);
	$no++;
	echo "<tr>                            
		<td>$no</td>
		<td>$d[Nama]</td>
		<td>$PRODI</td>
		<td><center>$sttus</center></td>
		<td>
	<center>
		<div class='btn-group'>";
if($tulis){
echo"<a class='btn btn-mini btn-inverse' href='actions-akademikmatakuliah-EditKurikulum-0-$d[JenisKurikulum_ID].html'>Edit</a>";
}
echo"</div>
	</center>
		</td></tr>";        
	}
    echo "</tbody>";
	echo "</table></div></div></div>";
}else{
ErrorAkses();
}
tutup();	
}
function EditKurikulum(){
global $buat,$baca,$tulis,$hapus;
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('jeniskurikulum', 'JenisKurikulum_ID', $id, '*');
    $jdl = "Edit Kurikulum";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='id' value='$w[JenisKurikulum_ID]'>";
  } else {
    $w = array();
    $w['Kode']= '';
    $w['Nama']= '';
    $w['Jurusan_ID'] = '';
    $w['Aktif'] = 'N';
    $jdl = "Tambah Kurikulum";
    $btn = "SIMPAN";
    $hiden = "";
  }
if($tulis){
buka("$jdl");
echo"<form class='form-horizontal' action='aksi-akademikmatakuliah-simpanKurikulum.html' method='post'>
<input type=hidden name='md' value='$md'>
$hiden
<fieldset>
	<div class='control-group'>
		<label class='control-label'>Untuk Program Studi ?</label>
			<div class='controls'>
				<select name='jurusan' class='input-xlarge'>
				<option value=''>- Pilih Program Studi -</option>";
				$sqlp="SELECT * FROM jurusan ORDER BY nama_jurusan ASC";
				$qryp=_query($sqlp) or die();
				while ($d1=_fetch_array($qryp)){
				$cek=($d1['kode_jurusan']==$w['Jurusan_ID'])? "selected": ""; 
				echo "<option value='$d1[kode_jurusan]' $cek> $d1[nama_jurusan]</option>";
				}
			echo"</select>
			</div>
	</div>
	<div class='control-group'>
		<label class='control-label'>Nama Kurikulum</label>
			<div class='controls'>
				<input type='text' class='input-xlarge' name='nama' value='$w[Nama]'>
			</div>
	</div>
	<div class='control-group'>
		<label class='control-label'>Status Kurikulum</label>
			<div class='controls'>";
				if($w['Aktif'] == 'Y'){
					echo"<input type=radio name=Aktif value='Y' checked>Y 
						<input type=radio name=Aktif value='N'>N ";
				}else{
					echo"<input type=radio name=Aktif value='Y'>Y 
						<input type=radio name=Aktif value='N' checked>N ";
				}
			echo"</div>
	</div>

	<div class='form-actions'>
		<input class='btn btn-success' type=submit value='$btn'>
		<a class='btn btn-small btn-danger' href='aksi-akademikmatakuliah-DaftarKurikulum.html'>Batal</a>
	</div>
</fieldset>
</form>"; 
}else{
ErrorAkses();
} 
tutup();	
}
function simpanKurikulum(){
	$md 			= $_POST['md']+0;
	$id				= $_POST['id'];
	$jurusan		= $_POST['jurusan'];         
	$nama		 	= $_POST['nama'];
	$aktif 			= $_POST['Aktif'];
if ($md == 0) {
	$update=_query("UPDATE jeniskurikulum SET
			Nama			= '$nama',
			Jurusan_ID		= '$jurusan',
			Aktif			= '$aktif'
			WHERE JenisKurikulum_ID	= '$id'");
if ($aktif == 'Y') {
	$updateAll=_query("UPDATE jeniskurikulum SET Aktif = 'N' WHERE Jurusan_ID='$jurusan' AND JenisKurikulum_ID NOT IN ('$id')");
}
	PesanOk("Update Kurikulum","Kurikulum Berhasil di Update ","aksi-akademikmatakuliah-DaftarKurikulum.html");
}else{
	$cek=_num_rows(_query("SELECT * FROM jeniskurikulum WHERE Nama='$nama' AND Jurusan_ID='$jurusan'"));
        if ($cek > 0){
	PesanEror("Kurikulum Gagal disimpan", "Kurikulum Sudah ada dalam database");
	}else{
       $insert= _query("INSERT INTO jeniskurikulum(Nama,Jurusan_ID,Aktif)
        VALUES('$nama','$jurusan','$aktif')");
		$idBaru = mysql_insert_id();
if ($aktif == 'Y') {
	$updateAll=_query("UPDATE jeniskurikulum SET Aktif = 'N' WHERE Jurusan_ID='$jurusan' AND JenisKurikulum_ID NOT IN ('$idBaru')");
}
	PesanOk("Tambah Kurikulum Baru","Kurikulum Baru Berhasil di Simpan ","aksi-akademikmatakuliah-DaftarKurikulum.html"); 
	   }
}
}
switch($_GET[PHPIdSession]){
//Matakuliah
default:
	if($_SESSION[Jabatan]==19){
	SemuaMtk();
	}else{
	defakademikmatakuliah();
	}
break;
case "SemuaMtk";
	SemuaMtk();
break;

case "EditMtk";
	EditMtk();
break;
case "upMtk":
	upMtk();	
break;
case "delMtk":
	$hapus=_query("DELETE FROM matakuliah WHERE Matakuliah_ID='$_GET[id]'");
	PesanOk("Hapus Matakuliah","Matakuliah Berhasil di Hapus ","go-akademikmatakuliah.html");
break;
//Konsentrasi
case "Daftarkonsentrasi";
	Daftarkonsentrasi();						
break;
case "EditKonsentrasi":
	EditKonsentrasi();
break;
case "simpanKonsentrasi":
	simpanKonsentrasi();
break;
case "delkurklm":
	$hapus=_query("DELETE FROM kurikulum WHERE Kurikulum_ID='$_GET[id]'");
	PesanOk("Hapus Konsentrasi","Konsentrasi Berhasil di Hapus ","go-akademikmatakuliah.html");
break;
// Kurikulum
case "DaftarKurikulum":
	DaftarKurikulum();
break;
case "EditKurikulum":
	EditKurikulum();
break;
case "simpanKurikulum":
	simpanKurikulum();
break;
}
?>
