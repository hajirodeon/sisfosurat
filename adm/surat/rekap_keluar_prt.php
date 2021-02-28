<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
$tpl = LoadTpl("../../template/window.html");

nocache;

//nilai
$filenya = "rekap_keluar.php";
$judul = "Rekap Surat Keluar";
$judulku = $judul;
$judulx = $judul;





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "rekap_keluar.php";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();


//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="center">';
xheadline($judul);

echo '</td>
</tr>
</table>';

//daftar surat //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qdt = mysqli_query($koneksi, "SELECT * FROM surat_keluar ".
			"ORDER BY tgl_kirim DESC");
$rdt = mysqli_fetch_assoc($qdt);
$tdt = mysqli_num_rows($qdt);

if ($tdt != 0)
	{
	echo '<p>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">Tgl. kirim</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">No. Urut</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">No. Surat</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Tujuan</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Tgl. Surat</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Perihal</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Klasifikasi</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Status</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Ruang</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Lemari</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Rak</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">MAP</font></strong></td>
	</tr>';

	do
		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			}

		$nomer = $nomer + 1;
		$i_kd = nosql($rdt['kd']);
		$i_no_urut = nosql($rdt['no_urut']);
		$i_no_surat = balikin2($rdt['no_surat']);
		$i_tujuan = balikin2($rdt['tujuan']);
		$i_tgl_surat = $rdt['tgl_surat'];
		$i_perihal = balikin2($rdt['perihal']);
		$i_tgl_kirim = $rdt['tgl_kirim'];

		$ku_kd_klasifikasi = nosql($rdt['kd_klasifikasi']);
		$ku_kd_status = nosql($rdt['kd_status']);
		$ku_tgl_surat = $rdt['tgl_surat'];
		$ku_tgl_kirim = $rdt['tgl_kirim'];
		$ku_kd_ruang = nosql($rdt['kd_ruang']);
		$ku_kd_lemari = nosql($rdt['kd_lemari']);
		$ku_kd_rak = nosql($rdt['kd_rak']);
		$ku_kd_map = nosql($rdt['kd_map']);


		//klasifikasi
		$qdtx = mysqli_query($koneksi, "SELECT * FROM surat_m_klasifikasi ".
										"WHERE kd = '$ku_kd_klasifikasi'");
		$rdtx = mysqli_fetch_assoc($qdtx);
		$dtx_klasifikasi = balikin($rdtx['klasifikasi']);

		//status
		$qdtx3 = mysqli_query($koneksi, "SELECT * FROM surat_m_status ".
										"WHERE kd = '$ku_kd_status'");
		$rdtx3 = mysqli_fetch_assoc($qdtx3);
		$dtx3_status = balikin($rdtx3['status']);


		//ruang
		$qdt1 = mysqli_query($koneksi, "SELECT * FROM surat_m_ruang ".
										"WHERE kd = '$ku_kd_ruang'");
		$rdt1 = mysqli_fetch_assoc($qdt1);
		$dt1_ruang = balikin($rdt1['ruang']);


		//lemari
		$qdt2 = mysqli_query($koneksi, "SELECT * FROM surat_m_lemari ".
										"WHERE kd = '$ku_kd_lemari'");
		$rdt2 = mysqli_fetch_assoc($qdt2);
		$dt2_lemari = balikin($rdt2['lemari']);


		//rak
		$qdt3 = mysqli_query($koneksi, "SELECT * FROM surat_m_rak ".
										"WHERE kd = '$ku_kd_rak'");
		$rdt3 = mysqli_fetch_assoc($qdt3);
		$dt3_rak = balikin($rdt3['rak']);


		//map
		$qdt4 = mysqli_query($koneksi, "SELECT * FROM surat_m_map ".
										"WHERE kd = '$ku_kd_map'");
		$rdt4 = mysqli_fetch_assoc($qdt4);
		$dt4_map = balikin($rdt4['map']);





		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_tgl_kirim.'</td>
		<td>'.$i_no_urut.'</td>
		<td>'.$i_no_surat.'</td>
		<td>'.$i_tujuan.'</td>
		<td>'.$i_tgl_surat.'</td>
		<td>'.$i_perihal.'</td>
		<td>'.$dtx_klasifikasi.'</td>
		<td>'.$dtx3_status.'</td>
		<td>'.$dt1_ruang.'</td>
		<td>'.$dt2_lemari.'</td>
		<td>'.$dt3_rak.'</td>
		<td>'.$dt4_map.'</td>
		</tr>';
		}
	while ($rdt = mysqli_fetch_assoc($qdt));

	echo '</table>
	</p>';
	}

//null
else
	{
	echo '<p>
	<font color="red"><strong>TIDAK ADA DATA SURAT KELUAR</strong></font>
	<p>';
	}


echo '<br>
<br>
<br>
</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>