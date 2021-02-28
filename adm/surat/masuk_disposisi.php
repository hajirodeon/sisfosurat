<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsurat.php");
$tpl = LoadTpl("../../template/surat.html");

nocache;

//nilai
$filenya = "masuk_disposisi.php";
$judul = "Lembar Disposisi";
$judulku = "$judul  [$surat_session : $nip11_session. $nm11_session]";
$judulx = $judul;
$sukd = nosql($_REQUEST['sukd']);


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qx = mysqli_query($koneksi, "SELECT surat_masuk.*, ".
			"DATE_FORMAT(tgl_surat, '%d') AS surat_tgl, ".
			"DATE_FORMAT(tgl_surat, '%m') AS surat_bln, ".
			"DATE_FORMAT(tgl_surat, '%Y') AS surat_thn, ".
			"DATE_FORMAT(tgl_terima, '%d') AS terima_tgl, ".
			"DATE_FORMAT(tgl_terima, '%m') AS terima_bln, ".
			"DATE_FORMAT(tgl_terima, '%Y') AS terima_thn ".
			"FROM surat_masuk ".
			"WHERE kd = '$sukd'");
$rowx = mysqli_fetch_assoc($qx);
$x_no_urut = nosql($rowx['no_urut']);
$x_no_surat = balikin2($rowx['no_surat']);
$x_asal = balikin2($rowx['asal']);
$x_tujuan = balikin2($rowx['tujuan']);
$x_kd_klasifikasi = nosql($rowx['kd_klasifikasi']);
$x_surat_tgl = nosql($rowx['surat_tgl']);
$x_surat_bln = nosql($rowx['surat_bln']);
$x_surat_thn = nosql($rowx['surat_thn']);
$x_perihal = balikin2($rowx['perihal']);
$x_terima_tgl = nosql($rowx['terima_tgl']);
$x_terima_bln = nosql($rowx['terima_bln']);
$x_terima_thn = nosql($rowx['terima_thn']);


//detail disposisi
$qx2 = mysqli_query($koneksi, "SELECT surat_masuk_disposisi.*, ".
			"DATE_FORMAT(tgl_selesai, '%d') AS selesai_tgl, ".
			"DATE_FORMAT(tgl_selesai, '%m') AS selesai_bln, ".
			"DATE_FORMAT(tgl_selesai, '%Y') AS selesai_thn, ".
			"DATE_FORMAT(tgl_kembali, '%d') AS kembali_tgl, ".
			"DATE_FORMAT(tgl_kembali, '%m') AS kembali_bln, ".
			"DATE_FORMAT(tgl_kembali, '%Y') AS kembali_thn ".
			"FROM surat_masuk_disposisi ".
			"WHERE kd_surat = '$sukd'");
$rowx2 = mysqli_fetch_assoc($qx2);
$x2_inxkd = nosql($rowx2['kd_indeks']);
$x2_selesai_tgl = nosql($rowx2['selesai_tgl']);
$x2_selesai_bln = nosql($rowx2['selesai_bln']);
$x2_selesai_thn = nosql($rowx2['selesai_thn']);
$x2_kembali_tgl = nosql($rowx2['kembali_tgl']);
$x2_kembali_bln = nosql($rowx2['kembali_bln']);
$x2_kembali_thn = nosql($rowx2['kembali_thn']);
$x2_isi = balikin($rowx2['isi']);
$x2_diteruskan = balikin($rowx2['diteruskan']);
$x2_harap = balikin($rowx2['harap']);
$x2_catatan = balikin($rowx2['catatan']);
$x2_kepada = balikin($rowx2['kepada']);
$x2_pengesahan = nosql($rowx2['pengesahan']);

//jika sah
if ($x2_pengesahan == "true")
	{
	$x2_pengesahan_ket = "<strong>Telah Disahkan oleh Kepala Sekolah.</strong>";
	}
else
	{
	$x2_pengesahan_ket = "<strong>Belum Sah.</strong>";
	}



//jika null
if (empty($x2_diteruskan))
	{
	$x2_diteruskan = $x_tujuan;
	}


//terpilih
$qblsx = mysqli_query($koneksi, "SELECT * FROM surat_m_indeks ".
			"WHERE kd = '$x2_inxkd'");
$rblsx = mysqli_fetch_assoc($qblsx);
$blsx_indeks = balikin($rblsx['indeks']);





//jika simpan,
if ($_POST['btnSMP2'])
	{
	//nilai
	$sukd = nosql($_POST['sukd']);
	$i_selesai_tgl = nosql($_POST['selesai_tgl']);
	$i_selesai_bln = nosql($_POST['selesai_bln']);
	$i_selesai_thn = nosql($_POST['selesai_thn']);
	$tgl_selesai = "$i_selesai_thn:$i_selesai_bln:$i_selesai_tgl";
	$i_kembali_tgl = nosql($_POST['kembali_tgl']);
	$i_kembali_bln = nosql($_POST['kembali_bln']);
	$i_kembali_thn = nosql($_POST['kembali_thn']);
	$tgl_kembali = "$i_kembali_thn:$i_kembali_bln:$i_kembali_tgl";
	$i_isi_disposisi = cegah($_POST['isi_disposisi']);
	$i_diteruskan = cegah($_POST['diteruskan']);
	$i_harap = cegah($_POST['harap']);
	$i_catatan = cegah($_POST['catatan']);
	$i_kepada = cegah($_POST['kepada']);


	//cek
	$qcc = mysqli_query($koneksi, "SELECT * FROM surat_masuk_disposisi ".
				"WHERE kd_surat = '$sukd'");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);

	//jika ada
	if ($tcc != 0)
		{
		//update
		mysqli_query($koneksi, "UPDATE surat_masuk_disposisi SET tgl_selesai = '$tgl_selesai', ".
				"isi = '$i_isi_disposisi', ".
				"diteruskan = '$i_diteruskan', ".
				"kepada = '$i_kepada', ".
				"harap = '$i_harap', ".
				"catatan = '$i_catatan', ".
				"tgl_kembali = '$tgl_kembali' ".
				"WHERE kd_surat = '$sukd'");
		}
	else
		{
		//insert
		mysqli_query($koneksi, "INSERT INTO surat_masuk_disposisi (kd, kd_surat, tgl_selesai, ".
				"isi, diteruskan, kepada, ".
				"harap, catatan, tgl_kembali) VALUES ".
				"('$x', '$sukd', '$tgl_selesai', ".
				"'$i_isi_disposisi', '$i_diteruskan', '$i_kepada', ".
				"'$i_harap', '$i_catatan', '$tgl_kembali')");
		}

	//re-direct
	$ke = "$filenya?sukd=$sukd";
	xloc($ke);
	exit();
	}





//jika reset
if ($_POST['btnRST'])
	{
	//nilai
	$sukd = nosql($_POST['sukd']);

	//null-kan
	mysqli_query($koneksi, "UPDATE surat_masuk_disposisi SET tgl_selesai = '0000-00-00', ".
			"isi = '-', ".
			"diteruskan = '-', ".
			"kepada = '-', ".
			"tgl_kembali = '0000-00-00' ".
			"WHERE kd_surat = '$sukd'");

	//re-direct
	$ke = "$filenya?sukd=$sukd";
	xloc($ke);
	exit();
	}





//kembali ke daftar surat
if ($_POST['btnDFT'])
	{
	//re-direct
	$ke = "masuk.php";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//js
require("../../inc/js/swap.js");
require("../../inc/menu/admsurat.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td width="200">
No.Urut
</td>
<td>:
<input name="no_urut" type="text" value="'.$x_no_urut.'" size="10" class="input" readonly>
</td>
</tr>

<tr>
<td width="200">
Index Berkas
</td>
<td>:
<input name="indeks" type="text" value="'.$blsx_indeks.'" size="10" class="input" readonly>
</td>
</tr>

<tr>
<td width="200">
Kode Klasifkasi
</td>
<td>: ';
$qdtx = mysqli_query($koneksi, "SELECT * FROM surat_m_klasifikasi ".
								"WHERE kd = '$x_kd_klasifikasi'");
$rdtx = mysqli_fetch_assoc($qdtx);
$dtx_klasifikasi = balikin($rdtx['klasifikasi']);

echo '<input name="klasifikasi" type="text" value="'.$dtx_klasifikasi.'" size="20" class="input" readonly>
</td>
</tr>

<tr>
<td width="200">
Tanggal Surat
</td>
<td>:
<input name="tgl_surat" type="text" value="'.$x_surat_tgl.' '.$arrbln1[$x_surat_bln].' '.$x_surat_thn.'" size="20" class="input" readonly>
</td>
</tr>

<tr>
<td width="200">
Nomor Surat
</td>
<td>:
<input name="no_surat" type="text" value="'.$x_no_surat.'" size="20" class="input" readonly>
</td>
</tr>

<tr>
<td width="200">
Asal
</td>
<td>:
<input name="asal" type="text" value="'.$x_asal.'" size="30" class="input" readonly>
</td>
</tr>

<tr>
<td width="200">
Perihal Isi Ringkas
</td>
<td>:
<input name="perihal" type="text" value="'.$x_perihal.'" size="30" class="input" readonly>
</td>
</tr>

<tr>
<td width="200">
Tanggal Terima
</td>
<td>:
<input name="tgl_terima" type="text" value="'.$x_terima_tgl.' '.$arrbln1[$x_terima_bln].' '.$x_terima_thn.'" size="30" class="input" readonly>
</td>
</tr>

<tr>
<td width="200">
Tanggal Penyelesaian
</td>
<td>:
<select name="selesai_tgl">
<option value="'.$x2_selesai_tgl.'" selected>'.$x2_selesai_tgl.'</option>';
for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$i.'">'.$i.'</option>';
	}

echo '</select>
<select name="selesai_bln">
<option value="'.$x2_selesai_bln.'" selected>'.$arrbln1[$x2_selesai_bln].'</option>';
for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>
<select name="selesai_thn">
<option value="'.$x2_selesai_thn.'" selected>'.$x2_selesai_thn.'</option>';
for ($k=$surat01;$k<=$surat02;$k++)
	{
	echo '<option value="'.$k.'">'.$k.'</option>';
	}
echo '</select>
</td>
</tr>
</tr>
</table>
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<p>
Isi Disposisi :
<br>
<textarea name="isi_disposisi" rows="5" cols="50">'.$x2_isi.'</textarea>
</p>

<p>
Diteruskan kepada :
<br>
<textarea name="diteruskan" rows="5" cols="50">'.$x2_diteruskan.'</textarea>
</p>
<br>


<p>
Dengan hormat harap :
<br>
<input name="harap" type="text" value="'.$x2_harap.'" size="30">
</p>
<br>




<p>
Catatan :
<br>
<textarea name="catatan" rows="5" cols="50">'.$x2_catatan.'</textarea>
</p>
<br>


<p>
Sesudah digunakan, harap segera dikembalikan
<br>
Kepada :
<br>
<input type="text" name="kepada" value="'.$x2_kepada.'" size="30">
<br>
Tanggal :
<br>
<select name="kembali_tgl">
<option value="'.$x2_kembali_tgl.'" selected>'.$x2_kembali_tgl.'</option>';
for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$i.'">'.$i.'</option>';
	}

echo '</select>
<select name="kembali_bln">
<option value="'.$x2_kembali_bln.'" selected>'.$arrbln1[$x2_kembali_bln].'</option>';
for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>
<select name="kembali_thn">
<option value="'.$x2_kembali_thn.'" selected>'.$x2_kembali_thn.'</option>';
for ($k=$surat01;$k<=$surat02;$k++)
	{
	echo '<option value="'.$k.'">'.$k.'</option>';
	}
echo '</select>
</p>
<br>

<p>
Status Pengesahan :
<br>
'.$x2_pengesahan_ket.'
</p>

</td>
</tr>
</table>
<br>
<input type="hidden" name="sukd" value="'.$sukd.'">
<input type="submit" name="btnSMP2" value="SIMPAN">
<input type="submit" name="btnRST" value="RESET">

[<a href="masuk_disposisi_pdf.php?sukd='.$sukd.'" target="_blank"><img src="'.$sumber.'/img/pdf.gif" border="0" width="16" height="16"></a>]

<input type="submit" name="btnDFT" value="DAFTAR SURAT MASUK >>">
<br>
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