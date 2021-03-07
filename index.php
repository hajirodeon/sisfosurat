<?php
session_start();


//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
require("inc/class/paging.php");
$tpl = LoadTpl("template/login.html");



nocache;

//nilai
$filenya = "index.php";
$filenya_ke = $sumber;
$judul = "Sistem Informasi Surat - Menyurat";
$s = nosql($_REQUEST['s']);
$judulku = $judul;






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnOK'])
	{
	//ambil nilai
	$username = nosql($_POST["usernamex"]);
	$password = md5(nosql($_POST["passwordx"]));

	//cek null
	if ((empty($username)) OR (empty($password)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query
		$q = mysqli_query($koneksi, "SELECT * FROM adminx ".
							"WHERE usernamex = '$username' ".
							"AND passwordx = '$password'");
		$row = mysqli_fetch_assoc($q);
		$total = mysqli_num_rows($q);

		//cek login
		if ($total != 0)
			{
			session_start();

			//bikin session
			$_SESSION['kd11_session'] = nosql($row['kd']);
			$_SESSION['username11_session'] = $username;
			$_SESSION['pass11_session'] = $password;
			$_SESSION['surat_session'] = "Petugas Pengarsip Surat";
			$_SESSION['hajirobe_session'] = $hajirobe;


			//diskonek
			xfree($q);
			xclose($koneksi);

			//re-direct
			$ke = "adm/index.php";
			xloc($ke);
			exit();
			}
		else
			{
			//diskonek
			xfree($q);
			xclose($koneksi);

			//re-direct
			$pesan = "Password Salah. Harap Diulangi...!!";
			pekem($pesan, $filenya);
			exit();
			}
		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="center">
<td width="100%">';


echo '<table bgcolor="gray" width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td>

<div id="d_utama">
<table bgcolor="#7b1f53" width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td>

<h2>
SISFOSURAT
</h2>
</td>
</tr>
</table>

<p>
Username :
<br>
<input name="usernamex" type="text" size="15" required>
</p>


<p>
Password :
<br>
<input name="passwordx" type="password" size="15" required>
</p>


<p>
<input name="btnOK" type="submit" value="OK &gt;&gt;&gt;" class="btn btn-danger">
</p>

<hr>
Contoh akses : 
<br>
user/pass : admin
<hr>	
</td>
</tr>
</table>

</div>';


echo '<table bgcolor="#d7a2bd" width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="right">
<td>
(c) 2021. '.$versi.'
</td>
</tr>
</table>








</td>
</tr>
</table>






</form>';



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>
