<?php
//nilai
$maine = "$sumber/adm/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$maine.'" title="Home" class="menuku"><strong>HOME</strong>&nbsp;&nbsp;</a> | ';
//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu1"><strong>SETTING</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu1" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/adm/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//surat /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>SURAT</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="#" title="Master">Master</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/adm/surat/m_klasifikasi.php" title="Klasifikasi Surat">Klasifikasi Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/adm/surat/m_lemari.php" title="Lemari Surat">Lemari Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/adm/surat/m_rak.php" title="Rak Surat">Rak Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/adm/surat/m_ruang.php" title="Ruang Surat">Ruang Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/adm/surat/m_map.php" title="Map Surat">Map Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/adm/surat/m_sifat.php" title="Sifat Surat">Sifat Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/adm/surat/m_status.php" title="Status Surat">Status Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/adm/surat/m_indeks.php" title="Indeks Berkas">Indeks Berkas</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Surat Masuk">Surat Masuk</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/adm/surat/masuk.php" title="Data Surat Masuk">Data Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/penempatan_masuk.php" title="Penempatan Surat Masuk">Penempatan Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/cari_masuk.php" title="Cari Surat Masuk">Cari Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/masuk_berkas_disposisi.php" title="Indeks Berkas Disposisi">Indeks Berkas Disposisi</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/rekap_masuk.php" title="Rekap Surat Masuk">Rekap Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/rekap_bulanan_masuk.php" title="Rekap Bulanan Surat Masuk">Rekap Bulanan Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/rekap_terima_masuk.php" title="Rekap Terima Surat Masuk">Rekap Terima Surat Masuk</a>
	</LI>

	</UL>
</LI>



<LI>
<a href="#" title="Surat Keluar">Surat Keluar</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/adm/surat/keluar.php" title="Data Surat Keluar">Data Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/penempatan_keluar.php" title="Penempatan Surat Masuk">Penempatan Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/cari_keluar.php" title="Cari Surat Keluar">Cari Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/keluar_berkas_disposisi.php" title="Indeks Berkas Disposisi">Indeks Berkas Disposisi</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/rekap_keluar.php" title="Rekap Surat Keluar">Rekap Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/rekap_bulanan_keluar.php" title="Rekap Bulanan Surat Keluar">Rekap Bulanan Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/surat/rekap_kirim_keluar.php" title="Rekap Kirim Surat Keluar">Rekap Kirim Surat Keluar</a>
	</LI>
	</UL>
</LI>

</UL>';
//surat /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="'.$sumber.'/adm/logout.php" class="menuku" title="Logout / KELUAR"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>