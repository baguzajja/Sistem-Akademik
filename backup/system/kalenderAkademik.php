<?php
require_once "../librari/koneksi.php";
$id= $_REQUEST['codd'];
$kode= $_REQUEST['kode'];
$idp= $_REQUEST['id'];
$query = "SELECT t1.*,t2.nama_jurusan FROM tahun t1,jurusan t2 WHERE t1.Jurusan_ID=t2.kode_jurusan AND t1.Jurusan_ID='$kode' AND t1.Program_ID='$idp'";
$result = mysql_query($query) or die(mysql_error());
        $array = array();
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $array[$i]=array("id"=>$row["Tahun_ID"],"title"=>$row["Nama"],"start"=>$row["TglKRSMulai"]." ".$row["TglKRSSelesai"],"allDay"=>false,"description"=>$row["Aktif"],"editable"=>true);
            $i++;
        }

 echo json_encode($array);
?>