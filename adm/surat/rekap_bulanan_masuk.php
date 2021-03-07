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
$filenya = "rekap_bulanan_masuk.php";
$judul = "Rekap Bulanan Surat Masuk";
$judulku = "[SURAT MASUK] $judul";
$judulx = $judul;
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






//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");


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

	$sqlcount = "SELECT surat_masuk.*, ".
						"DATE_FORMAT(tgl_surat, '%d') AS surat_tgl, ".
						"DATE_FORMAT(tgl_surat, '%m') AS surat_bln, ".
						"DATE_FORMAT(tgl_surat, '%Y') AS surat_thn, ".
						"DATE_FORMAT(tgl_terima, '%d') AS terima_tgl, ".
						"DATE_FORMAT(tgl_terima, '%m') AS terima_bln, ".
						"DATE_FORMAT(tgl_terima, '%Y') AS terima_thn ".
						"FROM surat_masuk ".
						"WHERE round(DATE_FORMAT(tgl_surat, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(tgl_surat, '%Y')) = '$uthn' ".
						"ORDER BY tgl_surat DESC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?ubln=$ubln&uthn=$uthn";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	if ($count != 0)
		{
		echo '<p>
		[<a href="rekap_bulanan_masuk_prt.php?ubln='.$ubln.'&uthn='.$uthn.'"><img src="'.$sumber.'/img/print.gif" border="0" width="16" height="16"></a>]
		<table width="1200" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="5"><strong><font color="'.$warnatext.'">Tgl.</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">No. Urut</font></strong></td>
		<td><strong><font color="'.$warnatext.'">No. Surat</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Tgl.Terima</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Asal</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Tujuan</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Perihal</font></strong></td>
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
			$i_kd = nosql($data['kd']);
			$i_no_urut = nosql($data['no_urut']);
			$i_no_surat = balikin2($data['no_surat']);
			$i_asal = balikin2($data['asal']);
			$i_tujuan = balikin2($data['tujuan']);
			$i_perihal = balikin2($data['perihal']);
			$i_kd_klasifikasi = nosql($data['kd_klasifikasi']);
			$i_kd_status = nosql($data['kd_status']);
			$i_surat_tgl = nosql($data['surat_tgl']);
			$i_tgl_terima = $data['tgl_terima'];
			$i_kd_ruang = nosql($data['kd_ruang']);
			$i_kd_lemari = nosql($data['kd_lemari']);
			$i_kd_rak = nosql($data['kd_rak']);
			$i_kd_map = nosql($data['kd_map']);





			//klasifikasi
			$qdtx = mysqli_query($koneksi, "SELECT * FROM surat_m_klasifikasi ".
											"WHERE kd = '$i_kd_klasifikasi'");
			$rdtx = mysqli_fetch_assoc($qdtx);
			$dtx_klasifikasi = balikin($rdtx['klasifikasi']);


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
			echo '<td>'.$i_surat_tgl.'</td>
			<td>'.$i_no_urut.'</td>
			<td>'.$i_no_surat.'</td>
			<td>'.$i_tgl_terima.'</td>
			<td>'.$i_asal.'</td>
			<td>'.$i_tujuan.'</td>
			<td>'.$i_perihal.'</td>
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

	//null
	else
		{
		echo '<p>
		<font color="red"><strong>TIDAK ADA DATA SURAT MASUK</strong></font>
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