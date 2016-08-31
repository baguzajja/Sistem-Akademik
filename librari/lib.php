<?php
function _connect($h, $u, $p) {
  $r = mysql_connect($h, $u, $p) or die("Gagal terkoneksi dengan database server <b>$h</b>");
  return $r;
}
function _select_db($db, $con) {
  return mysql_select_db($db, $con) or die("Gagal membuka database <b>$db</b>.");
}
function _query($s='') {
  $r = mysql_query($s) or die("Gagal: <pre>$s</pre><br>".mysql_error());
  return $r;
}
function _fetch_array($r) {
  $w = mysql_fetch_array($r);
  return $w;
}
function _num_rows($r) {
  return mysql_num_rows($r);
}
function _fetch_row($r) {
  return mysql_fetch_row($r);
}
function _num_fields($r) {
  return mysql_num_fields($r);
}
function _field_name($r, $pos=0) {
  return mysql_field_name($r, $pos);
}
function _affected_rows() {
  return mysql_affected_rows();
}
function _result($r, $brs=0, $fld='') {
  $w = mysql_result($r, $brs, $fld);
  return $w;
}
function sqling($str) {
    $str = stripslashes($str);
	return addslashes($str);
}
function FixQuotes($str) {
    $str = stripslashes($str);
	$str = str_replace('"', '&quot;', $str);
	$str = str_replace("'", '&#39;', $str);
	return $str;
}
function CatatLog($nama,$aksi,$pesan) {
// ini utk melihat type browser
$agent = $_SERVER['HTTP_USER_AGENT'];

// ini utk melihat script di eksekusi dari mana GET(URL)
$uri = $_SERVER['REQUEST_URI'];

// ini utk melihat IP Pengunjung
$ip = $_SERVER['REMOTE_ADDR'];

// ini utk melihat script di refer dari mana
$ref = $_SERVER['HTTP_REFERER'];

// ini utk melihat Proxy pengunjung
$asli = $_SERVER['HTTP_X_FORWARDED_FOR'];

// ini utk melihat koneksi pengunjung
$via = $_SERVER['HTTP_VIA'];

// ini variabel tanggal
$dtime = date('r');

// ini adalah deskripsi variabel entry_line:
$entry_line = "$nama | $dtime | $ip | $agent? | $uri | $ref | $asli | $via | $aksi | $pesan \n"; 
// <– perhatian!! ini harus new line alias kamu enter sekali supaya hasilnya jadi new line

// “fopen()” utk fungsi membuka file, “a” ini yg paling penting.!!,
// ini berfungsi jika file “jejak.txt” tidak ada dalam server maka PHP akan menciptakannya
$fp = fopen("media/files/log.txt", "a");

// fungsinya utk menulis log dlm file
fputs($fp, $entry_line);

// fungsinya untuk menutup file
fclose($fp);

}
function digit($data){
		$input=$data;
		$panjang=strlen($input);
if ($panjang==0)
{
	return $input;	
}
elseif ($panjang < 4)
{
	return $input;
}
else
{
		$n=$panjang-1;
		$point=1;
		$j=1;
		$teks=array();
	for ($i=$n;$i>0;$i--)
	{
		if($point==3)
		{
			$teks["$j"]=substr($input,$i,3);
			$point=0;
			$j++;
			$g=$i;
		}
		$point++;
	}
	$input= substr($input,0,$g);
	for ($k=$j;$k>0;$k--)
	{
		if ($k==1){
			$input=$input. $teks["$k"];
		}else{
			$input=$input. $teks["$k"].".";
		}
	}
	return $input;
}
}
function Comaa($data){
		$input=$data;
		$panjang=strlen($input);
if ($panjang==0)
{
	return $input;	
}
elseif ($panjang < 4)
{
	return $input;
}
else
{
		$n=$panjang-1;
		$point=1;
		$j=1;
		$teks=array();
	for ($i=$n;$i>0;$i--)
	{
		if($point==3)
		{
			$teks["$j"]=substr($input,$i,3);
			$point=0;
			$j++;
			$g=$i;
		}
		$point++;
	}
	$input= substr($input,0,$g);
	for ($k=$j;$k>0;$k--)
	{
		if ($k==1){
			$input=$input. $teks["$k"];
		}else{
			$input=$input. $teks["$k"].",";
		}
	}
	return $input;
}
}
function CurrentMenu($parent,$id,$url,$page){
	$Current="";
	if($url==$page){
		$Current="active"; 
	} else {
		if($parent==$id){
		$Current="active";
		}
	}
	return $Current;
}
function punyasub($id) {
	$_sql = "SELECT * FROM modul WHERE parent_id='$id' AND aktif='Y'";
	$_res = _query($_sql);
	$jum=_num_rows($_res);
return $jum;
}
function GetMenuParent($id){
	$GetMenuParent="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM modul WHERE url='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$GetMenuParent=$row['parent_id'];
		}
	}
	return $GetMenuParent;
}
function JudulSitus($page){
	$JudulSitus="HOME";
	if (!empty($page))
	{
		$cek=mysql_query("SELECT * FROM modul WHERE url='$page' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$JudulSitus=$row['judul'];
		}
	}
	return $JudulSitus;
}

function PesanEror($jdl, $isi='') {
echo "<div class='panel-header'><i class='icon-sign-blank'></i> $jdl </div>
  <div class='panel-content'>
		<div class='alert alert-error'>
			<button class='close' data-dismiss='alert'>&times;</button>
			<strong>$isi
		</div>
		<center><a class='btn btn-danger' href='javascript:history.go(-1)'><i class='icon-undo'></i> Kembali</a></center>
  </div>";
}

function ErrorModul() {
  echo "<div class='widget-content error-container'>
		<center>
				<h2>OOPPSS .... MODUL ERROR !!</h2>
				<div class='error-details'>
					Maaf, Sepertinya <b>Modul</b> tidak ada atau belum lengkap !
				</div> 
				<div class='error-actions'>
					<a href='./' class='btn btn-large btn-primary'>
						<i class='icon-chevron-left'></i>
						&nbsp;
						Kembali Ke Home						
					</a>
				</div> 
			</center></div>";
}
function ErrorFileNotFound() {
  echo "<div class='widget-content error-container'>
		<center>
				<h2>OOPPSS .... FILE NOT FOUND !!</h2>
				<div class='error-details'>
					Maaf, Sepertinya <b>File</b> tidak tersedia !
				</div> 
				<div class='error-actions'>
					<a href='./' class='btn btn-large btn-primary'>
						<i class='icon-chevron-left'></i>
						&nbsp;
						Kembali Ke Home						
					</a>
				</div> 
			</center></div>";
}
function ErrorAkses() {
  echo "<div class='widget-content error-container'>
		<center>
				<h2>OOPPSS .... AKSES DITOLAK !!</h2>
				<div class='error-details'>
					Maaf, Anda Tidak Memiliki Izin Untuk Mengakses Menu Ini !
				</div> 
				<div class='error-actions'>
					<a href='./' class='btn btn-large btn-primary'>
						<i class='icon-chevron-left'></i>
						&nbsp;
						Kembali Ke Home						
					</a>
				</div> 
			</center></div>";
}
function buka($str='',$pesan='') {
  echo "<div class='panel-header'><i class='icon-sign-blank'></i> $str <span class='pull-right'>$pesan</span></div>
  <div class='panel-content'>";
}
function bukapanellist() {
  echo "<div class='tab-content'>
<div class='list-pane'>";
}
function tutuppanellist() {
  echo "</div></div>";
}
function tutup() {
  echo "</div>";
}
function ceklevel($username) {
//cek tabel karyawan
  $r1 = "SELECT * FROM karyawan WHERE username='$username'";
  $sql1 = _query($r1);
  $jumlah1 = _num_rows($sql1);
if ($jumlah1 > 0) {
	$data1 = _fetch_array($sql1);
	$leveId= $data1['id_level'];
  } else {
		$r2 = "SELECT * FROM dosen WHERE username='$username'";
		$sql2 = _query($r2);
		$jumlah2 = _num_rows($sql2);
		if ($jumlah2 > 0) {
		$data2 = _fetch_array($sql2);
		$leveId= $data2['id_level'];
		} else {
				$r3 = "SELECT * FROM mahasiswa WHERE username='$username'";
				$sql3 = _query($r3);
				$jumlah3 = _num_rows($sql3);
				if ($jumlah3 > 0) {
				$data3 = _fetch_array($sql3);
				$leveId= $data3['level_ID'];
				} else {
					$r4 = "SELECT * FROM admin WHERE username='$username'";
					$sql4 = _query($r4);
					$jumlah4 = _num_rows($sql4);
					$data4 = _fetch_array($sql4);
					$leveId= $data4['id_level'];
				}
			}
		}
return $leveId;
}
function GetaField($_tbl,$_key,$_value,$_result, $_order='', $_group='', $_limit= 'limit 1') {
  global $strCantQuery;
	$_sql = "select $_result from $_tbl where $_key='$_value' $_group $_order $_limit";
	$_res = _query($_sql);
	//echo $_sql;
	if (_num_rows($_res) == 0) return '';
	else {
	  $w = _fetch_array($_res);
	  return $w[$_result];
	}
}
function GetFields($_tbl, $_key, $_value, $_results, $_group='', $_order='', $_limit= 'limit 1') {
  global $strCantQuery;
	$s = "select $_results from $_tbl where $_key='$_value' $_group $_order $_limit";
	$r = _query($s);
	//echo "<pre>$s</pre>";
	if (_num_rows($r) == 0) return '';
	else {
	  /*$res = array();
	  for ($i=0; $i < mysql_num_fields($r); $i++) {
		$res[mysql_field_name($r, $i)] = mysql_result($r, 0, mysql_field_name($r, $i));
	  } */
	  return _fetch_array($r);
	}
}
function Semester($_start, $_end, $_default=0, $interval=1, $pad=1) {
    $_tmp = "";
	for ($i=$_start; $i <= $_end; $i+=$interval) {
	  $stri = str_pad($i, $pad, '0', STR_PAD_LEFT);
	  if ($i == $_default) $_tmp = "$_tmp <option value='$i' selected>Semester $stri</option>";
	  else $_tmp = "$_tmp <option value='$i'>Semester $stri</option>";
	}
	return $_tmp;
}
function GetOption($_table, $_field, $_order='', $_default='', $_where='', $_value='', $not=0) {
  global $strCantQuery;
	if (!empty($_order)) $str_order = " order by $_order ";
	else $str_order = "";
	if ($not==0) $strnot = "NA='N'"; else $strnot = '';
	if (!empty($_where)) {
	  if (empty($strnot)) $_where = "$_where"; else $_where = "and $_where";
	}
	if (!empty($_value)) {
	  $_fieldvalue = ", $_value";
	  $fk = $_value;
	}
	else {
	  $_fieldvalue = '';
	  $fk = $_field;
	}
  $_tmp = "<option value=''></option>";
	$_sql = "select $_field $_fieldvalue from $_table where $strnot $_where $str_order";
	$_res = _query($_sql);

  while ($w = _fetch_array($_res)) {
	  if (!empty($_value)) $_v = "value='" . $w[$_value]."'";
	  else $_v = '';
	  if ($_default == $w[$fk])
	    $_tmp = "$_tmp <option $_v selected>". $w[$_field]."</option>";
	  else
	    $_tmp = "$_tmp <option $_v>". $w[$_field]."</option>";    
  }
	return $_tmp;
}
function GetCheckboxes($table, $key, $Label, $Label1, $Nilai='') {
  $s = "select * from $table order by jurusan_ID";
  $r = mysql_query($s);
  $_arrNilai = explode(',', $Nilai);
  $str = '';
  while ($w = mysql_fetch_array($r)) {
    $_ck = (array_search($w[$key], $_arrNilai) === false)? '' : 'checked';
    $str .= "<input type=checkbox name='".$key."[]' value='$w[$key]' $_ck>  $w[$Label1] </br>";
  }
  return $str;
}
function GetCheckGroupModule($table, $key, $Label, $Label1, $Nilai='') {
  $s = "select * from $table where parent_id='0' order by id";
  $r = mysql_query($s);
  $_arrNilai = explode(',', $Nilai);
  $str = '';
  while ($w = mysql_fetch_array($r)) {
    $_ck = (array_search($w[$key], $_arrNilai) === false)? '' : 'checked';
	$str .= "<tr>
		<td>$w[$Label1] </td>              
		<td><input type=checkbox name='".$Label."[]' value='$w[$key]' $_ck> </td>
		</tr>";
  }
  return $str;
}
function GetCheckModule($table, $key, $Label, $Label1, $Nilai='') {
  $s = "select * from $table where parent_id!='0' order by parent_id";
  $r = mysql_query($s);
  $_arrNilai = explode(',', $Nilai);
  $str = '';
  while ($w = mysql_fetch_array($r)) {
    $_ck = (array_search($w[$key], $_arrNilai) === false)? '' : 'checked';
$namaGrup=NamaGroupMdl($w[parent_id ]);
	$str .=  "<tr>
		<td>$namaGrup</td>              
		<td>$w[$Label1]</td>
		<td>$w[keterangan]</td>
		<td><input type=checkbox name='".$Label."[]' value='$w[$key]' $_ck> </td>
		</tr>";
  }
  return $str;
}
function RandUnik($panjang) { 
   $pstring = "QWERTYUIOPASDFGHJKLZXCVBNM"; 
   $plen = strlen($pstring); 
      for ($i = 1; $i <= $panjang; $i++) { 
          $start = rand(0,$plen); 
          $unik.= substr($pstring, $start, 1); 
      } 
 
    return $unik; 
} 
function IDeven(){
global $ThunBln;
// hitung jumlah event
$cek=_query("SELECT * FROM event");
$total=_num_rows($cek); 
$nextNoUrut = $total + 1;
$ack=RandUnik(3);
$nexteven = "EV".$ThunBln.$ack.$nextNoUrut;
return $nexteven;
}
function GetBuku($key, $Label, $Label1, $Nilai='') {
	$debet = explode(',', $d);
	$s = "select * from buku WHERE id='$debet' order by id";
	$r = mysql_query($s);

  while ($w = mysql_fetch_array($r)) {
    $_ck = (array_search($w[$key], $_arrNilai) === false)? '' : 'checked';
    $str .= "<input type=checkbox name='".$key."[]' value='$w[$key]' $_ck>  $w[$Label1] </br>";
  }
  return $str;
}

function Checkbuku($table, $key, $Label, $Label1, $Nilai='') {
  $s = "select * from $table order by id";
  $r = mysql_query($s);
  $_arrNilai = explode(',', $Nilai);
  $str = '';
  while ($w = mysql_fetch_array($r)) {
    $_ck = (array_search($w[$key], $_arrNilai) === false)? '' : 'checked';
    $str .= "<input type=checkbox name='".$Label."[]' value='$w[$key]' $_ck>  <span>$w[$Label1]</span> ";
  }
  return $str;
}

//fungsi insert
	function insert($nama_tabel,$values)
	{
		$sql="INSERT INTO ".$nama_tabel." VALUES(".$values.")";
		_query($sql);	
	}
//fungsi update
	function update($nama_tabel,$values,$kondisi)
	{
		$sql="UPDATE ".$nama_tabel." SET ".$values." WHERE ".$kondisi;
		_query($sql);
	}
//fungsi delete
	function delete($nama_tabel,$kondisi)
	{
		$sql="DELETE FROM ".$nama_tabel." WHERE ".$kondisi;
		_query($sql);
	}
function create_array_date($start, $end)
{
   // Modified by JJ Geewax
   $range = array();
   if (is_string($start) === true) $start = strtotime($start);
   if (is_string($end) === true ) $end = strtotime($end);
   if ($start > $end) return create_array_date($end, $start);
   do {
      $range[] = date('Y-m-d', $start);
      $start = strtotime("+ 1 day", $start);
   }
   while($start < $end);
   return $range;
}
function rangeDate( $fromDate, $toDate)
{

$dateRange = (array) $fromDate;

$splitDate = explode ( '-', $fromDate );

while ( $dateRange[ sizeof($dateRange)-1 ] != $toDate )
{

if ( ! checkdate( $splitDate[1], ++$splitDate[2], $splitDate[0] ) )
{

if ( ! checkdate( (int)++$splitDate[1], (int)$splitDate[2]=1, (int)$splitDate[0] ) )
{
$splitDate[2] = $splitDate[1] = 1;
$splitDate[0]++;
}
}

$dateRange[] = str_pad($splitDate[0], 4, "0", STR_PAD_LEFT) .'-'. str_pad($splitDate[1], 2, "0", STR_PAD_LEFT) .'-'. str_pad($splitDate[2], 2, "0", STR_PAD_LEFT);

}

return $dateRange;
} 

function GetName($table,$where,$id,$field){
	$Name="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT $field FROM $table WHERE $where='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$Name=$row[$field];
		}
	}
	return $Name;
}
function TahunAktif(){
$tahunAktif ="SELECT * FROM tahun WHERE Aktif='Y'";
$ta		=_query($tahunAktif) or die();
$t		=_fetch_array($ta);
$tahun=$t['Tahun_ID'];
return $tahun;
}
function GetIpk($id){
	$Ipke="";
	if ($id!=''){
	$sql="SELECT * FROM mahasiswa WHERE NIM='$id'";
	$qry=_query($sql)or die ();
	$ab=_num_rows($qry);
if ($ab > 0){ 
  $d=_fetch_array($qry);
  $sql="SELECT * FROM matakuliah WHERE Identitas_ID='$d[identitas_ID]' AND Jurusan_ID='$d[kode_jurusan]' AND Kurikulum_ID IN ('41',$d[Kurikulum_ID]) ORDER BY Kode_mtk";
  $no=0;
  $qry=mysql_query($sql) or die ();
  while($data=mysql_fetch_array($qry)){
  $no++;
  $sqlr="SELECT * FROM krs WHERE NIM='$id' AND Jadwal_ID='$data[Kode_mtk]'";
  $qryr= mysql_query($sqlr);
  $data1=mysql_fetch_array($qryr);
 
$ipSks= ($boboxtsks==0)? 0: $data[SKS];

$boboxtsks=$data[SKS]*$data1[BobotNilai];
$Totsks=$Totsks+$ipSks;

$TotSks=$TotSks+$data[SKS];

$jmlbobot=$jmlbobot+$boboxtsks;
$bobot=$data1[BobotNilai]; 
$totalSKS=number_format($TotSks,0,',','.');
$sksDitempuh=number_format($Totsks,0,',','.');
$JumlahBBt=number_format($jmlbobot,0,',','.');	  
  }
$ipk=$jmlbobot/$Totsks;
$Ipke=number_format($ipk,2,',','.');
	}
}
	return $Ipke;
}
function GetTotalSKS($id){
	$totalSKS="";
	if ($id!=''){
	$sql="SELECT * FROM mahasiswa WHERE NIM='$id'";
	$qry=_query($sql)or die ();
	$ab=_num_rows($qry);
if ($ab > 0){ 
  $d=_fetch_array($qry);
  $sql="SELECT * FROM matakuliah WHERE Identitas_ID='$d[identitas_ID]' AND Jurusan_ID='$d[kode_jurusan]' AND Kurikulum_ID IN ('41',$d[Kurikulum_ID]) ORDER BY Kode_mtk";
  $no=0;
  $qry=mysql_query($sql) or die ();
  while($data=mysql_fetch_array($qry)){
  $no++;
  $sqlr="SELECT * FROM krs WHERE NIM='$id' AND Jadwal_ID='$data[Kode_mtk]'";
  $qryr= mysql_query($sqlr);
  $data1=mysql_fetch_array($qryr);
 
$ipSks= ($boboxtsks==0)? 0: $data[SKS];

$boboxtsks=$data[SKS]*$data1[BobotNilai];
$Totsks=$Totsks+$ipSks;

$TotSks=$TotSks+$data[SKS];

$jmlbobot=$jmlbobot+$boboxtsks;
$bobot=$data1[BobotNilai]; 
$totalSKS=number_format($TotSks,0,',','.');
$sksDitempuh=number_format($Totsks,0,',','.');
$JumlahBBt=number_format($jmlbobot,0,',','.');	  
  }
$ipk=$jmlbobot/$Totsks;
$Ipke=number_format($ipk,2,',','.');
	}
}
	return $totalSKS;
}

function NamaProdi($id){
	$NamaProdi="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM jurusan WHERE kode_jurusan='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaProdi=$row[nama_jurusan];
		}
	}
	return $NamaProdi;
}
function NamaIdentitas($id){
	$NamaIdentitas="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM identitas WHERE Identitas_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			if($row[Identitas_ID]=='073114'){
			$NamaIdentitas="STIE YAPAN";
			}else{
			$NamaIdentitas=$row['Nama_Identitas'];
			}
		}
	}
	return $NamaIdentitas;
}
function NamaKampus($id){
	$NamaKampus="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM kampus WHERE Kampus_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaKampus=$row['Nama'];
		}
	}
	return $NamaKampus;
}
function NamaDosen($id){
	$NamaDosen="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM dosen WHERE dosen_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaDosen="$row[nama_lengkap] ,$row[Gelar]";
		}
	}
	return $NamaDosen;
}
function JabatanStaff($id){
	$JabatanStaff="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM jabatan WHERE Jabatan_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$JabatanStaff=$row['Nama'];
		}
	}
	return $JabatanStaff;
}
function JabatanIdStaff($id){
	$JabatanIdStaff="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM karyawan WHERE id='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$JabatanIdStaff=$row['Jabatan'];
		}
	}
	return $JabatanIdStaff;
}
function JabatanIdDosen($id){
	$JabatanIdDosen="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM dosen WHERE dosen_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$JabatanIdDosen=$row['Jabatan_ID'];
		}
	}
	return $JabatanIdDosen;
}
function StatusDosen($id){
	$StatusDosen="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM statuskerja WHERE StatusKerja_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$StatusDosen=$row['Nama'];
		}
	}
	return $StatusDosen;
}
function NamaJabatan($id){
	$NamaJabatan="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM jabatan WHERE Jabatan_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaJabatan=$row['Nama'];
		}
	}
	return $NamaJabatan;
}
function NamaAgama($id){
	$NamaAgama="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM agama WHERE agama_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaAgama=$row['nama'];
		}
	}
	return $NamaAgama;
}
function NamaBuku($id){
	$NamaBuku="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM buku WHERE id='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaBuku=$row['nama'];
		}
	}
	return $NamaBuku;
}
function NamaLaporan($id){
	$NamaLaporan="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM lapbau WHERE id='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaLaporan=$row['Nama'];
		}
	}
	return $NamaLaporan;
}
function NamaTransaksi($id){
	$NamaTransaksi="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM jenistransaksi WHERE id='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaTransaksi=$row['Nama'];
		}
	}
	return $NamaTransaksi;
}
function NamaTrakBaak($id){
	$NamaTrakBaak="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM lapbaak WHERE id='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaTrakBaak=$row['Nama'];
		}
	}
	return $NamaTrakBaak;
}

function NamaKelas($id){
	$NamaKelas="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT nama_program FROM program WHERE Program_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaKelas=$row['nama_program'];
		}
	}
	return $NamaKelas;
}
function NamaKelasa($id){
	$NamaKelasa="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM program WHERE ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaKelasa=$row['nama_program'];
		}
	}
	return $NamaKelasa;
}
function BiayaMhsw($id){
	$BiayaMhsw="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM biayamhsw WHERE BiayaMhswID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$BiayaMhsw=$row['NamaBiaya'];
		}
	}
	return $BiayaMhsw;
}

function TotalBiayaMhsw($thn,$jenjang,$kelas){
    $TotalBiaya="";
    if ($thn!='')
	{
       $cek=mysql_query("SELECT SUM(Jumlah) AS total FROM biayamhsw WHERE TahunID='$thn' AND JenjangID='$jenjang' AND KelasID='$kelas'");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$TotalBiaya=$row['total'];
		}
	}
	return $TotalBiaya;
}

function namaSemester($bln){
$semester="";
	if ($bln!='')
	{
	if ($bln%2==0)
	{ 
	$semester="GENAP"; 
	} 
	else 
	{
	$semester="GASAL"; 
	}
	}
	return $semester;
}

function NamaStaff($id){
	$NamaStaff="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM karyawan WHERE id='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaStaff=$row['nama_lengkap'];
		}
	}
	return $NamaStaff;
}

function NamaDepatmen($id){
	$NamaDepatmen="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM departemen WHERE DepartemenId='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaDepatmen=$row['NamaDepeartemen'];
		}
	}
	return $NamaDepatmen;
}
function NamaKas($id){
	$NamaKas="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM buku WHERE id='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaKas=$row['nama'];
		}
	}
	return $NamaKas;
}
function NamaGroupMdl($id){
	$NamaGroupMdl="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM modul WHERE id='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaGroupMdl=$row['judul'];
		}
	}
	return $NamaGroupMdl;
}
function NamaJabatanDikti($id){
	$NamaJabatanDikti="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM jabatandikti WHERE JabatanDikti_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaJabatanDikti=$row['Nama'];
		}
	}
	return $NamaJabatanDikti;
}

function IDtahun(){
global $TahunIni;
// hitung jumlah pelanggan
$cek=_query("SELECT * FROM tahun");
$total=_num_rows($cek); 
$nextNoUrut = $total + 1;
$nexttahun = "TA".$nextNoUrut.$TahunIni;
return $nexttahun;
}
function TahunID($id){
	$TahunID="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM tahun WHERE Tahun_ID ='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$TahunID=$row['Nama'];
		}
	}
	return $TahunID;
}
function NamaRuang($id){
	$NamaRuang="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM ruang WHERE ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaRuang=$row['Nama'];
		}
	}
	return $NamaRuang;
}
function CekJadwal($id){
	$CekJadwal="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM jadwal WHERE Jadwal_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$CekJadwal=$row['Kode_Mtk'];
		}
	}
	return $CekJadwal;
}
function SksMtk($id){
	$SksMtk="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM matakuliah WHERE Kode_mtk='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$SksMtk=$row['SKS'];
		}
	}
	return $SksMtk;
}
function KelompokMtk($id){
	$KelompokMtk="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM kelompokmtk WHERE KelompokMtk_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$KelompokMtk=$row['Nama'];
		}
	}
	return $KelompokMtk;
}
function jumlahMhsw($id,$tahun){
	$jumlahMhsw="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM krs WHERE Jadwal_ID='$id'");
		$jumlahMhsw=count($cek);
	}
	return $jumlahMhsw;
}
function MatakuliahID($id){
	$MatakuliahID="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM matakuliah WHERE Kode_mtk='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$MatakuliahID=$row['KelompokMtk_ID'];
		}
	}
	return $MatakuliahID;
}
function NamaKonsentrasi($id){
	$NamaKonsentrasi="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM kurikulum WHERE Kurikulum_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaKonsentrasi=$row['Nama'];
		}
	}
	return $NamaKonsentrasi;
}
function NamaRekanan($id){
	$NamaRekanan="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT NamaRekanan FROM rekanan WHERE RekananID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$NamaRekanan=$row['NamaRekanan'];
		}
	}
	return $NamaRekanan;
}
function CallRekanan($id){
	$CallRekanan="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM rekanan WHERE RekananID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$CallRekanan=$row['Telepon']." - ".$row['Fax'];
		}
	}
	return $CallRekanan;
}

function TotalBayar($id,$jenjang){
	$TotalBayar="";
	if ($id!='')
	{
        if($jenjang=='S1'){
            $trans="17";
            $buku="'1','2'";
        }elseif($jenjang=='S2'){
                $trans="18";
                $buku="'8','9'";
        }else{
                $trans="'17','18'";
                $buku="'1','2','8','9'";
        }
		$cek=mysql_query("SELECT SUM(Debet) AS total FROM transaksi WHERE AccID='$id' AND Buku IN ($buku) AND Transaksi IN ($trans)");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$TotalBayar=$row['total'];
		}
	}
	return $TotalBayar;
}
function TotalTransaksi($trans){
	$Totale="";
	if ($trans!='')
	{
		$cek= _query("SELECT SUM(Debet) AS total FROM transaksi WHERE TransID='$trans' AND Transaksi IN ('17','18') AND Buku IN ('1','2','8','9')");
		if ( _num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$Totale=$row['total'];
		}
	}
	return $Totale;
}
function get_jenjang($id){
	$jenjang="";
	if ($id!='')
	{
		$cek=mysql_query("SELECT * FROM jenjang WHERE Jenjang_ID='$id' LIMIT 0,1");
		if (mysql_num_rows($cek)>0)
		{
			$row=mysql_fetch_array($cek);
			$jenjang=$row['Nama'];
		}
	}
	return $jenjang;
}
function adddate($vardate,$added)
{
$data = explode("-", $vardate);
$date = new DateTime();
$date->setDate($data[0], $data[1], $data[2]);
$date->modify("".$added."");
$day= $date->format("Y-m-d");
return $day;
}
function NoRegister(){
global $tgl_sekarang;
// cari id registrasi terakhir yang berawalan tanggal hari ini
$query = "SELECT max(NoReg) AS last FROM mahasiswa WHERE NoReg LIKE 'REG$tgl_sekarang%'";
$hasil = _query($query);
$data  = _fetch_array($hasil);
$lastNoTransaksi = $data['last'];
$lastNoUrut = substr($lastNoTransaksi, 11, 4); 
$nextNoUrut = $lastNoUrut + 1;
$nextNoTransaksi = "REG".$tgl_sekarang.sprintf('%04s', $nextNoUrut);
return $nextNoTransaksi;
}
function PembayaranKe($reg){
global $tgl_sekarang;
$query = "SELECT * FROM transaksi WHERE Transaksi='17' AND AccID='$reg' AND Buku IN ('1','2','8','9')";
$hasil = _query($query);
$data  = _num_rows($hasil); 
$nextbayar = $data + 1;
return $nextbayar;
}
function NoTransaksi(){
global $tgl_sekarang;
// cari id registrasi terakhir yang berawalan tanggal hari ini
$query = "SELECT max(TransID) AS last FROM transaksi WHERE TransID LIKE 'BAU$tgl_sekarang%'";
$hasil = _query($query);
$data  = _fetch_array($hasil);
$lastNoTransaksi = $data['last'];
$lastNoUrut =(int) substr($lastNoTransaksi, 12, 4); 
$nextNoUrut = $lastNoUrut + 1;
$nextNoTransaksi = "BAU".$tgl_sekarang.sprintf('%04s', $nextNoUrut);
return $nextNoTransaksi;
}
function GenerateID($table,$field,$tgl,$awal){
$thn=substr("$tgl",0,4);
$bln=substr("$tgl",5,2);
$ThunBln=$bln.$thn;
$like=$awal.$ThunBln;
// hitung jumlah 
$cek=_query("SELECT * FROM $table WHERE $field LIKE '$like%'");
$total=_num_rows($cek); 
$nextNoUrut = $total + 1;
$ack=RandUnik(3);
$nextID = $awal.$ThunBln.$ack.$nextNoUrut;
return $nextID;
}

function NoTrakBaa(){
global $tgl_sekarang;
// cari id registrasi terakhir yang berawalan tanggal hari ini
$query = "SELECT max(TransID) AS last FROM transaksi WHERE TransID LIKE 'BAAK$tgl_sekarang%'";
$hasil = _query($query);
$data  = _fetch_array($hasil);
$lastNoTransaksi = $data['last'];
$lastNoUrut = (int) substr($lastNoTransaksi, 13, 4); 
$nextNoUrut = $lastNoUrut + 1;
$nextNoTransaksi = "BAAK".$tgl_sekarang.sprintf('%04s', $nextNoUrut);
return $nextNoTransaksi;
}

	function get_detail_buku($buku,$bulan,$tahun)
	{
		$detBuk="SELECT * FROM transaksi WHERE Buku='$buku' AND DATE_FORMAT(TglSubmit,'%Y-%m')='$tahun-$bulan' ORDER BY TglSubmit,id,Debet DESC";
		$res= _query($detBuk) or die ();
		
		return $res;
	}
function get_saldo_akhir($awal,$debet,$kredit,$sign)
	{
		if($sign==1) //  default debet
		{
			$akhir = $awal + $debet - $kredit;
		}
		else // default kredit
		{
			$akhir = $awal - $debet + $kredit;
		}
		return $akhir;
	}
function get_saldo($buku,$bulan,$tahun,$detail=false)
    {
	if($buku==11){
$bukune	="";
 }else{ 
$bukune	="WHERE Buku = '$buku'";
 }
	$awal = 0;
        $sql = _query("SELECT SUM(IF(DATE_FORMAT(TglBayar,'%Y-%m')='$tahun-$bulan',Debet,0)) as debet,SUM(IF(DATE_FORMAT(TglBayar,'%Y-%m')='$tahun-$bulan',Kredit,0)) as kredit,(SUM(IF(DATE_FORMAT(TglBayar,'%Y-%m')<'$tahun-$bulan',Debet,0))-SUM(IF(DATE_FORMAT(TglBayar,'%Y-%m')<'$tahun-$bulan',Kredit,0))) as saldo FROM transaksi $bukune");
		$raw = _fetch_array($sql);
		$rows =  _affected_rows($sql);  // jumlah data yang dihasilkan dari query
		
        if($rows > 0)
        {
			if($detail)
			return array($raw['saldo'],$raw['debet'],$raw['kredit']);
            return ($awal + $raw['saldo']);

        }
        else
        {
			if($detail)
			return array($awal,0,0);
            return $awal;
        }
    }

    function pecah($uang,$delimiter='.',$kurung=false)
    {
        if($uang == '' || $uang == 0)
        {
            $rupiah = '0';
            return $rupiah;
        }
        $neg = false;
        if($uang<0)
        {
            $neg = true;
            $uang = abs($uang);
        }
        $rupiah = number_format($uang,0,',',$delimiter);
        if($neg && $kurung)
        {
            $rupiah = '('.$rupiah.')';
        }
        return $rupiah;
    }
function tgl_indo($tglw){
			$tanggale = substr($tglw,8,2);
			$bulane = getBulan(substr($tglw,5,2));
			$tahune = substr($tglw,0,4);
			return $tanggale.' '.$bulane.' '.$tahune;		 
	}	
function tgl_indo2($tglw){
			$tanggale = substr($tglw,8,2);
			$bulane = getBulan2(substr($tglw,5,2));
			$tahune = substr($tglw,0,4);
			return $tanggale.' '.$bulane.' '.$tahune;		 
	}	
function format_tanggal($str)
{
	if (strstr($str,":"))
	{
		$new=explode(" ",$str);
		
		$date=explode("-",$new[0]);
		$tanggal=$date[2]."-".$date[1]."-".$date[0];
		$tanggal=$tanggal." ".$new[1];
		return $tanggal;
	}
	else
	{
		$date=explode("-",$str);
		$tanggal=$date[2]."-".$date[1]."-".$date[0];
		return $tanggal;
	}
}
	function getBulan($bln){
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			} 

function getBulan2($bln){
				switch ($bln){
					case 01: 
						return "Januari";
						break;
					case 02:
						return "Februari";
						break;
					case 03:
						return "Maret";
						break;
					case 04:
						return "April";
						break;
					case 05:
						return "Mei";
						break;
					case 06:
						return "Juni";
						break;
					case 07:
						return "Juli";
						break;
					case 08:
						return "Agustus";
						break;
					case 09:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			} 
function getBulan3($bln){
				switch ($bln){
					case 01: 
						return "January";
						break;
					case 02:
						return "February";
						break;
					case 03:
						return "March";
						break;
					case 04:
						return "April";
						break;
					case 05:
						return "May";
						break;
					case 06:
						return "June";
						break;
					case 07:
						return "July";
						break;
					case 08:
						return "August";
						break;
					case 09:
						return "September";
						break;
					case 10:
						return "October";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "December";
						break;
				}
			} 
function getBulanRomawi($bln){
				switch ($bln){
					case 1: 
						return "I";
						break;
					case 2:
						return "II";
						break;
					case 3:
						return "III";
						break;
					case 4:
						return "IV";
						break;
					case 5:
						return "V";
						break;
					case 6:
						return "VI";
						break;
					case 7:
						return "VII";
						break;
					case 8:
						return "VIII";
						break;
					case 9:
						return "IX";
						break;
					case 10:
						return "X";
						break;
					case 11:
						return "XI";
						break;
					case 12:
						return "XII";
						break;
				}
			} 
function trimed($txt){
$txt = trim($txt);
while( strpos($txt, '  ') ){
$txt = str_replace('  ', ' ', $txt);
}
return $txt;
}
function jml_barang($kode_barang,$status){
$hasil_hitung=_fetch_array(_query("select sum(Jumlah) as jmlh from transaksi where ProdukId='$kode_barang' and Status='$status' and Jumlah > 0"));
return $hasil_hitung[jmlh];
}

function sisa_barang($kode_barang){
$hasil_sisa=_fetch_array(_query("SELECT inventaris.InventarisID ,(SELECT SUM(Jumlah) as jml FROM 
 transaksi 
WHERE Status='M' AND ProdukId='$kode_barang'
group by ProdukId)-(SELECT SUM(Jumlah) as jml FROM 
 transaksi 
WHERE Status='K' AND ProdukId='$kode_barang'
group by ProdukId)
as sisa from inventaris WHERE InventarisID='$kode_barang'
"));
return $hasil_sisa[sisa];
}

function do_crypt($Pass) { $Result=""; for ($i=0;$i<strlen($Pass);$i++) {
 $tmp=ord($Pass[$i]); 
 $tmp=$tmp+$i; 
 $num1=intval($tmp/100); $num2=intval($tmp%100); $num2=intval($num2/10); $num3=intval($tmp%10); $Result=$Result.$num1; $Result=$Result.$num2; $Result=$Result.$num3; } return $Result; } 

function do_decrypt($CodedPass) { 
$result=""; $i=0; while ($i<strlen($CodedPass)) { $num1=ord($CodedPass[$i++]); if ($i>=strlen($CodedPass)) break; $num2=ord($CodedPass[$i++]); if ($i>=strlen($CodedPass)) break; $num3=ord($CodedPass[$i++]); if ($i>strlen($CodedPass)) break; $num1=$num1-48; $num2=$num2-48; $num3=$num3-48; $num=$num1*100+$num2*10+$num3; $char=chr($num); $result=$result.$char; } $result1=""; for ($i=0;$i<strlen($result);$i++) { $tmp=ord($result[$i]); $tmp=$tmp-$i; $char=chr($tmp); $result1=$result1.$char; } return $result1;
}

function TotalMhsRekanan($rek){
	$total="";
    if($rek!='')
    {
        $cek=_query("SELECT COUNT(a.MhswID) as Total FROM mahasiswa a, keuanganmhsw b
        WHERE a.NoReg=b.RegID AND a.RekananID ='$rek' AND a.NIM!='' AND a.LulusUjian='N' AND b.lunas='N'");
		if (_num_rows($cek)>0)
		{
			$row=_fetch_array($cek);
			$total=$row[Total];
		}
    }
return $total;
}

function TotalBiayaMhsRekanan($rek){
	$total="";
    if($rek!='')
    {
        $cek=_query("SELECT SUM(TotalBiaya) as Total FROM keuanganmhsw WHERE RegID IN (SELECT NoReg FROM mahasiswa WHERE RekananID ='$rek' AND LulusUjian='N') AND Aktif='Y' AND lunas='N'");
		if (_num_rows($cek)>0)
		{
			$row=_fetch_array($cek);
			$total=$row[Total];
		}
    }
return $total;
}

?>