<?php
session_start();

//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");

nocache;


//re-direct
$pesan = "Waktu Sesi Login Telah Habis. Silahkan Login Kembali...!!";
pekem($pesan,$sumber);
exit();
?>