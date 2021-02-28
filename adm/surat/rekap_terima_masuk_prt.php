<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
$tpl = LoadTpl("../../template/window.html");

nocache;

//nilai
$filenya = "rekap_terima_masuk.php";
$judul = "Rekap Terima Surat Masuk";
$judulku = $judul;
$judulx = $judul;
$terima_tgl = nosql($_REQUEST['terima_tgl']);
$terima_bln = nosql($_REQUEST['terima_bln']);
$terima_thn = nosql($_REQUEST['terima_thn']);
$tgl_terima = "$terima_thn:$terima_bln:$terima_tgl";
$terima2_tgl = nosql($_REQUEST['terima2_tgl']);
$terima2_bln = nosql($_REQUEST['terima2_bln']);
$terima2_thn = nosql($_REQUEST['terima2_thn']);
$tgl_terima2 = "$terima2_thn:$terima2_bln:$terima2_tgl";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "rekap_terima_masuk.php";
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
</table>
<p>
<big>
Jenjang Tanggal Terima dari <b>'.$terima_tgl.' '.$arrbln[$terima_bln].' '.$terima_thn.'</b> sampai <b>'.$terima2_tgl.' '.$arrbln[$terima2_bln].' '.$terima2_thn.'</b>.
</big>
<br>';



//query
$qdtu = mysqli_query($koneksi, "SELECT surat_masuk.*, surat_masuk.kd AS smkd, ".
			"surat_m_ruang.*, surat_m_lemari.*, surat_m_rak.*, ".
			"surat_m_map.* ".
			"FROM surat_masuk, surat_m_ruang, surat_m_lemari, ".
			"surat_m_rak, surat_m_map ".
			"WHERE surat_masuk.kd_ruang = surat_m_ruang.kd ".
			"AND surat_masuk.kd_lemari = surat_m_lemari.kd ".
			"AND surat_masuk.kd_rak = surat_m_rak.kd ".
			"AND surat_masuk.kd_map = surat_m_map.kd ".
			"AND surat_masuk.tgl_terima >= '$tgl_terima' ".
			"AND surat_masuk.tgl_terima <= '$tgl_terima2' ".
			"ORDER BY round(surat_masuk.no_urut) DESC");
$rdtu = mysqli_fetch_assoc($qdtu);
$tdtu = mysqli_num_rows($qdtu);

//jika ada
if ($tdtu != 0)
	{
	echo '<p>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">Tgl.Terima</font></strong></td>
	<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td><strong><font color="'.$warnatext.'">No. Surat</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Tgl.Surat</font></strong></td>
	<td width="200"><strong><font color="'.$warnatext.'">Asal</font></strong></td>
	<td width="200"><strong><font color="'.$warnatext.'">Tujuan</font></strong></td>
	<td width="200"><strong><font color="'.$warnatext.'">Perihal</font></strong></td>
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

		//nilai
		$ku_kd = nosql($rdtu['smkd']);
		$ku_no_urut = nosql($rdtu['no_urut']);
		$ku_no_surat = balikin2($rdtu['no_surat']);
		$ku_asal = balikin2($rdtu['asal']);
		$ku_tujuan = balikin2($rdtu['tujuan']);
		$ku_perihal = balikin2($rdtu['perihal']);
		$ku_kd_klasifikasi = nosql($rdtu['kd_klasifikasi']);
		$ku_kd_status = nosql($rdtu['kd_status']);
		$ku_tgl_surat = $rdtu['tgl_surat'];
		$ku_tgl_terima = $rdtu['tgl_terima'];
		$ku_kd_ruang = nosql($rdtu['kd_ruang']);
		$ku_kd_lemari = nosql($rdtu['kd_lemari']);
		$ku_kd_rak = nosql($rdtu['kd_rak']);
		$ku_kd_map = nosql($rdtu['kd_map']);






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
		echo '<td>'.$ku_tgl_terima.'</td>
		<td>'.$ku_no_urut.'</td>
		<td>'.$ku_no_surat.'</td>
		<td>'.$ku_tgl_surat.'</td>
		<td>'.$ku_asal.'</td>
		<td>'.$ku_tujuan.'</td>
		<td>'.$ku_perihal.'</td>
		<td>'.$dtx_klasifikasi.'</td>
		<td>'.$dtx3_status.'</td>
		<td>'.$dt1_ruang.'</td>
		<td>'.$dt2_lemari.'</td>
		<td>'.$dt3_rak.'</td>
		<td>'.$dt4_map.'</td>
		</tr>';
		}
	while ($rdtu = mysqli_fetch_assoc($qdtu));

	echo '</table>
	</p>';
	}
else
	{
	echo '<p>
	<font color="red">
	<b>TIDAK ADA DATA.</b>
	</font>
	</p>';
	}

echo '</p>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>