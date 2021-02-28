<?php
//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/disposisi_keluar.php");

nocache;


//start class
$pdf=new PDF("P","mm","A4");
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);
$pdf->SetAutoPageBreak(true,1);


//nilai
$judul = "Disposisi Surat Keluar";
$judulz = $judul;
$sukd = nosql($_REQUEST['sukd']);



//query
$qx = mysqli_query($koneksi, "SELECT surat_keluar.*, ".
							"DATE_FORMAT(tgl_surat, '%d') AS surat_tgl, ".
							"DATE_FORMAT(tgl_surat, '%m') AS surat_bln, ".
							"DATE_FORMAT(tgl_surat, '%Y') AS surat_thn, ".
							"DATE_FORMAT(tgl_kirim, '%d') AS kirim_tgl, ".
							"DATE_FORMAT(tgl_kirim, '%m') AS kirim_bln, ".
							"DATE_FORMAT(tgl_kirim, '%Y') AS kirim_thn ".
							"FROM surat_keluar ".
							"WHERE kd = '$sukd'");
$rowx = mysqli_fetch_assoc($qx);
$x_no_urut = nosql($rowx['no_urut']);
$x_no_surat = balikin2($rowx['no_surat']);
$x_tujuan = balikin2($rowx['tujuan']);
$x_kd_klasifikasi = nosql($rowx['kd_klasifikasi']);
$x_surat_tgl = nosql($rowx['surat_tgl']);
$x_surat_bln = nosql($rowx['surat_bln']);
$x_surat_thn = nosql($rowx['surat_thn']);
$x_perihal = balikin2($rowx['perihal']);
$x_kirim_tgl = nosql($rowx['kirim_tgl']);
$x_kirim_bln = nosql($rowx['kirim_bln']);
$x_kirim_thn = nosql($rowx['kirim_thn']);


//detail disposisi
$qx2 = mysqli_query($koneksi, "SELECT surat_keluar_disposisi.*, ".
							"DATE_FORMAT(tgl_selesai, '%d') AS selesai_tgl, ".
							"DATE_FORMAT(tgl_selesai, '%m') AS selesai_bln, ".
							"DATE_FORMAT(tgl_selesai, '%Y') AS selesai_thn, ".
							"DATE_FORMAT(tgl_kembali, '%d') AS kembali_tgl, ".
							"DATE_FORMAT(tgl_kembali, '%m') AS kembali_bln, ".
							"DATE_FORMAT(tgl_kembali, '%Y') AS kembali_thn ".
							"FROM surat_keluar_disposisi ".
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
$x2_kepada = balikin($rowx2['kepada']);



//jika null
if (($x2_selesai_tgl == "00") OR ($x2_selesai_bln == "00") OR ($x2_selesai_thn == "0000"))
	{
	$x2_selesai = "";
	}
else
	{
	$x2_selesai = "$x2_selesai_tgl $arrbln1[$x2_selesai_bln] $x2_selesai_thn";
	}



//terpilih
$qblsx = mysqli_query($koneksi, "SELECT * FROM surat_m_indeks ".
			"WHERE kd = '$x2_inxkd'");
$rblsx = mysqli_fetch_assoc($qblsx);
$blsx_indeks = balikin($rblsx['indeks']);


$qdtx = mysqli_query($koneksi, "SELECT * FROM surat_m_klasifikasi ".
			"WHERE kd = '$x_kd_klasifikasi'");
$rdtx = mysqli_fetch_assoc($qdtx);
$dtx_klasifikasi = balikin($rdtx['klasifikasi']);





//isi *START
ob_start();



$pdf->SetFont('Times','',8);


//header
$pdf->AddPage();

$pdf->SetY(30);



$pdf->SetX(12);
$pdf->SetFont('arial','BU',14);
$pdf->Cell(135,5,'LEMBAR DISPOSISI',0,0,'C');
$pdf->Ln();

$pdf->SetY(50);
$pdf->SetX(12);
$pdf->SetFont('Times','',10);
$pdf->Cell(19,10,'  Indeks berkas : '.$blsx_indeks.'',0,0,'L');



$pdf->SetX(100);
$pdf->Cell(10,10,'Kode : '.$dtx_klasifikasi.'',0,0,'L');


$pdf->SetX(12);
$pdf->Cell(135,10,'',1,0,'C');
$pdf->Ln();


$pdf->SetY(60);
$pdf->SetX(12);
$pdf->Cell(135,40,'',1,0,'C');
$pdf->Ln();

$pdf->SetY(63);
$pdf->SetX(12);
$pdf->Cell(20,7,'  Tanggal / Nomor',0,0,'L');
$pdf->SetX(55);
$pdf->Cell(97,7,'  : '.$x_surat_tgl.' '.$arrbln1[$x_surat_bln].' '.$x_surat_thn.' / '.$x_no_surat.'',0,0,'L');
$pdf->Ln();

$pdf->SetX(12);
$pdf->Cell(20,7,'  Tujuan',0,0,'L');
$pdf->SetX(55);
$pdf->Cell(97,7,'  : '.$x_tujuan.'',0,0,'L');
$pdf->Ln();

$pdf->SetX(12);
$pdf->Cell(20,7,'  Isi Ringkas',0,0,'L');
$pdf->SetX(55);
$pdf->Cell(97,7,'  : '.$x_perihal.'',0,0,'L');
$pdf->Ln();

$pdf->SetX(12);
$pdf->Cell(20,7,'',0,0,'L');
$pdf->SetX(55);
$pdf->Cell(97,7,'',0,0,'L');
$pdf->Ln();

$pdf->SetX(12);
$pdf->Cell(20,7,'  Dikirim Tanggal',0,0,'L');
$pdf->SetX(55);
$pdf->Cell(97,7,'  : '.$x_kirim_tgl.' '.$arrbln1[$x_kirim_bln].' '.$x_kirim_thn.'',0,0,'L');


$pdf->SetY(100);
$pdf->SetX(12);
$pdf->Cell(135,10,'  Tanggal Penyelesaian : '.$x2_selesai_tgl.' '.$arrbln1[$x2_selesai_bln].' '.$x2_selesai_thn.'',1,0,'L');
$pdf->Ln();

$pdf->SetX(12);
$pdf->Cell(67.5,70,'',1,0,'L');
$pdf->Cell(67.5,70,'',1,0,'L');



$pdf->SetY(112);
$pdf->SetX(12);
$pdf->Cell(67.5,5,'   Isi disposisi : ',0,0,'L');


$pdf->SetY(112);
$pdf->SetX(80);
$pdf->Cell(67.5,5,'Diteruskan kepada : ',0,0,'L');
$pdf->Ln();
$pdf->SetX(80);
$pdf->Cell(67.5,5,'',0,0,'L');
$pdf->Ln();
$pdf->SetX(80);
$pdf->Cell(67.5,5,'',0,0,'L');
$pdf->Ln();
$pdf->SetX(80);
$pdf->Cell(67.5,5,'',0,0,'L');


$pdf->SetY(180);
$pdf->SetX(12);
$pdf->Cell(135,20,'',1,0,'L');


$pdf->SetY(180);
$pdf->SetX(12);
$pdf->Cell(135,7,'Sesudah digunakan harap segera dikembalikan',0,0,'C');
$pdf->Ln();
$pdf->SetX(12);
$pdf->Cell(20,7,'  K e p a d a',0,0,'L');
$pdf->Cell(115,7,'  : '.$x2_kepada.'',0,0,'L');
$pdf->Ln();
$pdf->SetX(12);
$pdf->Cell(20,7,'  T a n g g a l',0,0,'L');
$pdf->Cell(115,7,'  : '.$x2_kembali_tgl.' '.$arrbln1[$x2_kembali_bln].' '.$x2_kembali_thn.'',0,0,'L');







//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("disposisi_surat_keluar.pdf",I);
?>