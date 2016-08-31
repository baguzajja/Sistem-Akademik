<?php
// class paging untuk halaman administrator
class Paging{
// Fungsi untuk mencek halaman dan posisi data
function cariPosisi($batas){
if(empty($_GET['halaman'])){
	$posisi=0;
	$_GET['halaman']=1;
}
else{
	$posisi = ($_GET['halaman']-1) * $batas;
}
return $posisi;
}

// Fungsi untuk menghitung total halaman
function jumlahHalaman($jmldata, $batas){
$jmlhalaman = ceil($jmldata/$batas);
return $jmlhalaman;
}

// Fungsi untuk link halaman 1,2,3 (untuk admin)
function navHalaman($halaman_aktif, $jmlhalaman, $link){
$link_halaman = "";

// Link ke halaman pertama (first) dan sebelumnya (prev)
if($halaman_aktif > 1){
	$prev = $halaman_aktif-1;
	$link_halaman .= "<li><a href='$link-1.html'><< First</a> </li><li>
                    <a href='$link-$prev.html'>< Prev</a> </li> ";
}
else{ 
	$link_halaman .= "<li><a href='#'><< First </a></li><li> <a href='#'>< Prev </a>  </li> ";
}

// Link halaman 1,2,3, ...
$angka = ($halaman_aktif > 3 ? " <li><a href='#'>... </a></li>" : " "); 
for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++){
  if ($i < 1)
  	continue;
	  $angka .= "<li><a href='$link-$i.html'>$i</a></li>";
  }
	  $angka .= " <li class='active'><a href='#'>$halaman_aktif</a></li>";
	  
    for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++){
    if($i > $jmlhalaman)
      break;
	  $angka .= "<li><a href='$link-$i.html'>$i</a></li>";
    }
	  $angka .= ($halaman_aktif+2<$jmlhalaman ? " <li><a href='#'>...</a></li><li><a href='$link-$jmlhalaman.html'>$jmlhalaman</a> </li> " : " ");

$link_halaman .= "$angka";

// Link ke halaman berikutnya (Next) dan terakhir (Last) 
if($halaman_aktif < $jmlhalaman){
	$next = $halaman_aktif+1;
	$link_halaman .= "<li><a href='$link-$next.html'>Next ></a> </li> 
                     <li><a href='$link-$jmlhalaman.html'>Last >></a></li> ";
}
else{
	$link_halaman .= "<li> <a href='#'>Next > </a></li><li><a href='#'>Last >></a> </li>";
}
return $link_halaman;
}
}
?>
