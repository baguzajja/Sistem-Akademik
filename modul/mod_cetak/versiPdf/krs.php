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
//Tampilkan
global $tgl_sekarang;
echo"<page backtop='37mm' backbottom='0' backleft='2mm' backright='2mm' style='font-size: 10pt'>";

$tahun		=$_GET['md'];
$semester	=$_GET['id'];
$nim		=$_GET['do'];
$TglSkrang	= tgl_indo(date("Y m d"));
$data 		= GetFields('mahasiswa', 'NIM', $nim, '*');

$prodi=NamaProdi($data[kode_jurusan]);
$kelas=NamaKelasa($program);
$namaSemester=namaSemester($semester);
$pembimbingAkademik=NamaDosen($data[PenasehatAkademik]);
$NamaTahun=TahunID($tahun);
if($data[kode_jurusan]=='61101'){
HeaderS2();
}else{
HeaderS1($prodi);
}
echo"<table style='width: 100%; font-weight: bold;color:#213699; cellpadding:2px;'>
        <tr>
            <th colspan='7' style='width: 100%; text-align:center;'>KARTU RENCANA STUDI (KRS)</th>
        </tr>
		<tr><th colspan='7' style='width: 100%;'>&nbsp;</th></tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;NAMA</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;$data[Nama]</td>

            <td style='width: 20%;'>&nbsp;</td>

			<td style='width: 15%;'> </td>
			<td style='width: 5%;></td>
			<td style='width: 20%;'></td>
        </tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;NIM</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;$data[NIM]</td>

            <td style='width: 20%;'>&nbsp;</td>
			<td colspan='3' style=' width:; border: solid 1px #EEE; background-color:#fcfcfc; text-align:center;'>$NamaTahun</td>
			
        </tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;PRODI</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp; $prodi</td>

            <td style='width: 20%;'>&nbsp;</td>
			<td colspan='3' style='width:; border: solid 1px #EEE; background-color:#fcfcfc; text-align:center;'>SEMESTER $namaSemester ( $semester )</td>
			
        </tr>
    </table><br>";
echo"<table class='month' style='width: 100%; color:#444; border: 1px #eee;'>
<thead>
	<tr>
		<th style='width: 10%;'>NO</th>
		<th style='width: 20%;'>KODE</th>
		<th style='width: 60%;'>MATAKULIAH</th>
		<th style='width: 10%;'>KREDIT</th>
	</tr></thead>";
	$sql="SELECT * FROM krs WHERE Tahun_ID='$tahun' AND NIM='$nim' AND semester='$semester' ORDER BY KRS_ID";
	$no=0;
	$qry=_query($sql) or die ();
	while($data2=_fetch_array($qry)){
	$no++;
	$ruang=GetName("ruang","ID",$data[Ruang_ID],"Nama");
		$mtk=GetFields("matakuliah","Matakuliah_ID",$data2[Jadwal_ID],"*");
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$mtk[KelompokMtk_ID],"Nama"); 
	echo "<tr>
		<td align=center> $no</td>          
		<td>$kelompok - $mtk[Kode_mtk]</td>
		<td>$mtk[Nama_matakuliah]</td>
		<td>$mtk[SKS] SKS</td>
	</tr>";
$Tot=$Tot+$mtk[SKS];
}
echo"<tfoot>
		<tr>
			<td valign=top colspan=3><b>TOTAL KREDIT</b></td>
			<td valign=top><b>$Tot SKS</b></td>
		</tr>
	</tfoot></table>";
$Kaprodi=_fetch_array(_query("SELECT * FROM karyawan WHERE Jabatan='18' AND kode_jurusan='$data[kode_jurusan]'"));
echo"<br><br><br><table style='width: 100%;color:#444;font-weight: bold;'>
            <tr>
                <td style='width: 40%; text-align:left;border-bottom:1px dashed #000000;text-align:center;'> Mengetahui, <br> Dosen Wali </td>
				<td style='width:20%;border-bottom:1px dashed #000000;'></td>
				 <td style='width:40%;border-bottom:1px dashed #000000; text-align:left;'>Surabaya, <br>KA PRODI $prodi</td>
            </tr>
            <tr>
                <td style='width:40%;text-align:left;text-align:center;vertical-align:top;'> <br><br><br><br><br>( $pembimbingAkademik )</td>
                <td style='width:20%;'></td>
                <td style='width: 40%; text-align:center;vertical-align:top;'><br><br><br><br><br>( $Kaprodi[nama_lengkap] )</td>
            </tr>
        </table>";  
FooterPdf();
echo"</page>";
?>