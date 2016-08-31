<?php
buka("Dashboard");
$level= ceklevel($_SESSION[yapane]);
$tbl = GetaField('level', 'id_level', $level, 'TabelUser');
$prof= _query("SELECT * FROM $tbl WHERE username='$_SESSION[yapane]'") or die ("SQL Error:".mysql_error());
$data= _fetch_array($prof);
if ($data[foto]!=''){
	$foto= "<img class='gambar' src='$data[foto]' width=180 height=160 hspace=10 vspace=30 border=0 align=left>";
	}else{
	$foto= "<img class='gambar' src='../yapan/img/icon.png' width=180 height=160 hspace=10 vspace=30 border=0 align=left>";
}
$user= _query("SELECT * FROM useryapan WHERE username='$_SESSION[yapane]'") or die ("SQL Error:".mysql_error());
$dataUser= _fetch_array($user);
$dept=NamaDepatmen($dataUser[Bagian]);
$NamaProdi=NamaProdi($dataUser[kodeProdi]);
$Jbatan=JabatanStaff($dataUser[Jabatan]);  
$jabatan=$_SESSION[Jabatan];  
$dibagian=($_SESSION[levele]==4)? 'Di Program Studi <b>'.$NamaProdi.'</b>': 'Di Bagian <b>'.$dept.'</b>';    
echo"<div class='panel-content panel-tables'>
		<table class='table table-striped'>     
			<thead>
				<tr><th rowspan='4' width='25%' valign='top'>$foto</th><th>Selamat Datang Kembali, $_SESSION[Nama].</th></tr>
				<tr><td colspan='2'>Anda Login Sebagai, <b>$Jbatan</b> $dibagian </td></tr>
				<tr><td colspan='2'>Catatan : <br/>
						<ul>
							<li>Gunakan Hak Akses Anda dengan benar.</li>
							<li>Segala hal yang terjadi atas akun ini, Menjadi tanggung jawab anda.</li>
							<li>Semua kegiatan anda tercatat dalam system.</li>
							<li>Jangan Lupa untuk <b>Logout</b> Setelah selesai menggunakan aplikasi ini.</li>
						</ul>
				</td></tr>
				<tr><td colspan='2'><p class='pull-right'>&copy; 2013 STIE YAPAN - Surabaya</p></td></tr>
			</thead> 
		</table>
	</div>"; 
 tutup();
?>
