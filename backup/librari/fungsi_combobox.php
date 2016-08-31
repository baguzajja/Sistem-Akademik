<?php
function combotgl($awal, $akhir, $var, $terpilih){
  echo "<select name=$var class='span3'>";
  for ($i=$awal; $i<=$akhir; $i++){
    $lebar=strlen($i);
    switch($lebar){
      case 1:
      {
        $g="0".$i;
        break;     
      }
      case 2:
      {
        $g=$i;
        break;     
      }      
    }  
    if ($i==$terpilih)
      echo "<option value=$g selected>$g</option>";
    else
      echo "<option value=$g>$g</option>";
  }
  echo "</select> ";
}

function combobln($awal, $akhir, $var, $terpilih){
  echo "<select name=$var class='span3'>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
    $lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }  
      if ($bln==$terpilih)
         echo "<option value=$b selected>$b</option>";
      else
        echo "<option value=$b>$b</option>";
  }
  echo "</select> ";
}

function combothn($awal, $akhir, $var, $terpilih){
  echo "<select name=$var class='span4'>";
  for ($i=$awal; $i<=$akhir; $i++){
    if ($i==$terpilih)
      echo "<option value=$i selected>$i</option>";
    else
      echo "<option value=$i>$i</option>";
  }
  echo "</select> ";
}
function Getcombothn($awal, $akhir, $var, $terpilih, $id,$bulan){
  echo "<select name=$var class='span4' onChange=\"MM_jumpMenu('parent',this,0)\">";
  for ($i=$awal; $i<=$akhir; $i++){
    if ($i==$terpilih)
      echo "<option value='us-bukubesar-$id-$bulan-$i.html' selected>$i</option>";
    else
      echo "<option value='us-bukubesar-$id-$bulan-$i.html'>$i</option>";
  }
  echo "</select> ";
}
function Getcombonamabln($awal, $akhir, $var, $terpilih,$id,$tahun){
  $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
  echo "<select name=$var class='span5' onChange=\"MM_jumpMenu('parent',this,0)\">";
  for ($bln=$awal; $bln<=$akhir; $bln++){
	$lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }
      if ($bln==$terpilih)
         echo "<option value='us-bukubesar-$id-$b-$tahun.html' selected>$nama_bln[$bln]</option>";
      else
        echo "<option value='us-bukubesar-$id-$b-$tahun.html'>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}
function Getcombotgl2($awal, $akhir, $var, $terpilih){
  echo "<select name=$var class='span3' onChange='this.form.submit()'>";
  for ($i=$awal; $i<=$akhir; $i++){
    $lebar=strlen($i);
    switch($lebar){
      case 1:
      {
        $g="0".$i;
        break;     
      }
      case 2:
      {
        $g=$i;
        break;     
      }      
    }  
    if ($i==$terpilih)
      echo "<option value=$g selected>$g</option>";
    else
      echo "<option value=$g>$g</option>";
  }
  echo "</select> ";
}
function Getcombothn2($awal, $akhir, $var, $terpilih){
  echo "<select name=$var class='span4' onChange='this.form.submit()'>";
  for ($i=$awal; $i<=$akhir; $i++){
    if ($i==$terpilih)
      echo "<option value='$i' selected>$i</option>";
    else
      echo "<option value='$i'>$i</option>";
  }
  echo "</select> ";
}
function Getcombonamabln2($awal, $akhir, $var, $terpilih,$id,$tahun){
  $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
  echo "<select name=$var class='span5' onChange='this.form.submit()'>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
	$lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }
      if ($bln==$terpilih)
         echo "<option value='$b' selected>$nama_bln[$bln]</option>";
      else
        echo "<option value='$b'>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}

function combonamabln($awal, $akhir, $var, $terpilih){
  $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
  echo "<select name=$var class='span5'>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
      if ($bln==$terpilih)
         echo "<option value=$bln selected>$nama_bln[$bln]</option>";
      else
        echo "<option value=$bln>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}
?>
