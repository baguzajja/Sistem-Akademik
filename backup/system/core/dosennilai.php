    <script language="javascript" type="text/javascript">
    <!--
    function MM_jumpMenu(targ,selObj,restore){// v3.0
     eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
    if (restore) selObj.selectedIndex=0;
    }
    //-->
    </script>
<?php 
function defdosennilai(){
buka("Input Nilai Mahasiswa");
  echo"<table class='table table-bordered table-striped'><thead>
	<tr><th>NO</th><th>PRODI</th><th>KODE</th><th>MTK</th><th>SKS</th><th>SMSTR</th><th>KELAS</th><th>Hari</th><th>Mulai</th><th>Selesai</th><th>Dosen</th></tr></thead>";  
	$sql="SELECT * FROM view_ajar_dosen WHERE username='$_SESSION[yapane]' ORDER BY Kode_Mtk";
	$no=0;
	$qry=mysql_query($sql) or die ();
	while($data=mysql_fetch_array($qry)){
	$no++;
    echo" <tr><td>$no</td>
		<td>$data[nama_jurusan]</td>
		<td><a class=s href='get-dosennilai-inputnilai-$data[Jadwal_ID].html'>$data[Kode_Mtk]</a></td>
		<td>$data[nama_matakuliah]</td>
		<td align=center>$data[sks]</td>
		<td align=center>$data[semester]</td>
		<td align=center>$data[Kelas]</td>
		<td>$data[Hari]</td>
		<td align=center>$data[Jam_Mulai]</td>
		<td align=center>$data[Jam_Selesai]</td>
		<td>$data[nama_lengkap], $data[gelar]</td>
		</tr>";
            }
  echo"</table>";
tutup();
}
function inputnilai(){
buka("Input Nilai Mahasiswa");
	$edit=mysql_query("SELECT * FROM dosen WHERE username='$_SESSION[yapane]'");
    $a=mysql_fetch_array($edit); 
    echo"<table class='table table-bordered table-striped'><thead> 
		<tr><th>NO</th><th>PRODI</th><th>KODE</th><th>MTK</th><th>SKS</th><th>SMSTR</th><th>KELAS</th><th>Hari</th><th>Mulai</th><th>Selesai</th><th>Dosen</th></tr></thead> ";  
		$sql="SELECT * FROM view_ajar_dosen WHERE Jadwal_ID='$_GET[id]' ORDER BY Kode_Mtk";
		$no=0;
		$qry=mysql_query($sql) or die ();
		while($data=mysql_fetch_array($qry)){
		$no++;
        echo"<tr><td>$no</td>
			<td>$data[nama_jurusan]</td>
			<td>$data[Kode_Mtk]</td>
			<td>$data[nama_matakuliah]</td>
			<td align=center>$data[sks]</td>
			<td align=center>$data[semester]</td>
			<td align=center>$data[Kelas]</td>
			<td>$data[Hari]</td>
			<td align=center>$data[Jam_Mulai]</td>
			<td align=center>$data[Jam_Selesai]</td>
			<td>$data[nama_lengkap], $data[gelar]</td>
			</tr>";
            }
      echo"</table>";     
            $d=mysql_query("SELECT * FROM view_jadwal WHERE Jadwal_ID='$_GET[id]' ORDER BY Jadwal_ID");
            $r=mysql_fetch_array($d); 
          echo" <p> <a class='btn btn-danger pull-right' href='go-dosennilai.html'><i class='icon-undo'></i> Kembali Ke Dafar Mtk </a></p>";
          echo"<table class='table table-bordered table-striped'><thead> 
                  <tr><th>No</th><th>NIM</th><th>Nama Mahasiswa</th><th>Grade</th></tr></thead> ";     								
                $sql="SELECT * FROM krs1 
                WHERE idjdwl='$_GET[id]' ORDER BY NIM";
              	$qry= mysql_query($sql)
              	or die ();
              	while ($r1=mysql_fetch_array($qry)){         	
              	$nom++;
                   echo "<tr bgcolor=$warna>                            
            		         <td>$nom</td>
            		         <td>$r1[NIM]</td>
            		         <td>$r1[nama_lengkap]</td>";
                         ?>                   
                          <td colspan=2> 
						  <select name="nilai" onChange="MM_jumpMenu('parent',this,0)">
                          <option value="">- Nilai -</option>
                          <?php
                      	  $sqlp="SELECT * FROM nilai WHERE Identitas_ID='$a[Identitas_ID]' AND Kode_Jurusan='$a[jurusan_ID]'";
                      	  $qryp=mysql_query($sqlp)
                      	  or die();
                      	  while ($d2=mysql_fetch_array($qryp)){
                          if ($d2['grade']==$r1['GradeNilai']){
                            $cek="selected";
                            }
                            else{
                              $cek="";
                            }
                            echo "<option value='nil-dosennilai-simpannilai-$d2[grade]-$d2[bobot]-$r1[id]-$_GET[id].html' $cek> $d2[grade]--> $d2[NilaiMin]-$d2[NilaiMax]</option>";
                      		}
                      		?>
                            </select></td>                                          
                            <?
                   echo" </tr>";        
                        }
      
          echo"</table></div>";
tutup();
}
switch($_GET[PHPIdSession]){

  default: 
defdosennilai();
  break;  

  case"inputnilai":
inputnilai();   
  break;
  
  case"simpannilai":
$nama_tabel="krs";
$values="GradeNilai='$_GET[id]',BobotNilai='$_GET[codd]'";
$kondisi="KRS_ID='$_GET[kode]'";
$ok=update($nama_tabel,$values,$kondisi);
lompat_ke('get-dosennilai-inputnilai-'.$_GET['ids'].'.html');
  break;  
}
?>
