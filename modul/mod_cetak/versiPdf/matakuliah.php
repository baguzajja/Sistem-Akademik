<style type="text/css">
<!--
table.month{
	width: 100%; 
    border:1px solid #ccc;
    margin-bottom:10px;
    border-collapse:collapse;
}
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }

table.month td{
    border:1px solid #ddd;
    color:#333;
    padding:3px;
    text-align:left;
}

table.month th {
    padding:5px;
	background-color:#208bbd;
    color:#fff;
	text-align:center;
}
table.month th.head{
	background-color:#EEE;
	text-align:center;
	 color:#444444;
}
table.month th.fooot{
	background-color:#EEE;
	float:right;
	 color:#444444;
}
-->
</style>
<?php
function MatakuliahPerSemester($semester,$id,$kode,$kons,$kur){
$prodi=($kode=='61101') ? 42:41;
echo"<div style='width: 100%;'><table class='month' style='width: 100%; color:#444; border: 1px #eee;'>
		<tr><th class='head' colspan='5' style='width: 100%; border: 1px #eee;'>SEMESTER $semester</th></tr>
		<tr>
			<th style='width:5%; border: 1px #eee;'>NO</th>
			<th colspan='2' style='width:20%; border: 1px #eee;'>KODE</th>
			<th style='width: 55%; border: 1px #eee;'>NAMA</th>
			<th style='width: 10%; border: 1px #eee;'>SKS</th>
		</tr>                      
		<tbody>";
if($kons=='41'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Kurikulum_ID IN ('41') AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisKurikulum_ID='$kur' GROUP BY t1.Matakuliah_ID ORDER BY t1.Kode_mtk,t1.Semester";
}elseif($kons=='40'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Kurikulum_ID IN ($kons) AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisKurikulum_ID='$kur' GROUP BY t1.Matakuliah_ID ORDER BY t1.Kode_mtk,t1.Semester";
} else {
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Kurikulum_ID IN ($prodi,$kons) AND t1.Aktif='Y' AND t1.StatusMtk_ID='A'  AND t1.JenisKurikulum_ID='$kur' GROUP BY t1.Matakuliah_ID ORDER BY  t1.Kode_mtk,t1.Semester";
}
	
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){
	$mtkPilihan=($r['JenisMTK_ID']=='B' AND $semester==6 )? " <i style='color:#dc0000;'>***</i>":"";
	$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$KelompokMtk=KelompokMtk($r[KelompokMtk_ID]);
	$n11++;
	echo "<tr>                            
		<td style='width:5%%;'>$n11</td>
		<td style='width: 12%;'>$KelompokMtk</td>
		<td style='width: 8%;'>$r[Kode_mtk]</td>
		<td style='width:60%;'>$r[Nama_matakuliah]  $mtkPilihan</td>     		         
		<td style='width: 10%;'>$r[SKS]</td>";
	$T11=$T11+$r[SKS];
	$jt11=number_format($T11,0,',','.');
	echo "</tr>";        
	}
    echo "<tfoot><tr>                            
		<td style='width: 65%;' colspan=4 ><b>TOTAL SKS :</b></td>
		<td style='width: 5%;'><b>$jt11</b></td>
		</tr></tfoot>";
	echo "</tbody></table></div>";
}
function TotalSks($id,$kode,$konsentrasi,$kur){
$prodi=($kode=='61101') ? 42:41;
$T11 = "0";

if($konsentrasi=='41'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.Kurikulum_ID IN ('41') AND t1.StatusMtk_ID='A' AND t1.JenisKurikulum_ID='$kur' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Kode_mtk,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
}elseif($konsentrasi=='40'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.Kurikulum_ID IN ($konsentrasi) AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B'AND t1.JenisKurikulum_ID='$kur' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Kode_mtk,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
}else{
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.Kurikulum_ID IN ($prodi,$konsentrasi) AND t1.StatusMtk_ID='A' AND t1.JenisKurikulum_ID='$kur' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Kode_mtk,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
}
return $T11;
}
//Tampilkan
global $tgl_sekarang;
echo"<page backtop='5mm' backbottom='0' backleft='2mm' backright='2mm' style='font-size: 10pt'>";
$id= $_SESSION['Identitas'];
$kons= $_GET['md'];
$kode= $_GET['id'];
$kur= $_GET['do'];
$NamaKonsentrasi=strtoupper(GetName("kurikulum","Kurikulum_ID",$kons,"Nama"));
$d = GetFields('jurusan', 'kode_jurusan', $kode, '*');
if($kode=='61101'){
HeaderPdf("DAFTAR MATAKULIAH : $d[nama_jurusan]","KONSENTRASI : $NamaKonsentrasi");
}else{
HeaderPdf("DAFTAR MATAKULIAH : $d[nama_jurusan]","KONSENTRASI : $NamaKonsentrasi");
}
echo"<br>";
$jumlahsemester= ($kode=='61101')? '4': '8';
echo"<table style='width: 100%; border: solid 1px #FFFFFF;'>";
$col=2;
echo"<tr>";
$cnt=0;
for ($num = 1; $num <= $jumlahsemester; $num++){
  if ($cnt >= $col) {
	echo "</tr><tr>";
	$cnt = 0;
  }
echo"<td style='width: 50%;  border: solid 1px #FFF;'>";
MatakuliahPerSemester($num,$id,$kode,$kons,$kur);
echo"</td>";
 $cnt++;
}
echo"</tr></table>";

$Ttot=TotalSks($id,$kode,$kons,$kur);
echo"<table class='month' style='width: 100%; color:#444;' cellspacing='5px'>
    <tr>
		
		<th class='fooot' style='width: 50%; border: solid 1px #EEE;text-align:left;'><strong><span style='color:#dc0000;'>***</span> Matakuliah Pilihan. <i>( Silahkan Pilih 6 SKS )</i></strong></th>

<th class='fooot' style='width: 50%; border: solid 1px #EEE;text-align:right;'>
<strong>TOTAL KREDIT : $Ttot SKS</strong>
</th>
    </tr>
	</table>";   
FooterPdf();
echo"</page>";
?>