<?php defined('_FINDEX_') or die('Access Denied'); ?>
<?php if($baca){ 
$w = GetFields('berita', 'id', $_GET['id'], '*');
$tanggal=tgl_indo($w['tanggal']);
echo"<div class='widget'>
					<div class='widget-header'>						
						<h3>
							<i class='icon-list-alt'></i>
							$w[judul]					
						</h3>
					<div class='widget-actions'>
						<a class='btn btn-mini btn-primary' href='aksi-news-arsipNews.html'><i class='icon-plus-sign'></i> Arsip Berita</a>
					</div> 
					</div> 
<div class='widget-content'>
<p>$tanggal</p>
$w[isi]
</div></div>";
 }else{
ErrorAkses();
} ?>