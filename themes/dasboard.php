<?php
defined('_FINDEX_') or die('Access Denied');
$w = GetFields('level', 'id_level', $_SESSION[levele], '*');
$level=strtoupper($w[level]);
?>
<div id="page-title" class="widget-header clearfix">
	<h1><span class='pull-left'>:: <?php echo $level;?> AREA ::</span> <span class='pull-right'>:: SISTEM INFORMASI AKADEMIK ::</span></h1>
</div>
<?php
echo"<div id='content'>
<div class='widget'><div class='row clearfix'><div class='span6'>
<div class='widget-header'>
		<h3>
			<i class='icon-info-sign'></i>
			Berita Terbaru...
		</h3>
	</div> 
<div class='widget-content'>
<table class='table table-striped'>     
			<thead>";
	$qry= _query("SELECT * FROM berita ORDER BY id DESC LIMIT 2") or die ();
	while ($r=_fetch_array($qry)){	
	$tanggal=tgl_indo($r['tanggal']);
	$isi_berita = htmlentities(strip_tags($r['isi'])); 
    $isi = substr($isi_berita,0,70);
    $isi = substr($isi_berita,0,strrpos($isi," "));		
		echo"<tr>
			<td><i class='icon-play'></i></td>
			<td>
				<a href='get-news-detailNews-$r[id].html'><h4>$r[judul] </h4></a>
				<i>$tanggal - $isi ... </i>
			</td>
		</tr>";
	}	
	echo"<tr>
			<td></td>
			<td><i class='pull-right'><a href='aksi-news-arsipNews.html'>Arsip Berita.... </a></i></td>
		</tr>
</thead> 
<tr><td colspan='2'>Perhatian : <br/>
						<ul>
							<li>Gunakan Hak Akses Anda dengan benar.</li>
							<li>Segala hal yang terjadi atas akun ini, Menjadi tanggung jawab anda.</li>
							<li>Semua kegiatan anda tercatat dalam system.</li>
							<li>Jangan Lupa untuk <b>Logout</b> Setelah selesai menggunakan aplikasi ini.</li>
						</ul>
				</td></tr>

		</table>
</div>
	</div>
<div class='span6'>
<div class='widget widget-minicalendar'>
	<div class='widget-header'>
		<h3>
			<i class='icon-calendar'></i>
			Kalender Akademik
		</h3>
	</div> <!-- /.widget-header -->
	<div class='widget-content'>
		<div id='datepicker-inline'></div> <!-- /#datepicker-inline -->
	</div> <!-- /.widget-content -->
</div> </div></div></div></div>"; 
?>
