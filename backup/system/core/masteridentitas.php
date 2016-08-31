<?php
function defaultIdenUniv(){
buka("Identitas Institusi");
echo"<div class='row'><p class='pull-right'><a class='btn btn-success' href='aksi-masteridentitas-tambahidentitas.html'>Tambah Institusi</a></p> </div>
    <table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
	<thead><tr><th>No</th><th>Kode</th><th>Nama</th><th></th></tr></thead><tbody>"; 
      $sql="SELECT * FROM identitas ORDER BY Identitas_ID";
      $qry= mysql_query($sql)
      or die ();
      while ($r=mysql_fetch_array($qry)){ 
      $no++;
echo"<tr><td>$no</td>
	<td>$r[Identitas_ID]</td>
	<td>$r[Nama_Identitas]</td>
	<td width='20%'>
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini btn-inverse' href='get-masteridentitas-edit-$r[ID].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='get-masteridentitas-HapusIdntUniv-$r[ID].html' onClick=\"return confirm('Anda yakin akan Menghapus data Institusi $r[Identitas_ID] ?')\">Hapus</a>
			</div>
		</center>
	</td></tr>";        
                             } 
echo"</tbody></table>";
tutup();      
}

function tambahidentitas(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("Tambah Institusi");
echo"<form action='aksi-masteridentitas-InputIdntUniv.html' method='post'>
    <table class='table table-bordered table-striped'><thead>
    <tr><td class=cc>Kode</td>       <td><input type=text name='Kode'></td></tr>                  
    <tr><td class=cc>Kode Hukum</td>       <td><input type=text name='KodeHukum'></td></tr>
    <tr><td class=cc>Nama</td>     <td><input type=text name=Nama size=50></td></tr>
    <tr><td class=cc>Tanggal Mulai</td>   <td>";
		combotgl(1,31,'tgl_mulai',$today);
		combonamabln(1,12,'bln_mulai',$BulanIni);
		combothn($TahunIni-100,$TahunIni+10,'thn_mulai',$TahunIni);
    echo"</td></tr>
    <tr><td class=cc>Alamat 1</td>          <td><input type=text name='Alamat1' size=50></td></tr>
    <tr><td class=cc>Kota</td>        <td><input type=text name='Kota'></td></tr>
    <tr><td class=cc>Kode pos</td>        <td><input type=text name='KodePos'></td></tr>
    <tr><td class=cc>Telepon</td>        <td><input type=text name='Telepon'></td></tr>
    <tr><td class=cc>Fax</td>        <td><input type=text name='Fax'></td></tr>
    <tr><td class=cc>Email</td>        <td><input type=text name='Email'></td></tr>
    <tr><td class=cc>Website</td>        <td><input type=text name='Website'></td></tr>
    <tr><td class=cc>No.Akta</td>        <td><input type=text name='NoAkta'></td></tr>
    <tr><td class=cc>Tanggal Akta</td>        <td>";
		combotgl(1,31,'tgl_akta',$today);
		combonamabln(1,12,'bln_akta',$BulanIni);
		combothn($TahunIni-100,$TahunIni+10,'thn_akta',$TahunIni);
    echo"</td></tr>
    <tr><td class=cc>No. Pengesahan</td>        <td><input type=text name='NoSah'></td></tr>
    <tr><td class=cc>Tanggal Pengesahan</td><td>";
		combotgl(1,31,'tgl_sah',$today);
		combonamabln(1,12,'bln_sah',$BulanIni);
		combothn($TahunIni-100,$TahunIni+10,'thn_sah',$TahunIni);
    echo"</td></tr>";
    if ($r[Aktif]=='Y'){
    echo "<tr><td class=cc>Aktif</td> <td>  <input type=radio name='NA' value='Y' checked>Y  
    <input type=radio name='NA' value='N'> N</td></tr>";
    }else{
    echo "<tr><td class=cc>Aktif</td> <td>  <input type=radio name='NA' value='Y'>Y  
                                      <input type=radio name='NA' value='N' checked>N</td></tr>";
    }
    echo"<tr><td colspan=2>
	<center>
			<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Update>
				<a class='btn btn-small btn-danger' href='go-masteridentitas.html'>Batal</a>
			</div>
	</center>
    </td></tr></thead></table></form>";
tutup();
}

function editidentitas(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("Edit Institusi");
    $edit = mysql_query("SELECT * FROM identitas WHERE ID='$_GET[id]' ORDER BY Identitas_ID");
    $r    = mysql_fetch_array($edit);
echo"<div id=groupmodul1>
    <form action='aksi-masteridentitas-UpdateIdntUniv.html' method='post'>
    <table class='table table-bordered table-striped'><thead>
    <input type=hidden name='ID' value='$r[ID]'>
    <tr><td class=cc>Kode</td>
	<td><input type=text name='Kode' value='$r[Identitas_ID]'></td></tr>                  
    <tr><td class=cc>Kode Hukum</td>
	<td><input type=text name='KodeHukum' value='$r[KodeHukum]'></td></tr>
    <tr><td class=cc>Nama</td>
	<td><div class='row-fluid'><input type=text name=Nama class='span12' value='$r[Nama_Identitas]'></div></td></tr>
    <tr><td class=cc>Tanggal Mulai</td><td><div class='row-fluid'>";
	
		$get_tgl2=substr("$r[TglMulai]",8,2);
		combotgl(1,31,'TglMulai',$get_tgl2);
        $get_bln2=substr("$r[TglMulai]",5,2);
        combonamabln(1,12,'bln_mulai',$get_bln2);
        $get_thn2=substr("$r[TglMulai]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thn_mulai',$get_thn2);
		
    echo"</div></td></tr>
    <tr><td class=cc>Alamat</td>
	<td><div class='row-fluid'><input type=text name='Alamat1' value='$r[Alamat1]' class='span12'></div></td></tr>
    <tr><td class=cc>Kota</td>
	<td><input type=text name='Kota' value='$r[Kota]'></td></tr>
    <tr><td class=cc>Kode pos</td>
	<td><input type=text name='KodePos' value='$r[KodePos]'></td></tr>
    <tr><td class=cc>Telepon</td>
	<td><input type=text name='Telepon' value='$r[Telepon]'></td></tr>
    <tr><td class=cc>Fax</td>
	<td><input type=text name='Fax' value='$r[Fax]'></td></tr>
    <tr><td class=cc>Email</td>
	<td><input type=text name='Email' value='$r[Email]'></td></tr>
    <tr><td class=cc>Website</td>
	<td><input type=text name='Website' value='$r[Website]'></td></tr>
    <tr><td class=cc>No.Akta</td>
	<td><input type=text name='NoAkta' value='$r[NoAkta]'></td></tr>
    <tr><td class=cc>Tanggal Akta</td>        <td><div class='row-fluid'>";
		$get_tgl2=substr("$r[TglAkta]",8,2);
		combotgl(1,31,'TglAkta',$get_tgl2);
        $get_bln2=substr("$r[TglAkta]",5,2);
        combonamabln(1,12,'bln_akta',$get_bln2);
        $get_thn2=substr("$r[TglAkta]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thn_akta',$get_thn2);
        echo"</div></td></tr>
    <tr><td class=cc>No. Pengesahan</td>        <td><input type=text name='NoSah' value='$r[NoSah]'></td></tr>
    <tr><td class=cc>Tanggal Pengesahan</td><td><div class='row-fluid'>";
		$get_tgl2=substr("$r[TglSah]",8,2);
		combotgl(1,31,'TglSah',$get_tgl2);
        $get_bln2=substr("$r[TglSah]",5,2);
        combonamabln(1,12,'bln_sah',$get_bln2);
        $get_thn2=substr("$r[TglSah]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thn_sah',$get_thn2);
    echo"</div></td></tr>";
    if ($r[Aktif]=='Y'){
    echo "<tr><td class=cc>Aktif</td> <td> <input type=radio name='NA' value='Y' checked>Y  
    <input type=radio name='NA' value='N'> N</td></tr>";
    }else{
    echo "<tr><td class=cc>Aktif</td> <td> <input type=radio name='NA' value='Y'>Y  
                                      <input type=radio name='NA' value='N' checked>N</td></tr>";
    }
    echo"<tr><td colspan=2>
	<center>
			<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Update>
				<a class='btn btn-small btn-danger' href='go-masteridentitas.html'>Batal</a>
			</div>
	</center>
	</td></tr>
	</thead></table></form>";
tutup();
}
switch($_GET[PHPIdSession]){

  default:
    defaultIdenUniv();
  break;  
	  
  case "edit":
    editidentitas();
  break;

  case "tambahidentitas":
    tambahidentitas();
   break;
       
  case"InputIdntUniv":
        $TglMulai=sprintf("%02d%02d%02d",$_POST[thn_mulai],$_POST[bln_mulai],$_POST[tgl_mulai]);
        $TglAkta=sprintf("%02d%02d%02d",$_POST[thn_akta],$_POST[bln_akta],$_POST[tgl_akta]);
        $TglSah=sprintf("%02d%02d%02d",$_POST[thn_sah],$_POST[bln_sah],$_POST[tgl_sah]);
        $Kode     = $_POST['Kode'];
        $KodeHukum     = $_POST['KodeHukum'];
        $Nama   = $_POST['Nama'];         
        $Alamat1        = $_POST['Alamat1'];
        $Kota      = $_POST['Kota'];
        $KodePos      = $_POST['KodePos']; 
        $Telepon      = $_POST['Telepon'];
        $Fax      = $_POST['Fax'];
        $Email      = $_POST['Email'];
        $Website      = $_POST['Website'];
        $NoAkta      = $_POST['NoAkta'];
        $NoSah      = $_POST['NoSah'];      
        $NA        = $_POST['NA'];

        $cek=mysql_num_rows(mysql_query
             ("SELECT * FROM identitas  WHERE Identitas_ID='$Kode'"));
        if ($cek > 0){
            ?>
            <script>
             alert('Data Anda Sudah Ada, Program Mencoba Entrykan Data yang Sama\n.');                    
            </script>
            <?
        }
        else{
        $query = "INSERT INTO identitas(Identitas_ID,KodeHukum,Nama_Identitas,TglMulai,Alamat1,Kota,KodePos,Telepon,Fax,Email,Website,NoAkta,TglAkta,NoSah,TglSah,Aktif)VALUES('$Kode','$KodeHukum','$Nama','$TglMulai','$Alamat1','$Kota','$KodePos','$Telepon','$Fax','$Email','$Website','$NoAkta','$TglAkta','$NoSah','$TglSah','$NA')";
        mysql_query($query);
        }	  
    defaultIdenUniv();
  break;
  
  case "UpdateIdntUniv":
    $TglMulai=sprintf("%02d%02d%02d",$_POST[thn_mulai],$_POST[bln_mulai],$_POST[tgl_mulai]);
    $TglAkta=sprintf("%02d%02d%02d",$_POST[thn_akta],$_POST[bln_akta],$_POST[tgl_akta]);
    $TglSah=sprintf("%02d%02d%02d",$_POST[thn_sah],$_POST[bln_sah],$_POST[tgl_sah]);
    $update=mysql_query("UPDATE identitas SET Identitas_ID  = '$_POST[Kode]',
                                          KodeHukum  = '$_POST[KodeHukum]',
                                          Nama_Identitas= '$_POST[Nama]',
                                          TglMulai       = '$TglMulai',
                                          Alamat1     = '$_POST[Alamat1]',
                                          Kota     = '$_POST[Kota]',
                                          KodePos     = '$_POST[KodePos]',
                                          Telepon     = '$_POST[Telepon]',
                                          Fax     = '$_POST[Fax]',
                                          Email     = '$_POST[Email]',
                                          Website     = '$_POST[Website]',
                                          NoAkta     = '$_POST[NoAkta]',
                                          TglAkta     = '$TglAkta',
                                          NoSah     = '$_POST[NoSah]',
                                          TglSah     = '$TglSah',
                                          Aktif       = '$_POST[NA]'                                                                                   
                                    WHERE ID          = '$_POST[ID]'");
    $data=mysql_fetch_array($update);
    defaultIdenUniv();    
  break;

  case "HapusIdntUniv":
       $sql="DELETE FROM identitas WHERE ID='$_GET[id]'";
       $qry=mysql_query($sql)
       or die();
    defaultIdenUniv();
  break;

}
?>
