<script language='javascript' type='text/javascript'>
  <!--
  function MM_jumpMenu(targ,selObj,restore){// v3.0
   eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
  }
  //-->
</script>
<?php
function TotalSks($id,$kode){
$T11 = "0";
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
return $T11;
}
function TotalSksPilihan($id,$kode){
$T11 = "0";
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id'  AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
return $T11;
}
function MatakuliahPerSemester($semester,$id,$kode){
echo"<div class='row-fluid'><div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> Semester $semester</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'><thead>
		<tr>
			<th>NO</th><th>KODE MTK</th><th>NAMA MTK</th><th>JENIS</th><th>STATUS</th><th>SMSTR</th><th>SKS</th><th><center>STATUS</center></th>
		</tr>
		</thead>                        
		<tbody>";
	$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$KelompokMtk=KelompokMtk($r[KelompokMtk_ID]);
	$n11++;
	echo "<tr>                            
		<td>$n11</td>
		<td>$KelompokMtk <span class='pull-right'>$r[Kode_mtk]</span></td>
		<td>$r[Nama_matakuliah]</td>  
		<td>$r[JenisMTK_ID] - $r[NamaJMK]</td>
		<td>$r[StatusMtk_ID] - $r[NamaSMk]</td>
		<td>$r[Semester]</td>     		         
		<td>$r[SKS]</td>
		<td><center>$sttus</center></td>";
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
function deflevelakademikmtk(){
$id= $_SESSION[Identitas];
$kode= $_SESSION[prodi];
buka("KAPRODI :: Daftar Matakuliah");  
echo "<div class='row-fluid'><div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
		<thead>";
if (!empty($id) AND !empty ($kode)) {
echo"<tr><th><div class='btn-group pull-right'>
	<a class=btn href=di-levelakademikmtk-DaftarMtkPilihan-$id-$kode.html>Daftar Mtk Pilihan </a>
	<a class=btn href=di-levelakademikmtk-StatusMtk-$id-$kode.html> Status Matakuliah</a>
	<a class=btn href=di-levelakademikmtk-Daftarkrklm-$id-$kode.html> Daftar Konsentrasi</a>
	<a class='btn btn-inverse' href='cetakMtk-Matakuliah-$id-$kode.html' target='_blank'>Cetak</a>
	</div></th></tr>";
	}		
echo"<tr><th></th></tr></thead></table></div></div>";
$jumlahsemester= ($kode=='61101')? '4': '8';
for ($num = 1; $num <= $jumlahsemester; $num++){
MatakuliahPerSemester($num,$id,$kode);
}
$Ttot=TotalSks($id,$kode);
	$jumlasemua="<span class='badge badge-success'>$Ttot</span><b> SKS</b>";
	echo"<div class='row-fluid'><div class='panel'>
	<div class='panel-header'><center><i class='icon-tasks'></i> TOTAL SELURUHNYA : $jumlasemua</center></div>
	</div></div>";    
tutup();					   
}
function DaftarMtkPilSmester($semester,$kode){
echo"<div class='row-fluid'><div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> Semester $semester</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>     
		<thead>
		<tr>
			<th>NO</th><th>KODE MTK</th><th>NAMA MTK</th><th>JENIS</th><th>STATUS</th><th>SMSTR</th><th>SKS</th><th><center>STATUS</center></th>
		</tr>
		</thead>                        
		<tbody>";
	$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$n11++;
	echo "<tr>                            
		<td>$n11</td>
		<td>$KelompokMtk <span class='pull-right'>$r[Kode_mtk]</span></td>
		<td>$r[Nama_matakuliah]</td>  
		<td>$r[JenisMTK_ID] - $r[NamaJMK]</td>
		<td>$r[StatusMtk_ID] - $r[NamaSMk]</td>
		<td>$r[Semester]</td>     		         
		<td>$r[SKS]</td>
		<td><center>$sttus</center></td>";
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
function DaftarMtkPilihan(){
$id= $_SESSION[Identitas];
$kode= $_SESSION[prodi];
buka("KAPRODI :: Matakuliah Pilihan");  
echo"<div class='row-fluid'><div class='panel-content'>
	<p class='pull-right'>
		<a class='btn btn-danger' href='javascript:history.go(-1)'><i class='icon-undo'></i> Kembali </a> 
	</p>
	</div></div>";
$jumlahsemester= ($kode=='61101')? '4': '8';
for ($num = 1; $num <= $jumlahsemester; $num++){
DaftarMtkPilSmester($num,$kode);
}
$Ttot=TotalSksPilihan($id,$kode);
	$jumlasemua="<span class='badge badge-success'>$Ttot</span><b> SKS</b>";
	echo"<div class='row-fluid'><div class='panel'>
	<div class='panel-header'><center><i class='icon-tasks'></i> TOTAL SELURUHNYA : $jumlasemua</center></div>
	</div></div>";
tutup();	
}
function StatusMtk(){
$id= $_SESSION[Identitas];
$kode= $_SESSION[prodi];
buka("BAAK :: Status Matakuliah"); 
echo"<div class='row-fluid'><div class='panel-content'>
	<p class='pull-right'>
		<a class='btn btn-danger' href='javascript:history.go(-1)'><i class='icon-undo'></i> Kembali </a> 
	</p>
    </div></div>";   
 
echo"<table class='table table-bordered table-striped'><thead>
	<tr><th>No</th><th>Kode Mtk</th><th>Nama Mtk</th><th>Jenis</th><th>Status</th><th>Sem</th><th>SKS</th><th>Aktif</th></tr></thead>";
	$sql="SELECT t1.*,t2.Nama AS NamaSMk FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID WHERE t1.Jurusan_ID='$kode' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
	$qry= _query($sql)
	or die ();
	while ($r=_fetch_array($qry)){          	
	$n1++;
	echo "<tr>                            
		<td>$n1</td>
		<td><a class=s href='get-levelakademikmtk-EditMtk-$r[Matakuliah_ID].html'> $r[Kode_mtk]</td>
		<td>$r[Nama_matakuliah]</td>  
		<td>$r[JenisMTK_ID]</td>
		<td>$r[StatusMtk_ID] - $r[NamaSMk]</td>
		<td>$r[Semester]</td>     		         
		<td>$r[SKS]</td><td>$r[Aktif]</td> ";
	$T1=$T1+$r[SKS];
	echo "</tr>";        
	}
	echo "<tfoot><tr class=style2><td colspan=6 align=right><b>Total :</b><td colspan=2>";
	echo number_format($T1,0,',','.');
	echo "</td></tr></tfoot></table>";
tutup();	
}
function Daftarkrklm(){
$id= $_SESSION[Identitas];
$kode= $_SESSION[prodi];
buka("KAPRODI :: Konsentrasi"); 
echo"<div class='row-fluid'><div class='panel-content'>
	<p class='pull-right'>
		<a class='btn btn-danger' href='javascript:history.go(-1)'><i class='icon-undo'></i> Kembali </a> 
	</p></div></div>"; 
echo"<table class='table table-bordered table-striped'><thead>
	<tr><th>Kode</th><th>Konsentrasi</th><th>Sesi</th><th>Jml/tahun</th><th>Aktif</th></tr></thead>";											
	$sql="SELECT * FROM kurikulum WHERE Identitas_ID='$id' AND Jurusan_ID='$kode' ORDER BY Kurikulum_ID";
	$qry= _query($sql) or die ();
	while ($d=_fetch_array($qry)){
	if(($no % 2)==0){ $warna="#FFFFFF"; }else{$warna="#E1E1E1"; }
	$no++;
echo "<tr bgcolor=$warna>             
	<td align=center>$d[Kode]</td>
	<td>$d[Nama]</td>
	<td>$d[Sesi]</td>
	<td>$d[JmlSesi]</td>
	<td>$d[Aktif]</td></tr>";        
	}	
echo"</table>";  
tutup();   
}

switch($_GET[PHPIdSession]){
  default:
deflevelakademikmtk();              	
  break;
  
  case "DaftarMtkPilihan":
DaftarMtkPilihan();
  break;

  case "StatusMtk":
StatusMtk();     
  break;

  case "Daftarkrklm";
Daftarkrklm(); 
  break;
}
?>
