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

$tahun		=$_GET[tahun];
$semester	=$_GET[semester];
$nim		=$_GET[nim];
$TglSkrang	= tgl_indo(date("Y m d"));
$d 		= GetFields('mahasiswa', 'NIM', $nim, '*');

$prodi=NamaProdi($d[kode_jurusan]);
$kelas=NamaKelasa($program);
$namaSemester=namaSemester($semester);
$pembimbingAkademik=NamaDosen($d[PenasehatAkademik]);
$NamaTahun=TahunID($tahun);
if($d[kode_jurusan]=='61101'){
HeaderS2();
}else{
HeaderS1($prodi);
}
echo"<table style='width: 100%; font-weight: bold;color:#213699; cellpadding:2px;'>
        <tr>
            <th colspan='7' style='width: 100%; text-align:center;'>KARTU HASIL STUDI (KHS)</th>
        </tr>
		<tr><th colspan='7' style='width: 100%;'>&nbsp;</th></tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;NAMA</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;$d[Nama]</td>

            <td style='width: 20%;'>&nbsp;</td>

			<td style='width: 15%;'> </td>
			<td style='width: 5%;></td>
			<td style='width: 20%;'></td>
        </tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;NIM</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;$d[NIM]</td>

            <td style='width: 20%;'>&nbsp;</td>
			<td colspan='3' style='; border: solid 1px #EEE; background-color:#fcfcfc; text-align:center;'>$NamaTahun</td>
			
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
	<tr>
		<th style='width: 5%;'>NO</th>
		<th style='width: 15%;'>KODE</th>
		<th style='width: 35%;'>MATAKULIAH</th>
		<th style='width: 10%;'>KREDIT</th>
		<th style='width: 10%;'>NILAI</th>
		<th style='width: 10%;'>BOBOT</th>
		<th style='width: 15%;'>BOBOT*SKS</th>
	</tr>";  
	$sql="SELECT * FROM krs WHERE Tahun_ID='$tahun' AND NIM='$nim' AND semester='$semester' ORDER BY KRS_ID";
	$no=0;
	$qry=_query($sql) or die ();
	while($data=_fetch_array($qry)){
	$mtk = GetFields('matakuliah', 'Matakuliah_ID', $data[Jadwal_ID], '*');
	$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$mtk[KelompokMtk_ID],"Nama");
	$ipSks= ($data[GradeNilai]=='-')? 0: $data[SKS];
	$no++;
  echo"<tr>
		<td> $no</td>
		<td>$kelompok - $mtk[Kode_mtk]</td>
		<td>$mtk[Nama_matakuliah]</td>
		<td>$data[SKS] SKS</td>";
		$Totsks=$Totsks+$ipSks;
		$Tot=$Tot+$data[SKS];
      echo" <td>$data[GradeNilai]</td>
            <td>$data[BobotNilai]</td>";
            $boboxtsks=$data[SKS]*$data[BobotNilai];
            $jmlbobot=$jmlbobot+$boboxtsks;
            $ips=$jmlbobot/$Totsks;
     echo " <td>$boboxtsks</td>   
            </tr>";
  }
$totalSKS=number_format($Tot,0,',','.');
$totalBOBOT=number_format($jmlbobot,0,',','.');
$Ips=number_format($ips,2,',','.');
  echo"<tr> <td colspan=3><b>Jumlah Kredit Yang di tempuh</b></td>
		<td><b>$totalSKS SKS</b></td>
		<td colspan=2></td>
		<td><b>$totalBOBOT</b></td></tr>";
  echo"<tfoot>
        <tr>
			<td colspan='3' style='color: #213699; background-color:#fcfcfc;'><b>Index Prestasi (IP) Semester </b></td>
			<td colspan='4' style='color: #213699; text-align: center; background-color:#fcfcfc;'><b>$Ips</b></td>
		</tr>";
		if($ips !=''){
        $sql="SELECT t2.MaxSKS AS sks FROM master_nilai t2 WHERE (t2.ipmax >=$ips) AND (t2.ipmin <=$ips)";
        $no=0;
        $qry=_query($sql) or die;
        while($w=_fetch_array($qry)){
        echo"<tr>
				<td colspan='3'> Jumlah Kredit Yang dapat ditempuh  </td>
				<td colspan='4'><b>$w[sks]</b></td>
			</tr>";
			}
		}
  echo" </tfoot></table>";
$Kaprodi=_fetch_array(_query("SELECT * FROM karyawan WHERE Jabatan='18' AND kode_jurusan='$d[kode_jurusan]'"));
echo"<br><br><br><table style='width: 100%;color:#444;font-weight: bold;'>
            <tr>
                <td style='width: 40%; text-align:left;border-bottom:1px dashed #444;'> Surabaya, $TglSkrang</td>
				<td style='width:20%;border-bottom:1px dashed #000000;'></td>
				 <td style='width:40%;border-bottom:1px dashed #000000; text-align:center;'>KA PRODI $prodi</td>
            </tr>
            <tr>
                <td style='width:40%;text-align:left;text-align:center;vertical-align:top;'></td>
                <td style='width:20%;'></td>
                <td style='width: 40%; text-align:center;vertical-align:top;'><br><br><br><br><br>( $Kaprodi[nama_lengkap] )</td>
            </tr>
        </table>";  
FooterPdf();
echo"</page>";
?>