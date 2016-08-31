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
div.special { margin: auto; width:90%; padding: 5px; }
div.special table { width:100%; font-size:10px; border-collapse:collapse; }
-->
</style>
<?php
function JadwalHarian($hari,$institusi,$jurusan,$program,$tahun,$sms){
$dina=strtoupper($hari);
echo"<table class='month' style='width: 100%; color:#444; border: 1px #eee;'>
	<thead>
		<tr><th style='width: 100%;' class='head' colspan=7><b>HARI $dina</b></th></tr> 
		<tr>
			<th style='width: 5%;'>NO</th>
			<th style='width: 10%;'>KODE</th>
			<th style='width: 20%;'>MATAKULIAH</th>
			<th style='width: 5%;'>SKS</th>
			<th style='width: 25%;'>DOSEN</th>
			<th style='width: 10%;'>WAKTU</th>
			<th style='width: 10%;'>RUANG</th>
		</tr>
	</thead>";
		$sql="SELECT * FROM jadwal WHERE Identitas_ID='$institusi' AND Kode_Jurusan='$jurusan' AND Program_ID='$program' AND Hari='$hari' AND Tahun_ID='$tahun' AND semester='$sms' ORDER BY Jadwal_ID";
		$qry= _query($sql)or die ();
		while ($r=_fetch_array($qry)){  
		$no++;
		$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
		$ruang=GetName("ruang","ID",$r[Ruang_ID],"Nama");
		$namaMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"Nama_matakuliah");
		$sksMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"SKS");
		$kelompokMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"KelompokMtk_ID");
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$kelompokMtk,"Nama");
		$dosen1=NamaDosen($r[Dosen_ID]);
		$dosen2=NamaDosen($r[Dosen_ID2]); 
		echo "<tr>                            
			<td>$no</td>
			<td>$kelompok - $r[Kode_Mtk]</td>
			<td valign='middle'>$namaMtk</td>
			<td>$sksMtk</td>
			<td>1- $dosen1 <br>2- $dosen2</td>
			<td>$r[Jam_Mulai] - $r[Jam_Selesai]</td>
			<td>$ruang</td>                  
		</tr>";        
	}
echo"</table>";
}
//Tampilkan
global $tgl_sekarang;
echo"<page backtop='37mm' backbottom='0' backleft='2mm' backright='2mm' style='font-size: 10pt'>";
$institusi	=$_SESSION[Identitas];
$jurusan	=$_GET[jurusan];
$program	=$_GET[program];
$tahun		=$_GET[tahun];
$sms		=$_GET[semester];
$TglSkrang	= tgl_indo(date("Y m d"));
$PRODI=NamaProdi($jurusan);
$kelas=NamaKelasa($program);
$semest=namaSemester($sms);
$TA=TahunID($tahun);
if($jurusan=='61101'){
HeaderS2();
}else{
HeaderS1($PRODI);
}
echo"<table style='width: 100%; font-weight: bold;text-align:center;color:#213699;'>
        <tr>
            <td style='width: 50%; border: solid 1px #EEE; background-color:#fcfcfc;'>JADWAL KULIAH SEMESTER $semest ( $sms )</td>
            <td style='width: 50%; border: solid 1px #EEE; background-color:#fcfcfc;'>PROGRAM STUDI $PRODI</td>
        </tr>
		<tr>
            <td style='width: 50%; border: solid 1px #EEE; background-color:#fcfcfc;'>$TA</td>
            <td style='width: 50%; border: solid 1px #EEE; background-color:#fcfcfc;'>KELAS $kelas</td>
        </tr>
    </table><br>";
JadwalHarian("Senin",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Selasa",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Rabu",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Kamis",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Jumat",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Sabtu",$institusi,$jurusan,$program,$tahun,$sms);	

$Puket1=GetName("karyawan","Jabatan",20,"nama_lengkap");
echo"<br><br><br><table style='width: 100%;color:#444;font-weight: bold;'>
            <tr>
                <td style='width: 60%; text-align:left;border-bottom:1px dashed #000000'>Surabaya, $TglSkrang</td>
				 <td style='width:40%;border-bottom:1px dashed #000000; text-align:center;'>PEMBANTU KETUA I</td>
            </tr>
            <tr>
                <td style='width:60%;text-align:left;'> </td>
                <td style='width: 40%; text-align:center;vertical-align:top;'><br><br><br><br><br>( $Puket1 )</td>
            </tr>
        </table>";  
FooterPdf();
echo"</page>";
?>