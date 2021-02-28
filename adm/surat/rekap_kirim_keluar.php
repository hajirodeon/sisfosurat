<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsurat.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/surat.html");

nocache;

//nilai
$filenya = "rekap_kirim_keluar.php";
$judul = "Rekap Kirim Surat Keluar";
$judulku = "$judul  [$surat_session : $nip11_session. $nm11_session]";
$judulx = $judul;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admsurat.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//cari
if ($_POST['btnCARI2'])
{
//nilai
$kunci = cegah($_POST['kunci']);
$kat = nosql($_POST['kat']);
$kirim_tgl = nosql($_POST['kirim_tgl']);
$kirim_bln = nosql($_POST['kirim_bln']);
$kirim_thn = nosql($_POST['kirim_thn']);
$tgl_kirim = "$kirim_thn:$kirim_bln:$kirim_tgl";
$kirim2_tgl = nosql($_POST['kirim2_tgl']);
$kirim2_bln = nosql($_POST['kirim2_bln']);
$kirim2_thn = nosql($_POST['kirim2_thn']);
$tgl_kirim2 = "$kirim2_thn:$kirim2_bln:$kirim2_tgl";


//jika null
if (($tgl_kirim == "::") OR ($tgl_kirim == "::"))
	{
	echo '<p>
	<font color="red">
	<b>Jenjang Tanggal kirim, Harus Diisi. Harap Diperhatikan...!!</b>
	</font>
	</p>
	<p>
	[<a href="'.$filenya.'">Lihat Rekap Lagi</a>]
	</p>';
	}
else
	{
	echo '<p>
	[<a href="'.$filenya.'">Lihat Rekap Lagi</a>]
	</p>
	<p>
	<big>
	Jenjang Tanggal kirim dari <b>'.$kirim_tgl.' '.$arrbln[$kirim_bln].' '.$kirim_thn.'</b> sampai <b>'.$kirim2_tgl.' '.$arrbln[$kirim2_bln].' '.$kirim2_thn.'</b>.
	</big>
	<br>';


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT surat_keluar.*, surat_keluar.kd AS smkd, ".
						"surat_m_ruang.*, surat_m_lemari.*, surat_m_rak.*, ".
						"surat_m_map.* ".
						"FROM surat_keluar, surat_m_ruang, surat_m_lemari, ".
						"surat_m_rak, surat_m_map ".
						"WHERE surat_keluar.kd_ruang = surat_m_ruang.kd ".
						"AND surat_keluar.kd_lemari = surat_m_lemari.kd ".
						"AND surat_keluar.kd_rak = surat_m_rak.kd ".
						"AND surat_keluar.kd_map = surat_m_map.kd ".
						"AND surat_keluar.tgl_kirim >= '$tgl_kirim' ".
						"AND surat_keluar.tgl_kirim <= '$tgl_kirim2' ".
						"ORDER BY round(surat_keluar.no_urut) DESC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);

	//jika ada
	if ($count != 0)
		{
		echo '<p>
		[<a href="rekap_kirim_keluar_prt.php?kirim_tgl='.$kirim_tgl.'&kirim_bln='.$kirim_bln.'&kirim_thn='.$kirim_thn.'&kirim2_tgl='.$kirim2_tgl.'&kirim2_bln='.$kirim2_bln.'&kirim2_thn='.$kirim2_thn.'"><img src="'.$sumber.'/img/print.gif" border="0" width="16" height="16"></a>]

		<table width="1200" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="100"><strong><font color="'.$warnatext.'">Tgl.kirim</font></strong></td>
		<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
		<td><strong><font color="'.$warnatext.'">No. Surat</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Tgl.Surat</font></strong></td>
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
			$ku_kd = nosql($data['smkd']);
			$ku_no_urut = nosql($data['no_urut']);
			$ku_no_surat = balikin2($data['no_surat']);
			$ku_tujuan = balikin2($data['tujuan']);
			$ku_perihal = balikin2($data['perihal']);
			$ku_kd_klasifikasi = nosql($data['kd_klasifikasi']);
			$ku_kd_status = nosql($data['kd_status']);
			$ku_tgl_surat = $data['tgl_surat'];
			$ku_tgl_kirim = $data['tgl_kirim'];
			$ku_kd_ruang = nosql($data['kd_ruang']);
			$ku_kd_lemari = nosql($data['kd_lemari']);
			$ku_kd_rak = nosql($data['kd_rak']);
			$ku_kd_map = nosql($data['kd_map']);


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
			echo '<td>'.$ku_tgl_kirim.'</td>
			<td>'.$ku_no_urut.'</td>
			<td>'.$ku_no_surat.'</td>
			<td>'.$ku_tgl_surat.'</td>
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
		while ($data = mysqli_fetch_assoc($result));

		echo '</table>
		<table width="1200" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>Total : <strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
		</tr>
		</table>
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

	echo '
	</p>';
	}
}

else
{
echo '<p>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td width="200">
Tanggal kirim dari Tanggal
</td>
<td>:
<select name="kirim_tgl">
<option value="" selected></option>';
for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$i.'">'.$i.'</option>';
	}

echo '</select>
<select name="kirim_bln">
<option value="" selected></option>';
for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>
<select name="kirim_thn">
<option value="" selected></option>';
for ($k=$surat01;$k<=$surat02;$k++)
	{
	echo '<option value="'.$k.'">'.$k.'</option>';
	}
echo '</select>
</td>
</tr>

<tr>
<td width="200">
Sampai tanggal
</td>
<td>:
<select name="kirim2_tgl">
<option value="" selected></option>';
for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$i.'">'.$i.'</option>';
	}

echo '</select>
<select name="kirim2_bln">
<option value="" selected></option>';
for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>
<select name="kirim2_thn">
<option value="" selected></option>';
for ($k=$surat01;$k<=$surat02;$k++)
	{
	echo '<option value="'.$k.'">'.$k.'</option>';
	}
echo '</select>
</td>
</tr>
</table>

<input type="submit" name="btnCARI2" value="OK >>">';
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