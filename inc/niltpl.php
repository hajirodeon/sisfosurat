<?php
//nilai /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$konten = ParseVal($tpl, array ("judul" => $judul,
					"judulku" => $judulku,
					"sumber" => $sumber,
					"isi" => $isi,
					"isi_banner" => $isi_banner,
					"isi_menu" => $isi_menu,
					"diload" => $diload,
					"versi" => $versi,
					"author" => $author,
					"keywords" => $keywords,
					"url" => $url,
					"sesidt" => $sesidt,
					"filenya" => $filenya,
					"wkdet" => $wkdet,
					"wkurl" => $wkurl,
					"sek_nama" => $sek_nama,
					"sek_alamat" => $sek_alamat,
					"sek_kontak" => $sek_kontak,
					"sek_kota" => $sek_kota,
					"sek_filex" => $sek_filex,
					"sek_filexx" => $sek_filexx,
					"description" => $description));

//tampilkan
echo $konten;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//kill process //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
set_time_limit(600);  //set maksimal loading : 600 detik atau 10 menit
$result=mysqli_query($koneksi, "show processlist");
while ($row=mysqli_fetch_array($result))
	{
	$process_id=$row["Id"];

	if (($row["Time"] > 0) OR ($row["Command"]=="Sleep"))
		{
		//print $row["Id"];
		$sql="kill $process_id";
		mysqli_query($sql);
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>