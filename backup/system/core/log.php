<?php
function defaultLog(){
buka("DATA LOG");
echo"<div class='w-box'>";
 $txt_file    = file_get_contents('../log.txt');
  $rows        = explode("\n", $txt_file);
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>	<thead><tr>
<th>No</th>
<th>User</th>
<th>Waktu</th>
<th>IP</th>
<th>Browser</th>
<th>URL</th>
<th>Referrer</th>
<th>Proxy</th>
<th>Koneksi</th>
<th>Aksi</th>
</tr></thead><tbody>"; 
  array_shift($rows);
  $i=1;
if(!empty($rows)){
  foreach($rows as $row => $data)
  {
	$row_data = explode('|', $data);
 echo"<tr>
	<td>". $i++ . "</td>
	<td>". $row_data[0] . "</td>
	<td>". $row_data[1] . "</td>
	<td>". $row_data[2] . "</td>
	<td>". $row_data[3] . "</td>
	<td>". $row_data[4] . "</td>
	<td>". $row_data[5] . "</td>
	<td>". $row_data[6] . "</td>
	<td>". $row_data[7] . "</td>
	<td>". $row_data[8] . "</td>
</tr>";
  }
}
echo"</tbody></table>";
echo"</div>";
tutup();      
}

switch($_GET[PHPIdSession]){

  default:
    defaultLog();
  break;  
}
?>
