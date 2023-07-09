-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 26, 2023 at 11:01 AM
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
  `aco_skor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smp_alternatif`
--

CREATE TABLE `smp_alternatif` (
  `alt_id` int NOT NULL,
  `alt_nama` varchar(100) DEFAULT NULL,
  `alt_jarak` double DEFAULT '1',
  `alt_kondisi` smallint DEFAULT NULL,
  `alt_fasilitas` smallint DEFAULT NULL,
  `alt_latitude` double NOT NULL,
  `alt_longitude` double NOT NULL,
  `alt_kelurahan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `smp_alternatif`
--

INSERT INTO `smp_alternatif` (`alt_id`, `alt_nama`, `alt_jarak`, `alt_kondisi`, `alt_fasilitas`, `alt_latitude`, `alt_longitude`, `alt_kelurahan`) VALUES
(1, 'Jl. Yos Sudarso', 7613.659543228809, 1, 1, 0.5631780875408106, 101.4319911535772, 'Agrowisata'),
(2, 'Jl. Patria Sari', 9236.030434927987, 2, 3, 0.5771554296799857, 101.42330080990149, 'Agrowisata'),
(3, 'Jl. Umban Sari Atas', 9623.507511223941, 2, 2, 0.5797891954399529, 101.41753829826564, 'Agrowisata'),
(4, 'Politeknik Caltex Riau', 8536.25885145883, 2, 3, 0.5711361227308023, 101.4260968683594, 'Agrowisata'),
(5, 'Jl. Muara Fajar', 18651.767862864795, 2, 1, 0.6612918555638152, 101.41455574268153, 'Agrowisata'),
(6, 'JL. RAJA PANJANG / OKURA', 7613.659543228809, 2, 2, 0.5917889756737327, 101.50771368444471, 'TEBING TINGGI OKURA'),
(7, 'JL. PRAMUKA', 9236.030434927987, 1, 3, 0.5761016672473755, 101.46102020990146, 'TEBING TINGGI OKURA');

-- --------------------------------------------------------

--
-- Table structure for table `smp_evaluasi`
--

CREATE TABLE `smp_evaluasi` (
  `evl_id` int NOT NULL,
  `evl_krtr_id` int DEFAULT NULL,
  `evl_alt_id` int DEFAULT NULL,
  `evl_nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smp_kriteria`
--

CREATE TABLE `smp_kriteria` (
  `krtr_id` int NOT NULL,
  `krtr_nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `objWis_nama` varchar(100) DEFAULT NULL,
  `objWis_alamat` text,
  `objWis_fasilitas` text,
  `objWis_kelurahan` varchar(100) NOT NULL,
  `objWis_latitude` double DEFAULT NULL,
  `objWis_longitude` double DEFAULT NULL,
  `objWis_createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `smp_objekwisata`
--

INSERT INTO `smp_objekwisata` (`objWis_id`, `objWis_nama`, `objWis_alamat`, `objWis_fasilitas`, `objWis_kelurahan`, `objWis_latitude`, `objWis_longitude`, `objWis_createdAt`) VALUES
(1, 'ASIA HERITAGE, Kota Pekanbaru, Riau', 'Jl. Yos Sudarso No.Km.12, RW.5, Muara Fajar, Kec. Rumbai, Kota Pekanbaru, Riau 28265', 'Bangunan replika dari China, Jepang, dan Korea di desa warisan dengan seluncuran anak dan tempat berfoto.', 'Agrowisata', 0.6074744381938979, 101.4316438387378, '2023-05-20 02:44:19'),
(6, 'Taman Bunga Impian OKURA', 'JL. RAJA PANJANG / OKURA Tebing Tinggi Okura, Kec. Rumbai Pesisir, Kota Pekanbaru, Riau 28285', 'Objek Wisata Keluarga', 'TEBING TINGGI OKURA', 0.5774077928929351, 101.53221430549331, '2023-06-22 13:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `smp_user`
--

CREATE TABLE `smp_user` (
  `usr_id` bigint NOT NULL,
  `usr_username` varchar(100) DEFAULT NULL,
  `usr_password` varchar(255) DEFAULT NULL,
  `usr_nama` varchar(100) DEFAULT NULL,
  `usr_level` tinyint(1) DEFAULT NULL,
  `usr_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  MODIFY `alt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `objWis_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `smp_user`
--
ALTER TABLE `smp_user`
  MODIFY `usr_id` bigint NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
