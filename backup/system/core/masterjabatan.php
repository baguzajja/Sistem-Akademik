<?php
function defaultJabatan(){
buka("Master Jabatan / Struktur Organisasi");
echo"<div class='row'><p class='pull-right'><a class='btn btn-success' href='action-masterjabatan-editJabatan-1.html'>Tambah Jabatan</a></p> </div>
    <table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
	<thead><tr><th>No</th><th>Kode Jabatan</th><th>Nama Jabatan</th><th>Departemen</th><th>Aksi</th></tr></thead><tbody>"; 
      $sql="SELECT * FROM jabatan WHERE JabatanUntuk NOT IN ('mahasiswa') ORDER BY Jabatan_ID Desc";
      $qry= _query($sql) or die ();
      while ($r=_fetch_array($qry)){ 
	  $dept=NamaDepatmen($r[JabatanUntuk]);
      $no++;
echo"<tr><td>$no</td>
	<td>$r[KodeJabatan]</td>
	<td>$r[Nama]</td>
	<td>$dept</td>
	<td width='20%'>
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini btn-inverse' href='actions-masterjabatan-editJabatan-0-$r[Jabatan_ID].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='get-masterjabatan-HapusJabatan-$r[Jabatan_ID].html' onClick=\"return confirm('Anda yakin akan Menghapus data Jabatan $r[Nama] ?')\">Hapus</a>
			</div>
		</center>
	</td></tr>";        
	} 
echo"</tbody></table>";
tutup();      
}
function editJabatan() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('jabatan', 'Jabatan_ID', $rekid, '*');
    $jdl = "Edit Master Jabatan";
    $hiden = "<input type=hidden name='Jabatan_ID' value='$w[Jabatan_ID]'>
		<input type=text name='KodeJabatan' value='$w[KodeJabatan]'>";
  }
  else {
    $w = array();
    $w['KodeJabatan'] = '';
    $w['Nama'] = '';
    $w['JabatanUntuk'] = '';
    $w['NA'] = 'Y';
    $jdl = "Tambah Master Jabatan";
    $hiden = "<input type=text name='KodeJabatan' value='$w[KodeJabatan]'>";
  }
   $na = ($w['NA'] == 'Y')? 'checked' : '';
  // Tampilkan
buka("Master Jabatan");
	echo "<div class='panel-content'>
		<form id='example_form' action='aksi-masterjabatan-simpanJabatan.html' method=POST name='jabatan' class='form-horizontal'>
		<input type=hidden name='md' value='$md'>
		<fieldset>
		<legend>$jdl</legend>
			<div class='control-group'>
				<label class='control-label' for='name'>Kode Jabatan</label>
				<div class='controls'>
					$hiden
				</div>
			</div>
			
			<div class='control-group'>
				<label class='control-label'>Nama Jabatan</label>
				<div class='controls'>
					<input type=text name='Nama' value='$w[Nama]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jabatan Untuk ?</label>
				<div class='controls'>
		<select name='bagian'>
		<option value=0 selected>- Pilih Departemen -</option>"; 
		$tampil=_query("SELECT * FROM departemen ORDER BY DepartemenId");
		while($d=_fetch_array($tampil)){
		if($w[JabatanUntuk]==$d[DepartemenId]){
		echo "<option value=$d[DepartemenId] selected>$d[NamaDepeartemen]</option>";
			}else{
			echo "<option value=$d[DepartemenId]>$d[NamaDepeartemen]</option>";
			  }
        }
		echo "</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Aktif ? </label>
					<div class='controls'>
						<input type=checkbox name='NA' value='Y' $na >
					</div>
			</div>
			
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Submit</button>
				<button type='reset' class='btn'>Reset</button>
				<a class='btn btn-inverse' href='go-masterjabatan.html'>Batal</a>
			</div>
		</fieldset>
</form></div>";
tutup();
}
function simpanJabatan() {
  $md = $_POST['md']+0;
  $Jabatan_ID 		= $_POST['Jabatan_ID'];
  $KodeJabatan 		= $_POST['KodeJabatan'];
  $Nama				= sqling($_POST['Nama']);
  $JabatanUntuk		= sqling($_POST['bagian']);
  $NA = empty($_POST['NA'])? 'N' : $_POST['NA'];
  if ($md == 0) {
    $s = "UPDATE  jabatan SET KodeJabatan='$KodeJabatan', Nama='$Nama', JabatanUntuk='$JabatanUntuk', NA='$NA'
      WHERE Jabatan_ID='$Jabatan_ID' ";
    $r = _query($s);
	PesanOk("Update Master Jabatan","Data Master Jabatan Berhasil Di Update","go-masterjabatan.html");
  }
  else {
    $ada = GetFields('jabatan', 'Jabatan_ID', $Jabatan_ID, '*');
    if (empty($ada)) {
      $s = "INSERT INTO jabatan (KodeJabatan,Nama,JabatanUntuk,NA)
        values('$KodeJabatan', '$Nama', '$JabatanUntuk','$NA')";
      $r = _query($s);
	PesanOk("Tambah Master Jabatan","Master Jabatan Berhasil Di Simpan","go-masterjabatan.html");
    } else{
	PesanEror("Gagal Menambah Master Jabatan", "Master Jabatan Sudah ada dalam database");
	}
  }
}
switch($_GET[PHPIdSession]){

  default:
    defaultJabatan();
  break;  
	  
  case "editJabatan":
    editJabatan();
  break;
  
  case "simpanJabatan":
    simpanJabatan();
  break;
  
  case "HapusJabatan":
       $sql="DELETE FROM jabatan WHERE Jabatan_ID='$_GET[id]'";
       $qry=_query($sql) or die();
    PesanOk("Hapus Data Jabatan","Data Jabatan Berhasil Di Hapus","go-masterjabatan.html");	
  break;

}
?>
