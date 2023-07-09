-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2023 at 07:38 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sempoa`
--

-- --------------------------------------------------------

--
-- Table structure for table `smp_aco`
--

CREATE TABLE `smp_aco` (
  `aco_id` int NOT NULL,
  `aco_alt_id` int DEFAULT NULL,
  `aco_skor` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smp_alternatif`
--

CREATE TABLE `smp_alternatif` (
  `alt_id` int NOT NULL,
  `alt_nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alt_objWis_id` int DEFAULT NULL,
  `alt_jarak` double DEFAULT '1',
  `alt_kondisi` smallint DEFAULT NULL,
  `alt_fasilitas` smallint DEFAULT NULL,
  `alt_latitude` double NOT NULL,
  `alt_longitude` double NOT NULL,
  `alt_kelurahan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smp_alternatif`
--

INSERT INTO `smp_alternatif` (`alt_id`, `alt_nama`, `alt_objWis_id`, `alt_jarak`, `alt_kondisi`, `alt_fasilitas`, `alt_latitude`, `alt_longitude`, `alt_kelurahan`) VALUES
(1, 'Jl. Yos Sudarso', 1, 9154.780592246827, 1, 1, 0.5631780875408106, 101.4319911535772, 'MUARA FAJAR'),
(2, 'Jl. Patria Sari', NULL, 10590.770061552555, 2, 3, 0.5771554296799857, 101.42330080990149, 'MUARA FAJAR'),
(3, 'Jl. Umban Sari Atas', NULL, 10866.57007651082, 2, 2, 0.5797891954399529, 101.41753829826564, 'MUARA FAJAR'),
(4, 'Politeknik Caltex Riau', NULL, 9946.31689163886, 2, 3, 0.5711361227308023, 101.4260968683594, 'MUARA FAJAR'),
(5, 'Jl. Muara Fajar', NULL, 9155.452189884205, 2, 1, 0.6612918555638152, 101.41455574268153, 'Agrowisata'),
(6, 'JL. RAJA PANJANG / OKURA', NULL, 9155.886122556665, 2, 2, 0.5917889756737327, 101.50771368444471, 'TEBING TINGGI OKURA'),
(7, 'JL. PRAMUKA', NULL, 10591.756654440784, 1, 3, 0.5761016672473755, 101.46102020990146, 'TEBING TINGGI OKURA'),
(8, 'Jl. Sri Sejahtera Sari', NULL, 10591.455826877998, 2, 2, 0.6009621446841233, 101.39684160428114, 'AGROWISATA'),
(9, 'Jl. Sri Palas', NULL, 10867.259638804615, 1, 1, 0.5946117789874386, 101.39605443098955, 'AGROWISATA'),
(10, 'Jl. Padat Karya', NULL, 9946.999307691896, 1, 1, 0.5919386421076117, 101.40162354527259, 'AGROWISATA'),
(11, 'Jl Okura', NULL, 10867.488979500791, 1, 1, 0.5924761235838273, 101.53022042022715, 'TEBING TINGGI OKURA'),
(12, 'Jl. Kenanga', NULL, 9156.047567464106, 1, 1, 0.4878118356223441, 101.51874282193187, 'MENTANGOR'),
(13, 'Jl. Lintas Sumatera', NULL, 10591.966994142786, 1, 1, 0.5013296855062154, 101.51003099886324, 'MENTANGOR'),
(14, 'Jl. Hangtuah Ujung', NULL, 10867.72387464012, 1, 1, 0.5069406584601034, 101.50870066086165, 'MENTANGOR'),
(15, 'Jl. Lkr Danau Buatan', NULL, 9156.121949227054, 1, 1, 0.57883643368488, 101.46879484626827, 'SUNGAI AMBANG'),
(16, 'Jl. Pramuka', NULL, 10591.932018651716, 1, 1, 0.570420077003394, 101.44769116014079, 'SUNGAI AMBANG'),
(17, 'Bdr PHR Rumbai', NULL, 10867.63166697039, 1, 1, 0.5712130134574465, 101.44651004095451, 'SUNGAI AMBANG'),
(18, 'Jl. Seroja', NULL, 9155.452189884205, 1, 1, 0.4679130712061114, 101.515794619677, 'SIALANG RAMPAI'),
(19, 'Jl. Sekuntum', NULL, 10591.455826877998, 1, 1, 0.5048190694383449, 101.5030916613536, 'SIALANG RAMPAI'),
(20, 'Jl. Hangtuah Ujung', NULL, 10867.259638804615, 1, 1, 0.5249668529673314, 101.4620644169281, 'SIALANG RAMPAI'),
(21, 'Jl. Kadiran', NULL, 9155.886122556665, 1, 1, 0.4618109326506244, 101.5052348022718, 'PEBATUAN'),
(22, 'Jl. Pesantren', NULL, 10591.756654440784, 1, 1, 0.46644832605142694, 101.50455351707454, 'PEBATUAN'),
(23, 'Jl. Daru daru', NULL, 10867.488979500791, 1, 1, 0.4679223133166563, 101.51235126572496, 'PEBATUAN'),
(24, 'Jl. Arifin Ahmad', NULL, 9167.294861493403, 1, 1, 0.4768487678423435, 101.45388480335713, 'AIR DINGIN'),
(25, 'Jl. Kaharuddin Nst', NULL, 10604.871178542764, 1, 1, 0.4573901021301118, 101.45255597346988, 'AIR DINGIN'),
(26, 'Jl. Pahlawan Kerja', NULL, 10880.956830107587, 1, 1, 0.46107440303325536, 101.45186493753462, 'AIR DINGIN'),
(27, 'Jl. Bukit Indah', NULL, 9156.121949227054, 1, 1, 0.4964865937266041, 101.50867290188923, 'SIALANG SAKTI'),
(28, 'Jl. Singkong', NULL, 10591.932018651716, 1, 1, 0.49700566373750216, 101.50932448636162, 'SIALANG SAKTI'),
(29, 'Jl. Bukit Battu', NULL, 10867.63166697039, 1, 1, 0.4961172554916392, 101.50903590107303, 'SIALANG SAKTI'),
(30, 'Jl. Alam Mayang', NULL, 9167.214358226418, 1, 1, 0.4922845783762133, 101.49994967625587, 'TANGKERANG TIMUR'),
(31, 'Gg Plamboyan', NULL, 10604.911735785347, 1, 1, 0.4919627257405171, 101.50100646788852, 'TANGKERANG TIMUR'),
(32, 'Jl Gn. Jati', NULL, 10881.060742175961, 1, 1, 0.49035345908965094, 101.49778781498456, 'TANGKERANG TIMUR'),
(33, 'Jl. Badak Ujung', NULL, 9156.755838153622, 1, 1, 0.5073053560512191, 101.50937126524454, 'BENCAH LESUNG'),
(34, 'Jl. Triguna', NULL, 10592.747039516833, 1, 1, 0.5069218150805497, 101.50844590249227, 'BENCAH LESUNG'),
(35, 'Jl. Hangtuah Ujung', NULL, 10868.537465163428, 1, 1, 0.5067367497947282, 101.50907353989352, 'BENCAH LESUNG'),
(36, 'Jl. Datuk Wan Abdul Jamal', NULL, 9155.452189884205, 1, 1, 0.4776630682656528, 101.45680266198782, 'SIMPANG TIGA'),
(37, 'Jl. Jendral Sudirman', NULL, 10591.455826877998, 1, 1, 0.4781632833787513, 101.4542331016748, 'SIMPANG TIGA'),
(38, 'Jl. Arifin Ahmad', NULL, 10867.259638804615, 1, 1, 0.4768329520958799, 101.45385759183041, 'SIMPANG TIGA'),
(39, 'Jl. Panglima Undan', NULL, 9156.121949227054, 1, 1, 0.5404778589992761, 101.43946581855427, 'KAMPUNG BANDAR'),
(40, 'Jl. Jembatan Siak III', NULL, 10591.932018651716, 1, 1, 0.53963031845547, 101.43930488591292, 'KAMPUNG BANDAR'),
(41, 'Jl. Perdagangan', NULL, 10867.63166697039, 1, 1, 0.5403933731729313, 101.43924051206368, 'KAMPUNG BANDAR'),
(42, 'Jl. Masjid Raya', NULL, 9156.121949227054, 1, 1, 0.5377686073254645, 101.44244854052533, 'KAMPUNG DALAM'),
(43, 'Jl. Senapelan', NULL, 10591.932018651716, 1, 1, 0.537250963754228, 101.44201670436597, 'KAMPUNG DALAM'),
(44, 'Jl. Kampar', NULL, 10867.63166697039, 1, 1, 0.5384061648439509, 101.44259764117375, 'KAMPUNG DALAM'),
(45, 'Apotik Rokan Jaya', NULL, 9947.535123047586, 1, 1, 0.5397129431340165, 101.44101436991261, 'KAMPUNG BANDAR'),
(46, 'Mie Lambok Pak Atiak', NULL, 19933.65865036955, 1, 1, 0.5398269319458424, 101.44101436991261, 'KAMPUNG BANDAR'),
(47, 'Jl. Moh. Dahlan', NULL, 9155.886122556665, 1, 1, 0.5264163465218621, 101.4500712922558, 'SUMAHILANG'),
(48, 'Jl. Sisingamaraja', NULL, 10591.756654440784, 1, 1, 0.5281945782957498, 101.45012225185471, 'SUMAHILANG'),
(49, 'Jl. St Syarif', NULL, 10867.488979500791, 1, 1, 0.528178489230552, 101.45375934236762, 'SUMAHILANG'),
(50, 'Hl. RTH Kaca Mayang', NULL, 9155.886122556665, 1, 1, 0.5133223892074374, 101.44797018168005, 'SIMPANG EMPAT'),
(51, 'Jl. Sumatera', NULL, 10591.756654440784, 1, 1, 0.5281945782957498, 101.45012225185471, 'SIMPANG EMPAT'),
(52, 'Jl. Jenderal Sudirman', NULL, 10867.488979500791, 1, 1, 0.5137153170469547, 101.44771537188704, 'SIMPANG EMPAT'),
(53, 'Jl. Pepaya', NULL, 1, 1, 1, 0.5106717420447158, 101.44706722540529, 'JADIREJO'),
(54, 'Jl. Lintas Sumatera', NULL, 1, 1, 1, 0.5103606184926379, 101.44909497347697, 'JADIREJO'),
(55, 'Jl. Jendral Sudirman', NULL, 1, 1, 1, 0.5113141056886543, 101.44872751272226, 'JADIREJO'),
(56, 'Jl. M.H Thamrin', NULL, 9155.886122556665, 1, 1, 0.5161660006014358, 101.45344791547923, 'SUKA MULIA'),
(57, 'Jl. Dipenogoro', NULL, 10591.756654440784, 1, 1, 0.5156295789010472, 101.45234283654818, 'SUKA MULIA'),
(58, 'Jl. WR Supratman Ujung', NULL, 10867.488979500791, 1, 1, 0.5160023925012818, 101.45689455680707, 'SUKA MULIA'),
(59, 'Jl. Soekarno Hatta', NULL, 9155.452189884205, 1, 1, 0.5029095995700814, 101.41927409765478, 'LABUH BARU TIMUR'),
(60, 'Jl.Nangka', NULL, 10591.455826877998, 1, 1, 0.5008926529286442, 101.4196603349473, 'LABUH BARU TIMUR'),
(61, 'Jl. Lintas Sumatera', NULL, 10867.259638804615, 1, 1, 0.4996312516089031, 101.41058830515608, 'LABUH BARU TIMUR'),
(62, 'Jl. Jendral Sudirman', NULL, 9155.886122556665, 1, 1, 0.49388978099115044, 101.4546256335469, 'TANGKERANG TENGAH'),
(63, 'Jl. Mekar Sari', NULL, 10591.756654440784, 1, 1, 0.4956921575452953, 101.45539810964304, 'TANGKERANG TENGAH'),
(64, 'Jl. Merpati', NULL, 10867.488979500791, 1, 1, 0.4955620753889814, 101.45490994786518, 'TANGKERANG TENGAH'),
(65, 'Jl. Yos Sudarso', 1, 19932.62268257043, 1, 1, 0.5631780875408106, 101.4319911535772, 'MUARA FAJAR');

-- --------------------------------------------------------

--
-- Table structure for table `smp_evaluasi`
--

CREATE TABLE `smp_evaluasi` (
  `evl_id` int NOT NULL,
  `evl_krtr_id` int DEFAULT NULL,
  `evl_alt_id` int DEFAULT NULL,
  `evl_nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smp_kriteria`
--

CREATE TABLE `smp_kriteria` (
  `krtr_id` int NOT NULL,
  `krtr_nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smp_kriteria`
--

INSERT INTO `smp_kriteria` (`krtr_id`, `krtr_nama`) VALUES
(1, 'Kondisi jalan'),
(2, 'Jarak jalan'),
(3, 'Fasilitas jalan');

-- --------------------------------------------------------

--
-- Table structure for table `smp_objekwisata`
--

CREATE TABLE `smp_objekwisata` (
  `objWis_id` bigint NOT NULL,
  `objWis_nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `objWis_alamat` text COLLATE utf8mb4_general_ci,
  `objWis_fasilitas` text COLLATE utf8mb4_general_ci,
  `objWis_kelurahan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `objWis_latitude` double DEFAULT NULL,
  `objWis_longitude` double DEFAULT NULL,
  `objWis_createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smp_objekwisata`
--

INSERT INTO `smp_objekwisata` (`objWis_id`, `objWis_nama`, `objWis_alamat`, `objWis_fasilitas`, `objWis_kelurahan`, `objWis_latitude`, `objWis_longitude`, `objWis_createdAt`) VALUES
(1, 'ASIA HERITAGE, Kota Pekanbaru, Riau', 'Jl. Yos Sudarso No.Km.12, RW.5, Muara Fajar, Kec. Rumbai, Kota Pekanbaru, Riau 28265', 'Bangunan replika dari China, Jepang, dan Korea di desa warisan dengan seluncuran anak dan tempat berfoto.', 'MUARA FAJAR', 0.6074744381938979, 101.4316438387378, '2023-05-20 02:44:19'),
(6, 'Taman Bunga Impian OKURA', 'JL. RAJA PANJANG / OKURA Tebing Tinggi Okura, Kec. Rumbai Pesisir, Kota Pekanbaru, Riau 28285', 'Objek Wisata Keluarga', 'TEBING TINGGI OKURA', 0.5774077928929351, 101.53221430549331, '2023-06-22 13:32:07'),
(7, 'Danau Buatan', 'Jl. Danau Buatan, Tebing Tinggi Okura, Kec. Rumbai Pesisir, Kota Pekanbaru, Riau 28261', 'Toilet, musholla, tempat makan, dan spot foto.', 'SUNGAI AMBANG', 0.5850008490733575, 101.47452406732987, '2023-07-03 02:59:06'),
(8, 'KAMPOENG RABBIT\'S ', 'Sail, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28289', 'Terdapat tujuh jenis kelinci, edukasi dalam perawatan kelinci, merasakan sate kelinci, musholla, gazebo, taman bermain, spot foto kelinci, dan toko yang menjual aksesoris kelinci.', 'MENTANGOR', 0.48191896864379014, 101.51605869340575, '2023-07-03 03:07:13'),
(9, 'Taman Wisata Love Refi', 'Jl. Seroja, kelurahan sialangrampai, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28282', 'Wahana permainan (Panahan, Mewarnai, Flying Fox, Bebek Air, Mobil Remot, Motor Trail, ATV,  Masuk Goa Lancang, dan Mancing Ikan Patin), Tempat parker, Spot foto,  Gazebo,  Toilet,  Kantin, Dan lain-lain.', 'SIALANG RAMPAI', 0.4479930697088535, 101.53574782408658, '2023-07-03 03:09:11'),
(10, 'Taman Agrowisata Tenayan Raya', 'Jl. Kadiran, Kulim, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28289', 'Restoran terapung, gazebo dan pendopo, tempat parkir, toilet, kantin, taman buah dan sawah, kolam pancing, tempat outbound, musholla, dan spot foto', 'PEBATUAN', 0.4627263137812477, 101.50331049658023, '2023-07-03 03:11:48'),
(11, 'Rumah Jamur Nando', 'H. Imam Munandar Ujung, Jl. Singkong No.3, Sail, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28285', 'Wisata edukatif, murah, dan menarik mengenai budidaya jamur, gazebo yang memiliki tempat duduk dan tempat bermain anak.', 'SIALANG SAKTI', 0.4967983250187887, 101.50901483942695, '2023-07-03 03:13:26'),
(12, 'Alam Mayang Park', 'Jl. Imam Munandar taman rekreasi alamayang No.depan, Tengkerang Tim., Kec. Tenayan Raya, Kota Pekanbaru, Riau 28282', 'Suasana alam, taman bermain, berbagai wahana permainan, waterpark, tempat parkir, musholla, spot foto, tempat makan, kolam pemancingan, restoran, penginapan dan hotel.', 'TANGKERANG TIMUR', 0.49236771930407225, 101.50060020660021, '2023-07-03 03:14:36'),
(13, 'ThemePark Asia Farm Hayday', 'Sail, Kec. Sail, Kota Pekanbaru, Riau', 'Area parkir, Toilet & Musholla yang bersih,  Foodcourt, Waterpark, Wahana Bermain. Beberapa spot untuk mencuci tangan dan berfoto.\r\n', 'BENCAH LESUNG', 0.5073844932984901, 101.50899208360237, '2023-07-03 03:15:51'),
(14, 'Anjungan Seni Idrus Tintin', 'Tangkerang Selatan, Jalan Jenderal Sudirman, Simpang Tiga, Bukit Raya, Simpang Tiga, Kec. Bukit Raya, Kota Pekanbaru, Riau 28128', 'Tempat pertunjukan seni dan budaya, sound system, genset, lighting, dan AC.\r\n', 'SIMPANG TIGA', 0.47831348184735945, 101.45592021059178, '2023-07-03 03:16:50'),
(15, 'Tugu Pahlawan Kerja', 'Simpang Tiga, Kec. Bukit Raya, Kota Pekanbaru, Riau 28288', 'Tempat parkir dan wisata edukasi sejarah\r\n', 'AIR DINGIN', 0.4606138547899641, 101.45285743758126, '2023-07-03 03:18:33'),
(16, 'Rumah Tenun Kampung Bandar', 'Jl. Perdagangan No.206, Kp. Bandar, Kec. Senapelan, Kota Pekanbaru, Riau 28155', 'Edukasi pembuatan tenung, aksesoris, dan tempat parker.', 'KAMPUNG BANDAR', 0.5404098531949695, 101.4414500105919, '2023-07-03 03:19:56'),
(17, 'Masjid Raya Kota Pekanbaru', 'Jl. Senapelan No.128, Kp. Bandar, Kec. Senapelan, Kota Pekanbaru, Riau 28155', 'Tempat beribadah, tempat parkir, dan toilet.', 'KAMPUNG DALAM', 0.5381373950763063, 101.44229297010774, '2023-07-03 03:24:30'),
(18, 'Masjid Raya An Nur Riau Province', 'Jl. Hangtuah Ujung, Sumahilang, Kec. Pekanbaru Kota, Kota Pekanbaru, Riau 28156', 'Taman, tempat parkir, tempat beribadah, toilet.', 'SUMAHILANG', 0.5268991238808954, 101.45087595292169, '2023-07-03 03:26:36'),
(19, 'RTH Putri Kaca Mayang', 'Jl. Jend. Sudirman No.474, Jadirejo, Kec. Sukajadi, Kota Pekanbaru, Riau 28121', 'Tempat parkir, foodcurt, temoat duduk, tempat bermain.', 'SIMPANG EMPAT', 0.5139754798490624, 101.44839394199377, '2023-07-03 03:27:41'),
(20, 'Masjid Ar-Rahman', 'Jl. Jend. Sudirman No.482, Jadirejo, Kec. Sukajadi, Kota Pekanbaru, Riau 28121', 'Tempat parkir, tempat ibadah, dan toilet.', 'JADIREJO', 0.512066459014606, 101.44826968421891, '2023-07-03 03:30:27'),
(21, 'Hutan Kota Pekanbaru', 'Jl. Diponegoro, Suka Mulia, Kec. Sail, Kota Pekanbaru, Riau 28127', 'Tempat parkir dan tempat duduk.', 'SUKA MULIA', 0.516211595891561, 101.45590482224091, '2023-07-03 03:32:22'),
(22, 'HORSE POWER PEKANBARU', 'samping SKA, Jl. Tuanku Tambusai Jl. Soekarno - Hatta, Labuh Baru Bar., Kec. Payung Sekaki, Kota Pekanbaru, Riau 28292', 'Tempat parkir dan olahraga berkuda.', 'LABUH BARU TIMUR', 0.5017416953859626, 101.41882023942699, '2023-07-03 03:36:41'),
(23, 'Museum Daerah Riau Sang Nila Utama', 'Tangkerang Pekanbaru Jl. Jend. Sudirman No.194, Tengkerang Tengah, Marpoyan Damai, Pekanbaru City, Riau 28282', 'Tempat parkir dan wisata edukasi.', 'TANGKERANG TENGAH', 0.49429209667360247, 101.45450225292151, '2023-07-03 03:39:36'),
(24, 'Rumah Singgah Tuan Kadi', 'Kampung Bandar, Senapelan, Pekanbaru City, Riau 28155', 'Edukasi sejarah, tempat festival, spot foto, tempat duduk, dan tempat parkir.', 'KAMPUNG BANDAR', 0.5405645629219668, 101.43974974627304, '2023-07-03 03:49:02'),
(25, 'kampung wisata agrowisata', 'Unnamed Road, Palas, Kec. Rumbai, Kota Pekanbaru, Riau 28264', 'Sentra produksi tanaman buah dan sayur serta wisata edukasi bagi santri dan siswa, pelatihan SDM , komunitas ibu, remaja, pemuda dan lembaga aktif.', 'AGROWISATA', 0.606806, 101.361726, '2023-07-03 03:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `smp_user`
--

CREATE TABLE `smp_user` (
  `usr_id` bigint NOT NULL,
  `usr_username` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usr_password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usr_nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usr_level` tinyint(1) DEFAULT NULL,
  `usr_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smp_user`
--

INSERT INTO `smp_user` (`usr_id`, `usr_username`, `usr_password`, `usr_nama`, `usr_level`, `usr_created_at`) VALUES
(1, 'admin', '$2a$12$4t1CloRa4uZVjW4b.hpiFuicpnmr20GVMhkzh2tfh5kWlLyBc2Bpy', 'Administrator', 1, '2023-05-19 16:20:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `smp_aco`
--
ALTER TABLE `smp_aco`
  ADD PRIMARY KEY (`aco_id`);

--
-- Indexes for table `smp_alternatif`
--
ALTER TABLE `smp_alternatif`
  ADD PRIMARY KEY (`alt_id`);

--
-- Indexes for table `smp_evaluasi`
--
ALTER TABLE `smp_evaluasi`
  ADD PRIMARY KEY (`evl_id`);

--
-- Indexes for table `smp_kriteria`
--
ALTER TABLE `smp_kriteria`
  ADD PRIMARY KEY (`krtr_id`);

--
-- Indexes for table `smp_objekwisata`
--
ALTER TABLE `smp_objekwisata`
  ADD PRIMARY KEY (`objWis_id`);

--
-- Indexes for table `smp_user`
--
ALTER TABLE `smp_user`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `smp_aco`
--
ALTER TABLE `smp_aco`
  MODIFY `aco_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smp_alternatif`
--
ALTER TABLE `smp_alternatif`
  MODIFY `alt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `smp_evaluasi`
--
ALTER TABLE `smp_evaluasi`
  MODIFY `evl_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smp_kriteria`
--
ALTER TABLE `smp_kriteria`
  MODIFY `krtr_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `smp_objekwisata`
--
ALTER TABLE `smp_objekwisata`
  MODIFY `objWis_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `smp_user`
--
ALTER TABLE `smp_user`
  MODIFY `usr_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
