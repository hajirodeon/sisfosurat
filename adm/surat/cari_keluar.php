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
$filenya = "cari_keluar.php";
$judul = "Cari Surat Keluar";
$judulku = "$judul  [$surat_session : $nip11_session. $nm11_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//focus
$diload = "document.formx.kunci.focus();";




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
	//deteksi tanggal dahulu...
	$kunciku = $_POST['kunci'];
	$dd_tgl = substr($kunciku,8,2);
	$dd_bln = substr($kunciku,5,2);
	$dd_thn = substr($kunciku,0,4);
	$dd_tgl_cari = "$dd_thn-$dd_bln-$dd_tgl";

	if ($dd_tgl_cari == $kunciku)
		{
		$kunci_tgl = $dd_tgl_cari;
		}
	else
		{
		$kunci = balikin($_POST['kunci']);
		}


	//jika null
	if (empty($kunci))
		{
		echo '<p>
		<font color="red">
		<b>Kata Kunci Belum Dimasukkan. Harap Diperhatikan...!!</b>
		</font>
		</p>
		<p>
		[<a href="'.$filenya.'">Cari Lagi</a>]
		</p>';
		}
	else
		{
		echo '<p>
		[<a href="'.$filenya.'">Cari Lagi</a>]
		</p>
		<p>
		<br>
		[Kata Kunci : <b>'.balikin($kunci).'</b>].
		</p>
                <p>';



		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT surat_keluar.*, surat_keluar.kd AS smkd, ".
				"surat_m_ruang.*, surat_m_lemari.*, surat_m_rak.*, ".
				"surat_m_map.*, surat_m_klasifikasi.*, surat_m_status.* ".
				"FROM surat_keluar, surat_m_ruang, surat_m_lemari, ".
				"surat_m_rak, surat_m_map, surat_m_klasifikasi, surat_m_status ".
				"WHERE surat_keluar.kd_ruang = surat_m_ruang.kd ".
				"AND surat_keluar.kd_lemari = surat_m_lemari.kd ".
				"AND surat_keluar.kd_rak = surat_m_rak.kd ".
				"AND surat_keluar.kd_map = surat_m_map.kd ".
				"AND surat_keluar.kd_klasifikasi = surat_m_klasifikasi.kd ".
				"AND surat_keluar.kd_status = surat_m_status.kd ".
				"AND (surat_keluar.no_urut LIKE '%$kunci%' ".
				"OR surat_keluar.no_surat LIKE '%$kunci%' ".
				"OR surat_keluar.tujuan LIKE '%$kunci%' ".
				"OR surat_keluar.perihal LIKE '%$kunci%' ".
				"OR surat_m_klasifikasi.klasifikasi LIKE '%$kunci%' ".
				"OR surat_m_status.status LIKE '%$kunci%' ".
				"OR surat_m_ruang.ruang LIKE '%$kunci%' ".
				"OR surat_m_lemari.lemari LIKE '%$kunci%' ".
				"OR surat_m_rak.rak LIKE '%$kunci%' ".
				"OR surat_m_map.map LIKE '%$kunci%' ".
				"OR surat_keluar.tgl_kirim = '$dd_tgl_cari' ".
				"OR surat_keluar.tgl_surat = '$dd_tgl_cari') ".
				"ORDER BY round(surat_keluar.tgl_kirim) DESC";
		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);

		//jika ada
		if ($count != 0)
			{
			echo '<p>
			<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<tr bgcolor="'.$warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="100"><strong><font color="'.$warnatext.'">Tgl.Kirim</font></strong></td>
			<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
			<td><strong><font color="'.$warnatext.'">No. Surat</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Tgl.Surat</font></strong></td>
			<td width="200"><strong><font color="'.$warnatext.'">Tujuan</font></strong></td>
			<td width="200"><strong><font color="'.$warnatext.'">Perihal</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Klasifikasi</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Sifat</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Status</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Balas</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Ruang</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Lemari</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Rak</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">MAP</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Disposisi</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Sah</font></strong></td>
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
				$i_kd = nosql($data['smkd']);
				$i_no_urut = nosql($data['no_urut']);
				$i_no_surat = balikin2($data['no_surat']);
				$i_tujuan = balikin2($data['tujuan']);
				$i_tgl_surat = $data['tgl_surat'];
				$i_perihal = balikin2($data['perihal']);
				$i_tgl_kirim = $data['tgl_kirim'];

				$ku_kd_klasifikasi = nosql($data['kd_klasifikasi']);
				$ku_kd_sifat = nosql($data['kd_sifat']);
				$ku_kd_status = nosql($data['kd_status']);
				$ku_blskd = nosql($data['kd_balas']);
				$ku_tgl_surat = $data['tgl_surat'];
				$ku_tgl_kirim = $data['tgl_kirim'];
				$ku_kd_ruang = nosql($data['kd_ruang']);
				$ku_kd_lemari = nosql($data['kd_lemari']);
				$ku_kd_rak = nosql($data['kd_rak']);
				$ku_kd_map = nosql($data['kd_map']);



				//terpilih
				$qbls = mysqli_query($koneksi, "SELECT * FROM surat_m_balas ".
							"WHERE kd = '$ku_blskd'");
				$rbls = mysqli_fetch_assoc($qbls);
				$bls_balas = balikin($rbls['balas']);


				//klasifikasi
				$qdtx = mysqli_query($koneksi, "SELECT * FROM surat_m_klasifikasi ".
												"WHERE kd = '$ku_kd_klasifikasi'");
				$rdtx = mysqli_fetch_assoc($qdtx);
				$dtx_klasifikasi = balikin($rdtx['klasifikasi']);

				//sifat
				$qdtx2 = mysqli_query($koneksi, "SELECT * FROM surat_m_sifat ".
												"WHERE kd = '$ku_kd_sifat'");
				$rdtx2 = mysqli_fetch_assoc($qdtx2);
				$dtx2_sifat = balikin($rdtx2['sifat']);

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



				//pengesahan disposisi
				$qdux = mysqli_query($koneksi, "SELECT * FROM surat_keluar_disposisi ".
							"WHERE kd_surat = '$i_kd'");
				$rdux = mysqli_fetch_assoc($qdux);
				$tdux = mysqli_num_rows($qdux);
				$dux_pengesahan = nosql($rdux['pengesahan']);


				//sah...?
				if ($dux_pengesahan == "true")
					{
					$dux_pengesahan_ket = "<font color=\"blue\"><strong>SAH</strong>.</font>";
					}
				else
					{
					$dux_pengesahan_ket = "<font color=\"red\"><b>Belum Sah.</b></font>";
					}




				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<a href="keluar.php?s=edit&sukd='.$i_kd.'" title="EDIT">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>'.$i_tgl_kirim.'</td>
				<td>'.$i_no_urut.'</td>
				<td>'.$i_no_surat.'</td>
				<td>'.$i_tujuan.'</td>
				<td>'.$i_tgl_surat.'</td>
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
				<td>'.$dux_pengesahan_ket.'</td>
				</tr>';
				}
			while ($data = mysqli_fetch_assoc($result));

			echo '</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td align="right">Total : <strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
			</tr>
			</table>
			</p>';
			}
		else
			{
			echo '<p>
			<font color="red">
			<b>TIDAK ADA DATA DENGAN KATA KUNCI TERSEBUT...</b>
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
	Kata Kunci :
	<input type="text" name="kunci" value="" size="20">
	<input type="submit" name="btnCARI2" value="CARI">
	<input type="reset" name="btnBTL" value="BATAL">';
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