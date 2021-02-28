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
$filenya = "penempatan_keluar.php";
$judul = "Penempatan Surat Keluar";
$judulku = "$judul  [$surat_session : $nip11_session. $nm11_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//focus
if (empty($ubln))
	{
	$diload = "document.formx.ublnx.focus();";
	}
else if (empty($uthn))
	{
	$diload = "document.formx.uthnx.focus();";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$ruang = nosql($_POST['ruang']);
	$lemari = nosql($_POST['lemari']);
	$rak = nosql($_POST['rak']);
	$map = nosql($_POST['map']);
	$page = nosql($_POST['page']);


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT surat_keluar.*, ".
						"DATE_FORMAT(tgl_surat, '%d') AS surat_tgl, ".
						"DATE_FORMAT(tgl_surat, '%m') AS surat_bln, ".
						"DATE_FORMAT(tgl_surat, '%Y') AS surat_thn, ".
						"DATE_FORMAT(tgl_kirim, '%d') AS kirim_tgl, ".
						"DATE_FORMAT(tgl_kirim, '%m') AS kirim_bln, ".
						"DATE_FORMAT(tgl_kirim, '%Y') AS kirim_thn ".
						"FROM surat_keluar ".
						"WHERE round(DATE_FORMAT(tgl_surat, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(tgl_surat, '%Y')) = '$uthn' ".
						"ORDER BY tgl_surat DESC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?ubln=$ubln&uthn=$uthn";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	do
		{
		//nilai
		$i_nomer = $i_nomer + 1;
		$i_yuk = "item";
		$i_yuhu = "$i_yuk$i_nomer";
		$i_kd = nosql($_POST["$i_yuhu"]);


		//update
		mysqli_query($koneksi, "UPDATE surat_keluar SET kd_ruang = '$ruang', ".
							"kd_lemari = '$lemari', ".
							"kd_rak = '$rak', ".
							"kd_map = '$map' ".
							"WHERE kd = '$i_kd'");
		}
	while ($data = mysqli_fetch_assoc($result));


	//re-direct
	$ke = "$filenya?ubln=$ubln&uthn=$uthn";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admsurat.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Bulan dan Tahun Surat :
<br>';
echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.'">'.$arrbln[$ubln].'</option>';
for ($i=1;$i<=12;$i++)
	{
	echo '<option value="'.$filenya.'?ubln='.$i.'">'.$arrbln[$i].'</option>';
	}
echo '</select>';
echo "<select name=\"uthnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$uthn.'">'.$uthn.'</option>';
for ($j=$surat01;$j<=$surat02;$j++)
	{
	echo '<option value="'.$filenya.'?ubln='.$ubln.'&uthn='.$j.'">'.$j.'</option>';
	}

echo '</select>
</p>';


//cek
if ((empty($ubln)) OR (empty($uthn)))
	{
	echo '<p>
	<font color="red">
	<b>Bulan dan Tahun Surat Belum Dipilih...!!</b>
	</font>
	</p>';
	}
else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT surat_keluar.*, ".
						"DATE_FORMAT(tgl_surat, '%d') AS surat_tgl, ".
						"DATE_FORMAT(tgl_surat, '%m') AS surat_bln, ".
						"DATE_FORMAT(tgl_surat, '%Y') AS surat_thn, ".
						"DATE_FORMAT(tgl_kirim, '%d') AS kirim_tgl, ".
						"DATE_FORMAT(tgl_kirim, '%m') AS kirim_bln, ".
						"DATE_FORMAT(tgl_kirim, '%Y') AS kirim_thn ".
						"FROM surat_keluar ".
						"WHERE round(DATE_FORMAT(tgl_surat, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(tgl_surat, '%Y')) = '$uthn' ".
						"ORDER BY tgl_surat DESC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?ubln=$ubln&uthn=$uthn";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	if ($count != 0)
		{
		echo '<p>
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="5"><strong><font color="'.$warnatext.'">Tgl.</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">No. Urut</font></strong></td>
		<td><strong><font color="'.$warnatext.'">No. Surat</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Tgl.kirim</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Tujuan</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Perihal</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Klasifikasi</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Sifat</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Status</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Balasan</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Ruang</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Lemari</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Rak</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">MAP</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Disposisi</font></strong></td>
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
			$i_kd = nosql($data['kd']);
			$i_no_urut = nosql($data['no_urut']);
			$i_no_surat = balikin2($data['no_surat']);
			$i_tujuan = balikin2($data['tujuan']);
			$i_perihal = balikin2($data['perihal']);
			$i_kd_klasifikasi = nosql($data['kd_klasifikasi']);
			$i_kd_sifat = nosql($data['kd_sifat']);
			$i_kd_status = nosql($data['kd_status']);
			$i_blskd = nosql($data['kd_balas']);
			$i_surat_tgl = nosql($data['surat_tgl']);
			$i_tgl_kirim = $data['tgl_kirim'];
			$i_kd_ruang = nosql($data['kd_ruang']);
			$i_kd_lemari = nosql($data['kd_lemari']);
			$i_kd_rak = nosql($data['kd_rak']);
			$i_kd_map = nosql($data['kd_map']);



			//terpilih
			$qbls = mysqli_query($koneksi, "SELECT * FROM surat_m_balas ".
						"WHERE kd = '$i_blskd'");
			$rbls = mysqli_fetch_assoc($qbls);
			$bls_balas = balikin($rbls['balas']);


			//klasifikasi
			$qdtx = mysqli_query($koneksi, "SELECT * FROM surat_m_klasifikasi ".
											"WHERE kd = '$i_kd_klasifikasi'");
			$rdtx = mysqli_fetch_assoc($qdtx);
			$dtx_klasifikasi = balikin($rdtx['klasifikasi']);

			//sifat
			$qdtx2 = mysqli_query($koneksi, "SELECT * FROM surat_m_sifat ".
											"WHERE kd = '$i_kd_sifat'");
			$rdtx2 = mysqli_fetch_assoc($qdtx2);
			$dtx2_sifat = balikin($rdtx2['sifat']);

			//status
			$qdtx3 = mysqli_query($koneksi, "SELECT * FROM surat_m_status ".
											"WHERE kd = '$i_kd_status'");
			$rdtx3 = mysqli_fetch_assoc($qdtx3);
			$dtx3_status = balikin($rdtx3['status']);



			//ruang
			$qdt1 = mysqli_query($koneksi, "SELECT * FROM surat_m_ruang ".
											"WHERE kd = '$i_kd_ruang'");
			$rdt1 = mysqli_fetch_assoc($qdt1);
			$dt1_ruang = balikin($rdt1['ruang']);


			//lemari
			$qdt2 = mysqli_query($koneksi, "SELECT * FROM surat_m_lemari ".
											"WHERE kd = '$i_kd_lemari'");
			$rdt2 = mysqli_fetch_assoc($qdt2);
			$dt2_lemari = balikin($rdt2['lemari']);


			//rak
			$qdt3 = mysqli_query($koneksi, "SELECT * FROM surat_m_rak ".
											"WHERE kd = '$i_kd_rak'");
			$rdt3 = mysqli_fetch_assoc($qdt3);
			$dt3_rak = balikin($rdt3['rak']);


			//map
			$qdt4 = mysqli_query($koneksi, "SELECT * FROM surat_m_map ".
											"WHERE kd = '$i_kd_map'");
			$rdt4 = mysqli_fetch_assoc($qdt4);
			$dt4_map = balikin($rdt4['map']);




			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>
			<a href="keluar.php?s=edit&sukd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_surat_tgl.'</td>
			<td>'.$i_no_urut.'</td>
			<td>'.$i_no_surat.'</td>
			<td>'.$i_tgl_kirim.'</td>
			<td>'.$i_tujuan.'</td>
			<td>'.$i_perihal.'</td>
			<td>'.$dtx_klasifikasi.'</td>
			<td>'.$dtx2_sifat.'</td>
			<td>'.$dtx3_status.'</td>
			<td>'.$bls_balas.'</td>
			<td>'.$dt1_ruang.'</td>
			<td>'.$dt2_lemari.'</td>
			<td>'.$dt3_rak.'</td>
			<td>'.$dt4_map.'</td>
			<td>
			<a href="keluar_disposisi.php?sukd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			</tr>';
			}
		while ($data = mysqli_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="300">
		<input name="page" type="hidden" value="'.$page.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="ubln" type="hidden" value="'.$ubln.'">
		<input name="uthn" type="hidden" value="'.$uthn.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="reset" value="BATAL">
		</td>
		<td align="right">Total : <strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
		</tr>
		</table>
		</p>';



		echo '<p>
		Lokasi Pengarsipan Yang Baru :
		</p>
		<p>
		Ruang :
		<select name="ruang">
		<option value="" selected></option>';

		//daftar
		$qru = mysqli_query($koneksi, "SELECT * FROM surat_m_ruang ".
									"ORDER BY ruang ASC");
		$rru = mysqli_fetch_assoc($qru);

		do
			{
			//nilai
			$ru_kd = nosql($rru['kd']);
			$ru_ruang = balikin($rru['ruang']);

			echo '<option value="'.$ru_kd.'">'.$ru_ruang.'</option>';
			}
		while ($rru = mysqli_fetch_assoc($qru));

		echo'</select>,

		Lemari :
		<select name="lemari">
		<option value="" selected></option>';

		//daftar
		$qru = mysqli_query($koneksi, "SELECT * FROM surat_m_lemari ".
									"ORDER BY lemari ASC");
		$rru = mysqli_fetch_assoc($qru);

		do
			{
			//nilai
			$ru_kd = nosql($rru['kd']);
			$ru_lemari = balikin($rru['lemari']);

			echo '<option value="'.$ru_kd.'">'.$ru_lemari.'</option>';
			}
		while ($rru = mysqli_fetch_assoc($qru));

		echo'</select>,

		Rak :
		<select name="rak">
		<option value="" selected></option>';

		//daftar
		$qru = mysqli_query($koneksi, "SELECT * FROM surat_m_rak ".
									"ORDER BY rak ASC");
		$rru = mysqli_fetch_assoc($qru);

		do
			{
			//nilai
			$ru_kd = nosql($rru['kd']);
			$ru_rak = balikin($rru['rak']);

			echo '<option value="'.$ru_kd.'">'.$ru_rak.'</option>';
			}
		while ($rru = mysqli_fetch_assoc($qru));

		echo'</select>,

		MAP :
		<select name="map">
		<option value="" selected></option>';

		//daftar
		$qru = mysqli_query($koneksi, "SELECT * FROM surat_m_map ".
									"ORDER BY map ASC");
		$rru = mysqli_fetch_assoc($qru);

		do
			{
			//nilai
			$ru_kd = nosql($rru['kd']);
			$ru_map = balikin($rru['map']);

			echo '<option value="'.$ru_kd.'">'.$ru_map.'</option>';
			}
		while ($rru = mysqli_fetch_assoc($qru));

		echo'</select>
		</p>

		<p>
		<input name="page" type="hidden" value="'.$page.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="ubln" type="hidden" value="'.$ubln.'">
		<input name="uthn" type="hidden" value="'.$uthn.'">
		<input name="btnSMP" type="submit" value="SIMPAN >>">
		</p>';
		}

	//null
	else
		{
		echo '<p>
		<font color="red"><strong>TIDAK ADA DATA SURAT keluar</strong></font>
		<p>';
		}

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