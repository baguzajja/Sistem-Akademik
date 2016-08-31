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
    padding:2px;
    text-align:left;
}

table.month th {
    padding:2px;
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
global $tgl_sekarang,$TahunIni,$BulanIni;
$nim	=$_GET[md];
$prodi	=$_GET[id];
$getNim	=substr($nim,-3);
$getBr	=getBulanRomawi($BulanIni);
$PRODI=NamaProdi($prodi);
if($prodi=='61101'){
HeaderS2();
}else{
HeaderS1($PRODI);
}
$Kons=($prodi=='61101') ? 42:41; 
$w = GetFields('mahasiswa', 'NIM', $nim, '*');
$tglLahir=tgl_indo($w[TanggalLahir]);
$konsentrasi=strtoupper(NamaKonsentrasi($w[Kurikulum_ID]));
$TglSkrang	= tgl_indo(date("Y m d"));
echo"
<table style='width: 100%; font-weight: bold;color:#213699; cellpadding:2px;'>
 <tr>
            <th colspan='3' style='width: 100%; text-align:center;'>TRANSKRIP SEMENTARA</th>
        </tr>
<tr>
			<th style='width: 35%;'>&nbsp;</th>
			<th style='width: 30%; border: solid 1px #EEE; background-color:#fff; text-align:center;'><b style='text-align:left;'>NO : T &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</b><b style='text-align:right;'>- $getNim/STY-TS/ &nbsp;&nbsp; /$TahunIni  </b></th>
			<th style='width: 35%;'>&nbsp;</th>
		</tr>
</table>
<table style='width: 100%; font-weight: bold;color:#213699; cellpadding:2px; font-size: 8pt;'>
		
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>NAMA</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>$w[Nama]</td>

            <td style='width: 20%;'>&nbsp;</td>

			<td style='width: 15%;'> </td>
			<td style='width: 5%;></td>
			<td style='width: 20%;'></td>
        </tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>NIM</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>$w[NIM]</td>

            <td style='width: 20%;'>&nbsp;</td>
			<td colspan='3' style='; border: solid 1px #EEE; background-color:#fcfcfc; text-align:center;'>PROGRAM STUDI $PRODI</td>
			
        </tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>TTL</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>$tglLahir</td>

            <td style='width: 20%;'>&nbsp;</td>

			<td colspan='3' style='width:; border: solid 1px #EEE; background-color:#fcfcfc; text-align:center;'>KONSENTRASI $konsentrasi</td>
			
        </tr>
<tr><th colspan='7' style='width: 100%;'>&nbsp;</th></tr>
    </table>";

echo"<table style='width: 100%; border: solid 1px #FFFFFF;'>";
$col=31;
$no=1;
$nfo=1;
echo"<tr><td style='width: 50%;  border: solid 1px #FFF;'>
	<table class='month' style='width: 100%; color:#444; border: 1px #eee; font-size: 9pt;'>
      <tr bgcolor='#CCCCCC'>
       <th style='width: 5%; text-align: center;'>NO</th>
        <th style='width: 20%; text-align: center;' colspan='2'>KODE MK</th>
        <th style='width: 50%; text-align: center;'> MATA KULIAH</th>
		<th style='width: 5%; text-align: center;'>S</th>
        <th style='width: 5%; text-align: center;'>N</th>
        <th style='width: 5%; text-align: center;'>B</th>
      </tr>";
 $sql="SELECT * FROM matakuliah WHERE Identitas_ID='$_SESSION[Identitas]' AND Jurusan_ID='$w[kode_jurusan]' AND Kurikulum_ID IN ($Kons,$w[Kurikulum_ID]) ORDER BY Semester, Matakuliah_ID";
  $qry=mysql_query($sql) or die ();
  while($data=mysql_fetch_array($qry))
  {
$sqlr="SELECT * FROM krs WHERE NIM='$nim' AND Jadwal_ID='$data[Matakuliah_ID]' AND GradeNilai!='-'";
$qryr= mysql_query($sqlr);
$data1=mysql_fetch_array($qryr);
$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$data['KelompokMtk_ID'],"Nama");   
$boboxtsks=$data['SKS']*$data1['BobotNilai'];
if ($boboxtsks!=0)
{
$ipSks= ($boboxtsks==0)? 0: $data['SKS'];
$Totsks=$Totsks+$ipSks;
$TotSks=$TotSks+$data['SKS'];
$jmlbobot=$jmlbobot+$boboxtsks;
$bobot=$data1['BobotNilai'];
  if ($nfo >= $col) {
	echo "</table></td><td style='width: 50%;  border: solid 1px #FFF;float:right'>
	<table class='month' style='width: 100%; color:#444; border: 1px #eee; font-size: 9pt;'>
      <tr bgcolor='#CCCCCC'>
        <th style='width: 5%; text-align: center;'>NO</th>
        <th style='width: 20%; text-align: center;' colspan='2'>KODE MK</th>
        <th style='width: 50%; text-align: center;'> MATA KULIAH</th>
        <th style='width: 5%; text-align: center;'>S</th>
        <th style='width: 5%; text-align: center;'>N</th>
        <th style='width: 5%; text-align: center;'>B</th>
      </tr>";
	$nfo=0;
  }
echo"<tr valign='top'><td>$no</td>
	<td>$kelompok</td>
	<td>$data[Kode_mtk]</td>
	<td class=basic><span class=style4>$data[Nama_matakuliah]</span></td>
	<td style='text-align: center;'>$data[SKS] </td>
	<td style='text-align: center;'>$data1[GradeNilai]</td>
	<td style='text-align: center;'>$boboxtsks</td></tr>";
 $nfo++;
 $no++;
}
}
$totalSKS=number_format($TotSks,0,',','.');
$ipk=$jmlbobot/$Totsks;
$Ipke=number_format($ipk,2,',','.');
$JumlahBBt=number_format($jmlbobot,0,',','.');	
echo"<tr><td colspan='7'>&nbsp;&nbsp;</td></tr>
<tfoot>
<tr>
	<td colspan='4'><b>TOTAL KREDIT</b></td>
	<td colspan='2'><b>$totalSKS SKS</b></td>
	<td><b>$JumlahBBt</b></td>
</tr>
<tr>
	<td colspan='4'><b>INDEKS PRESTASI KUMULATIF (IPK)</b></td>
	<td colspan='3'><b align='right'>$Ipke</b></td>
</tr>
</tfoot>";
echo"</table>";
echo"</td></tr></table>";

$Puket1=GetName("karyawan","Jabatan",20,"nama_lengkap");
echo"<br><br><br><table style='width: 100%;color:#444;font-weight: bold;'>
            <tr>
                <td style='width: 40%; text-align:left;border-bottom:1px dashed #444;'> Surabaya,   </td>
				<td style='width:20%;border-bottom:1px dashed #000000;'></td>
				 <td style='width:40%;border-bottom:1px dashed #000000; text-align:center;'>PEMBANTU KETUA I</td>
            </tr>
            <tr>
                <td style='width:40%;text-align:left;text-align:center;vertical-align:top;'></td>
                <td style='width:20%;'></td>
                <td style='width: 40%; text-align:center;vertical-align:top;'><br><br><br><br><br>( $Puket1 )</td>
            </tr>
        </table>";  
FooterPdfCode($w['NIM']);
echo"</page>";
?>