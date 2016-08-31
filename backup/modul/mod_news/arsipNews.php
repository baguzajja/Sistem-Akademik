<?php defined('_FINDEX_') or die('Access Denied'); ?>
<?php if($baca){ 
echo"<div class='widget'>
					<div class='widget-header'>						
						<h3>
							<i class='icon-list-alt'></i>
							ARSIP BERITA					
						</h3>
					</div> 
<div class='widget-content'>";
echo"<ul class='client_details'>";
	$qry= _query("SELECT * FROM berita ORDER BY tanggal,id DESC") or die ();
	while ($r=_fetch_array($qry)){	
	$tanggal=tgl_indo($r['tanggal']);
	$isi_berita = htmlentities(strip_tags($r['isi'])); 
    $isi = substr($isi_berita,0,150);
    $isi = substr($isi_berita,0,strrpos($isi," "));		
		echo"<li>
			<p><h4><i class='icon-play'></i>
				<a href='get-news-detailNews-$r[id].html'>$r[judul] </a></h4>
				<i>$tanggal - $isi ... </i>
			</p>
		</li>";
	}	
echo"</ul> ";
echo"</div></div>";
 }else{
ErrorAkses();
} ?>