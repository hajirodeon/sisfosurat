-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 05 Mei 2016 pada 05.28
-- Versi Server: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisfosurat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `adminx`
--

CREATE TABLE `adminx` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `usernamex` varchar(15) NOT NULL DEFAULT '',
  `passwordx` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `adminx`
--

INSERT INTO `adminx` (`kd`, `usernamex`, `passwordx`) VALUES
('e4ea2f7dfb2e5c51e38998599e90afc2', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `kd` varchar(50) NOT NULL,
  `no_urut` varchar(10) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `tgl_surat` date NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `tgl_kirim` date NOT NULL,
  `kd_lemari` varchar(50) NOT NULL,
  `kd_rak` varchar(50) NOT NULL,
  `kd_ruang` varchar(50) NOT NULL,
  `kd_sifat` varchar(50) NOT NULL,
  `lampiran` varchar(255) NOT NULL,
  `tembusan` varchar(255) NOT NULL,
  `tgl_deadline_balas` date NOT NULL,
  `kd_balas` varchar(50) NOT NULL,
  `ket` varchar(255) NOT NULL,
  `kd_status` varchar(50) NOT NULL,
  `kd_klasifikasi` varchar(50) NOT NULL,
  `kd_map` varchar(50) NOT NULL,
  `filex` varchar(255) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_keluar`
--

INSERT INTO `surat_keluar` (`kd`, `no_urut`, `no_surat`, `tujuan`, `tgl_surat`, `perihal`, `tgl_kirim`, `kd_lemari`, `kd_rak`, `kd_ruang`, `kd_sifat`, `lampiran`, `tembusan`, `tgl_deadline_balas`, `kd_balas`, `ket`, `kd_status`, `kd_klasifikasi`, `kd_map`, `filex`, `postdate`) VALUES
('96a145b34677b79b38ecf65d773b23dc', '1', '1', '1', '2016-01-01', '1', '2016-01-01', '4b1c8fa9d0227614028982dcb05699ab', '26aef6699466f68a4b34df29189bc288', '19c48645e0864e858e3b720d82026f96', 'c2dd7ddae9f6f3b7aff7c927c6b43b9f', '1', '1', '2016-01-01', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', '1', '019e1e76f3197e32adeaa051131e93bb', '83081441521368fcfba137363dff322f', '09e6aff8f9c1185cac15f760d5254b2e', '11350619_10153223733504003_6169263379685000393_n.jpg', '2016-05-05 03:53:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_keluar_disposisi`
--

CREATE TABLE `surat_keluar_disposisi` (
  `kd` varchar(50) NOT NULL,
  `kd_indeks` varchar(50) NOT NULL,
  `kd_surat` varchar(50) NOT NULL,
  `tgl_selesai` date NOT NULL,
  `isi` varchar(255) NOT NULL,
  `diteruskan` varchar(255) NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kepada` varchar(100) NOT NULL,
  `pengesahan` enum('true','false') NOT NULL DEFAULT 'false',
  `harap` varchar(255) NOT NULL,
  `catatan` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_keluar_disposisi`
--

INSERT INTO `surat_keluar_disposisi` (`kd`, `kd_indeks`, `kd_surat`, `tgl_selesai`, `isi`, `diteruskan`, `tgl_kembali`, `kepada`, `pengesahan`, `harap`, `catatan`) VALUES
('96a145b34677b79b38ecf65d773b23dc', '43cfde50ef23832c124daf79e62c26fb', '96a145b34677b79b38ecf65d773b23dc', '2016-01-01', '1', '1', '2016-01-01', '1', 'false', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_keluar_kendali`
--

CREATE TABLE `surat_keluar_kendali` (
  `kd` varchar(50) NOT NULL,
  `kd_indeks` varchar(50) NOT NULL,
  `kd_surat` varchar(50) NOT NULL,
  `tgl_selesai` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kepada` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_keluar_kendali`
--

INSERT INTO `surat_keluar_kendali` (`kd`, `kd_indeks`, `kd_surat`, `tgl_selesai`, `tgl_kembali`, `kepada`) VALUES
('96a145b34677b79b38ecf65d773b23dc', '43cfde50ef23832c124daf79e62c26fb', '96a145b34677b79b38ecf65d773b23dc', '2016-01-01', '2016-01-01', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `kd` varchar(50) NOT NULL,
  `no_urut` varchar(10) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `asal` varchar(255) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `tgl_surat` date NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `tgl_terima` date NOT NULL,
  `kd_lemari` varchar(50) NOT NULL,
  `kd_rak` varchar(50) NOT NULL,
  `kd_map` varchar(50) NOT NULL,
  `kd_ruang` varchar(50) NOT NULL,
  `kd_sifat` varchar(50) NOT NULL,
  `lampiran` varchar(255) NOT NULL,
  `tembusan` varchar(255) NOT NULL,
  `tgl_deadline_balas` date NOT NULL,
  `kd_balas` varchar(50) NOT NULL,
  `ket` varchar(255) NOT NULL,
  `kd_status` varchar(50) NOT NULL,
  `kd_klasifikasi` varchar(50) NOT NULL,
  `filex` varchar(255) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_masuk`
--

INSERT INTO `surat_masuk` (`kd`, `no_urut`, `no_surat`, `asal`, `tujuan`, `tgl_surat`, `perihal`, `tgl_terima`, `kd_lemari`, `kd_rak`, `kd_map`, `kd_ruang`, `kd_sifat`, `lampiran`, `tembusan`, `tgl_deadline_balas`, `kd_balas`, `ket`, `kd_status`, `kd_klasifikasi`, `filex`, `postdate`) VALUES
('ac701eb93190053bec2b9e6dcc68dfb2', '1', '1', '1', '1', '2016-01-01', '1', '2016-01-01', '4b1c8fa9d0227614028982dcb05699ab', '26aef6699466f68a4b34df29189bc288', '09e6aff8f9c1185cac15f760d5254b2e', '19c48645e0864e858e3b720d82026f96', 'c2dd7ddae9f6f3b7aff7c927c6b43b9f', '1', '1', '2016-01-01', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', '1', '019e1e76f3197e32adeaa051131e93bb', '83081441521368fcfba137363dff322f', '178483_1098ce9a-f90f-11e3-94fb-89ab2523fab8.jpg', '2016-05-05 03:30:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_masuk_disposisi`
--

CREATE TABLE `surat_masuk_disposisi` (
  `kd` varchar(50) NOT NULL,
  `kd_indeks` varchar(50) NOT NULL,
  `kd_surat` varchar(50) NOT NULL,
  `tgl_selesai` date NOT NULL,
  `isi` varchar(255) NOT NULL,
  `diteruskan` varchar(255) NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kepada` varchar(100) NOT NULL,
  `pengesahan` enum('true','false') NOT NULL DEFAULT 'false',
  `harap` varchar(255) NOT NULL,
  `catatan` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_masuk_disposisi`
--

INSERT INTO `surat_masuk_disposisi` (`kd`, `kd_indeks`, `kd_surat`, `tgl_selesai`, `isi`, `diteruskan`, `tgl_kembali`, `kepada`, `pengesahan`, `harap`, `catatan`) VALUES
('ac701eb93190053bec2b9e6dcc68dfb2', '43cfde50ef23832c124daf79e62c26fb', 'ac701eb93190053bec2b9e6dcc68dfb2', '2016-01-01', '1', '1', '2016-01-01', '1', 'false', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_masuk_kendali`
--

CREATE TABLE `surat_masuk_kendali` (
  `kd` varchar(50) NOT NULL,
  `kd_indeks` varchar(50) NOT NULL,
  `kd_surat` varchar(50) NOT NULL,
  `tgl_selesai` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kepada` varchar(100) NOT NULL,
  `pengesahan` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_masuk_kendali`
--

INSERT INTO `surat_masuk_kendali` (`kd`, `kd_indeks`, `kd_surat`, `tgl_selesai`, `tgl_kembali`, `kepada`, `pengesahan`) VALUES
('ac701eb93190053bec2b9e6dcc68dfb2', '43cfde50ef23832c124daf79e62c26fb', 'ac701eb93190053bec2b9e6dcc68dfb2', '2016-01-01', '2016-01-01', '1', 'false');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_m_balas`
--

CREATE TABLE `surat_m_balas` (
  `kd` varchar(50) NOT NULL,
  `balas` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_m_balas`
--

INSERT INTO `surat_m_balas` (`kd`, `balas`) VALUES
('c4ca4238a0b923820dcc509a6f75849b', 'Tanpa Balasan'),
('c81e728d9d4c2f636f067f89cc14862c', 'Sudah Dibalas'),
('eccbc87e4b5ce2fe28308fd9f2a7baf3', 'Belum Dibalas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_m_indeks`
--

CREATE TABLE `surat_m_indeks` (
  `kd` varchar(50) NOT NULL,
  `indeks` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_m_indeks`
--

INSERT INTO `surat_m_indeks` (`kd`, `indeks`) VALUES
('4ab9230e38ae2de9abff97cb27fc87b3', 'x1'),
('74fbd5caaefae027d6109ee4adebd16c', 'x2'),
('3be4b7dbb276b1a59520f3e826ab17c7', 'x3'),
('43cfde50ef23832c124daf79e62c26fb', 'c4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_m_klasifikasi`
--

CREATE TABLE `surat_m_klasifikasi` (
  `kd` varchar(50) NOT NULL,
  `klasifikasi` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_m_klasifikasi`
--

INSERT INTO `surat_m_klasifikasi` (`kd`, `klasifikasi`) VALUES
('83081441521368fcfba137363dff322f', '000 UMUM'),
('6c4653c2c8b20c0602685c0d6bd0d602', '001 Lambang'),
('e5f6c5cbec3674734e37b8098eff30b7', '002 Tanda Penghormatan xgmringx Penghargaan'),
('52e2dd2519c15439c7d31c8fb781f194', '003 Hari raya xgmringx Besar'),
('84692cc49ff86d093106b3819fa657fd', '004 Ucapan'),
('516f0a52d958d30f1ccb34e0be21b067', '005 Undangan'),
('68e817eaa72772c40700319c215dd11d', '006 Tanda Jabatan'),
('07fb929da013f219210f1acc0ffef56f', '007 Tanda Gambar Presiden, Wakil Presiden dan Pejabat Pemerintah'),
('77550e6f9be097780c9637bb16ae4535', '008 xstrix'),
('dc6096be638c4f3c60621f30f8b592f3', '009 xstrix'),
('582e5c69bc9d9b6824db84348acde62a', '010 URUSAN DALAM'),
('a9b72c0dce469524b5b2a6f092c92e85', '011 Gedung Kantor'),
('834358678e672cb271bac3d91ddbaf30', '012 Rumah Dinas'),
('62c21e46b8ab9268a18b4ae933e7155b', '013 Persinggahan'),
('8e94d21b435f242e49d8a4a3dbf6dc08', '014 Akomodasi'),
('c9ea3ebc85931b32871074d2227f1523', '015 Penerangan Listrik'),
('b129f39d9f4f751ed5fafea4a283fedc', '016 Telepon'),
('a6a6c2a5eed3e164e8456d1dd7dea35c', '017 Keamanan xgmringx Tata tertib kantor'),
('b387f3e724e390d9c5f7c69e7bc4d609', '018 Kebersihan Kantor'),
('a70a6712b67bb1f665be1df2a45301b9', '019 Protokol'),
('445aacbbb9e2fc3ca19c169922f3d85d', '020 PERALATAN'),
('db111974e3e5990c1e9508485a1d726d', '021 Alat Tulis'),
('6d4119849950b1e86789438eb9f4dac1', '022 Mesin Kantor'),
('9745000dda3f18b1fb04b2ee3c0fcbd6', '023 Perabot Kantor'),
('53cc32c3f79ba30b10c04a1deba4f8db', '024 Alat Angkutan'),
('683c591fd55066ef1ac8403413c4d004', '025 Pakaian Dinas'),
('2fdcf8bdeb073e0d044c3c21186c205b', '026 Senjata'),
('107ac162067ef3a62b2ea70e254349d0', '027 Pengadaan'),
('15e39aa0c21c6d4e67e22d9e436eb9c0', '028 Inventaris'),
('3e84b558783be84b56e4b741a625bbb4', '029  Alat Studio'),
('b8378df667b557865bd4c8f9978a09ee', '030 KEKAYAAN DAERAH'),
('9d568a432b331ef309b9d404087a3b35', '031 Barangxstrixbarang tidak bergerak xkkurixtanah,kebun, dllxkkurnanx'),
('60d8d1b48ec58e5bbfc537f8bd2dffe9', '032 Barangxstrixbarang tidak bergerak xkkurixgedung, asrama, dllxkkurnanx'),
('5b85adb8038ddffd0127378e31b9c45b', '033 Barangxstrixbarang tidak bergerak xkkurixmonumenxkkurnanx'),
('de5d5f000f676b3f271472b93a600ce2', '034 Alatxstrixalat besar'),
('ed0924bf95f15ac8ef786870c7cd5d48', '035 Hewan'),
('352c7745c298561ab04527688ed1fce7', '036 Barang persediaan dalam gedung'),
('985c5ebcc5026e8a6c4c8e93dfb74e59', '037 Alat Pengangkut xkkurixdarat, laut, udaraxkkurnanx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_m_lemari`
--

CREATE TABLE `surat_m_lemari` (
  `kd` varchar(50) NOT NULL,
  `lemari` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_m_lemari`
--

INSERT INTO `surat_m_lemari` (`kd`, `lemari`) VALUES
('4b1c8fa9d0227614028982dcb05699ab', 'AA1'),
('58623c594db371f0d9dbdfaa85667da6', 'AA2'),
('1318d102ac26ade74b79e54b27fce813', 'AA3'),
('bf334cb04a6515c94535bf5606f48e74', 'AA4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_m_map`
--

CREATE TABLE `surat_m_map` (
  `kd` varchar(50) NOT NULL,
  `map` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_m_map`
--

INSERT INTO `surat_m_map` (`kd`, `map`) VALUES
('eaeb698f2aa5eb6f40c752c595a179ed', 'MAP01'),
('09e6aff8f9c1185cac15f760d5254b2e', 'MAP02'),
('0ba6d303f8d08f6ead6ec9343e24846e', 'MAP03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_m_rak`
--

CREATE TABLE `surat_m_rak` (
  `kd` varchar(50) NOT NULL,
  `rak` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_m_rak`
--

INSERT INTO `surat_m_rak` (`kd`, `rak`) VALUES
('26aef6699466f68a4b34df29189bc288', 'RK01'),
('3d03328f7a96cb203dd44163508e4b25', 'RK02'),
('6e912d5053c681d28493e1245fb3c861', 'RK03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_m_ruang`
--

CREATE TABLE `surat_m_ruang` (
  `kd` varchar(50) NOT NULL,
  `ruang` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_m_ruang`
--

INSERT INTO `surat_m_ruang` (`kd`, `ruang`) VALUES
('19c48645e0864e858e3b720d82026f96', 'RU01'),
('1de06ee72eb752a15d25656a8120e73c', 'RU02'),
('14f2a6112d389b3ef5be1b070341efcb', 'RU03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_m_sifat`
--

CREATE TABLE `surat_m_sifat` (
  `kd` varchar(50) NOT NULL,
  `sifat` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_m_sifat`
--

INSERT INTO `surat_m_sifat` (`kd`, `sifat`) VALUES
('dcc6fa74749530f5f284efedbfb84d9c', 'Rahasia'),
('c2dd7ddae9f6f3b7aff7c927c6b43b9f', 'Pribadi'),
('b0a5dddab32ab6d780ea5bcc2c1721d1', 'Umum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_m_status`
--

CREATE TABLE `surat_m_status` (
  `kd` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `surat_m_status`
--

INSERT INTO `surat_m_status` (`kd`, `status`) VALUES
('72d00626f18492515ae85a2ef50a7a00', 'Hilang'),
('1eba8fc2a9b3be92410d2f5f935c8c76', 'Rusak'),
('b7ebb4e54a10e6d25604960839ab9f07', 'Diarsipkan'),
('019e1e76f3197e32adeaa051131e93bb', 'Belum Diproses'),
('3cbc1512d930c8b66be04c66b9886b9b', 'Sedang Diproses');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminx`
--
ALTER TABLE `adminx`
  ADD PRIMARY KEY (`kd`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
