<?php
defined('_FINDEX_') or die('Access Denied');
$id = $_REQUEST['id'];
$w = GetFields('matakuliah', 'Matakuliah_ID', $id, '*');
$PRODI=NamaProdi($w[Jurusan_ID]);
$KelompokMtk=KelompokMtk($w[KelompokMtk_ID]);
$NamaKonsentrasi=strtoupper(GetName("kurikulum","Kurikulum_ID",$w[Kurikulum_ID],"Nama"));
$NamaKurikulum=strtoupper(GetName("jeniskurikulum","JenisKurikulum_ID",$w[JenisKurikulum_ID],"Nama"));
$penanggungjwb=strtoupper(GetName("dosen","dosen_ID",$w[Penanggungjawab],"nama_lengkap"));
$sttus = ($w['Aktif'] == 'Y')? '<i class="icon-ok green"></i> AKTIF' : '<i class="icon-remove red"></i> NON-AKTIF';
$namaMtk=strtoupper($w['Nama_matakuliah']);
echo"<div class='widget widget-table'>
	<div class='widget-header'>	
		<h3><i class='icon-sign-blank'></i> MATAKULIAH :: $namaMtk</h3>			
	</div> 
					
	<div class='widget-content'>
		<table class='table table-bordered table-striped responsive'> 
		<thead>
			<tr>                             
				<th width='50%'>Matakuliah</th>
				<th>$w[Nama_matakuliah]</th>                             
			</tr>
		</thead>                       
		<tbody>
			<tr>
				<td class='description'>Program Studi</td>
				<td class='value'><span>$PRODI</span></td>
			</tr>
			<tr>
				<td class='description'>Kode Matakuliah</td>
				<td class='value'><span>$w[Kode_mtk]</span></td>
			</tr>
			<tr>
				<td class='description'>Kelompok Matakuliah</td>
				<td class='value'><span>$KelompokMtk</span></td>
			</tr>
			<tr>
				<td class='description'>Kurikulum</td>
				<td class='value'><span>$NamaKurikulum</span></td>
			</tr>
			<tr>
				<td class='description'>Konsentrasi</td>
				<td class='value'><span>$NamaKonsentrasi</span></td>
			</tr>
			<tr>
				<td class='description'>Di Semester</td>
				<td class='value'><span>$w[Semester]</span></td>
			</tr>  
			<tr>
				<td class='description'>Jumlah SKS</td>
				<td class='value'><span>$w[SKS]</span></td>
			</tr>
			<tr>
				<td class='description'>Penanggung Jawab</td>
				<td class='value'><span>$penanggungjwb</span></td>
			</tr>
			<tr>
				<td class='description'>Status Matakuliah</td>
				<td class='value'><span>$sttus</span></td>
			</tr>
			<tr>
				<td class='description'>GBPP</td>
				<td class='value'><span>$w[gbpp]</span></td>
			</tr>
			<tr>
				<td class='description'>SAP</td>
				<td class='value'><span>$w[sap]</span></td>
			</tr>   
			             
		</tbody>
	</table>
	</div> 
</div>";
?>
