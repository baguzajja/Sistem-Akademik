<html>
<head>
 <title>Cetak - Jadwal kuliah</title>
<?php 
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
include "printer.css"; 
include "../librari/koneksi.php";
if (!empty($_GET['tahun']) AND !empty($_GET[prog]) AND !empty($_GET[codd])){ ?> 
<style type="text/css">
.style4 {font-size: 12; }
.style7 {	font-size: 12;
	color: #265180;
	font-family: Georgia, "Times New Roman", Times, serif;
}
</style>
</head> 
<BODY onLoad="javascript:window.print()">
  <?php  
  $sql="SELECT Nama FROM tahun WHERE Tahun_ID='$_GET[tahun]' AND Program_ID='$_GET[prog]' AND Jurusan_ID='$_GET[kode]'";
  $no=0;
  $qry=mysql_query($sql)
  or die ();
  while($t=mysql_fetch_array($qry)){
  $no++;
  ?>
<table class="basic" width="550" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="550" align="center"><strong>UNIVERSITAS PUTRA INDONESIA &quot;YPTK&quot;</strong></td>
  </tr>
  <tr>
    <td align="center">DAFTAR JADWAL PERKULIAHAN <?php echo $t['Nama']; ?></td>
  </tr>
  <?
  }
  ?>
</table>
<br><br>
<table  width="800" id=tablemodul>
  <?php  
  $sql="SELECT t2.Program_ID,t2.nama_program,t3.Kode_Jurusan,t3.nama_jurusan,t4.Nama,t4.Tahun_ID 
  FROM jadwal t1,program t2,jurusan t3,tahun t4 
  WHERE t2.ID=t1.Program_ID AND t2.ID='$_GET[prog]' AND t3.Kode_Jurusan='$_GET[codd]' AND t1.Tahun_ID=t4.ID";
  $no=0;
  $qry=mysql_query($sql)
  or die ();
  while($data=mysql_fetch_array($qry)){
  $no++;
  ?>
    <tr>
      <td width="120" class=basic>Program</td>
      <td width="417" class=basic><strong>: <?php echo $data['Program_ID']; ?> - <?php echo $data['nama_program']; ?></td>
      <td width="53" class=basic>Tanggal</td>
      <td width="191" class=basic> <strong>: <?php echo $tgl_sekarang = date("d-m-Y"); ?></td>
	</tr>
    <tr>
      <td class=basic>Program Studi</td>
      <td class=basic><strong>: <?php echo $data['Kode_Jurusan']; ?> - <?php echo $data['nama_jurusan']; ?></td>
      <td class=basic>Semester</td>
      <td class=basic><strong>: <?php echo $data['Nama']; ?> /  <?php echo $data['Tahun_ID']; ?></td>
    </tr>
  </table>

<table id=tablemodul1>
      <tr bgcolor="#CCCCCC">
        <th class=basic>Hari</th>
        <th class=basic>Jam</th>
        <th class=basic>Kode Mtk</th>
        <th class=basic>Matakuliah</th>
        <th class=basic>Dosen</th>
        <th class=basic>Kelas</th>
         <th class=basic>Ruang</th>
      </tr>

        <?php  
  $sql="SELECT t1.*
  FROM view_jadwal t1,hari t3 
  WHERE t3.hari=t1.Hari AND  
  t1.Tahun_ID='$_GET[tahun]' AND 
  t1.Identitas_ID='$_GET[ID]' AND 
  t1.Kode_Jurusan='$_GET[codd]' AND 
  t1.Program_ID='$_GET[prog]' 
  ORDER BY t1.Kelas,t3.id";
  $no=0;
  $qry=mysql_query($sql)
  or die ();
  while($data=mysql_fetch_array($qry)){
  $no++;
  ?>   
      <tr valign="top">
        <td class=basic><?php echo $data['Hari']; ?>
          </td>
        <td class=basic><?php echo $data['Jam_Mulai']; ?> - <?php echo $data['Jam_Selesai']; ?>
          </td>
        <td class=basic><span class="style4">
          <?php echo $data['Kode_Mtk']; ?>
        </span></td>
        <td class=basic><span class="style4">
          <?php echo $data['Nama_matakuliah']; ?>
        </span></td>
        <td class=basic><span class="style4">
          <?php echo $data['nama_lengkap']; ?>,<?php echo $data['Gelar']; ?>
        </span></td>
        <td class=basic><span class="style4">
          <?php echo $data['Kelas']; ?>
        </span></td>
        <td class=basic><span class="style4">
          <?php echo $data['NR']; ?>
        </span></td>
      </tr>
        <?php
  }
  ?>
          <?php
  }
  ?>
</table>
<table width="1060">
  
      <tr valign="top">
        <td align="center" class=basic><p>Ketua Jurusan</p>
        <p>&nbsp;</p>
        <p>()</p></td>

  </tr>

</table>

<?php }else{?>
<table class="basic" width="550" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="550" align="center"><strong>Anda Belum Menentukan Tahun dan Program Studi</strong></td>
  </tr>
</table>  
 <?php } ?>
</body>
</html>
