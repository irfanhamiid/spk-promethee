-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2023 at 01:22 AM
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
-- Database: `spk_promethee`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_admin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin SPK');

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int NOT NULL,
  `nama_alternatif` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_alternatif`, `kode`) VALUES
(11, 'KECAMATAN SILUQ NGURAI', 'A11'),
(12, 'KECAMATAN JEMPANG', 'A12'),
(13, 'KECAMATAN BONGAN', 'A13');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria_penilaian`
--

CREATE TABLE `kriteria_penilaian` (
  `id_kriteria` int NOT NULL,
  `nama_kriteria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_kriteria` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria_penilaian`
--

INSERT INTO `kriteria_penilaian` (`id_kriteria`, `nama_kriteria`, `kode_kriteria`) VALUES
(2, 'Insfrastruktur', 'K2'),
(3, 'Aksebilitas', 'K3'),
(6, 'Potensi Pasien', 'K6'),
(7, 'Lingkungan', 'K7'),
(8, 'Topografi Lahan', 'K8');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_alternatif`
--

CREATE TABLE `penilaian_alternatif` (
  `id_penilaian` int NOT NULL,
  `id_alternatif` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `nilai` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian_alternatif`
--

INSERT INTO `penilaian_alternatif` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(40, 11, 2, 4),
(41, 11, 3, 3),
(42, 11, 6, 5),
(43, 11, 7, 2),
(44, 11, 8, 5),
(45, 12, 2, 3),
(46, 12, 3, 5),
(47, 12, 6, 3),
(48, 12, 7, 4),
(49, 12, 8, 3),
(50, 13, 2, 4),
(51, 13, 3, 4),
(52, 13, 6, 5),
(53, 13, 7, 4),
(54, 13, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id_subkriteria` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `nama_subkriteria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nilai` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subkriteria`
--

INSERT INTO `subkriteria` (`id_subkriteria`, `id_kriteria`, `nama_subkriteria`, `nilai`) VALUES
(8, 2, 'Baik', 4),
(9, 2, 'Cukup ', 3),
(10, 2, 'Sedang', 2),
(11, 2, 'Sangat Baik', 5),
(12, 2, 'Sangat Kurang', 1),
(13, 3, 'Sangat Kurang', 1),
(14, 3, 'Sedang', 2),
(15, 3, 'Cukup ', 3),
(16, 3, 'Baik', 4),
(17, 3, 'Sangat Baik', 5),
(18, 6, ' Sangat Baik', 5),
(19, 6, 'Baik', 4),
(20, 6, 'Cukup ', 3),
(21, 6, 'Sedang', 2),
(22, 6, 'Sangat Kurang', 1),
(23, 7, ' Sangat Baik', 5),
(24, 7, 'Baik', 4),
(25, 7, 'Cukup ', 3),
(26, 7, 'Sedang', 2),
(27, 7, 'Sangat Kurang', 1),
(28, 8, 'Dataran Tinggi', 5),
(29, 8, 'Dataran Rendah', 4),
(30, 8, 'Berbukit', 3),
(31, 8, 'Pegunungan', 2),
(32, 8, 'Daerah Cekungan', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `kriteria_penilaian`
--
ALTER TABLE `kriteria_penilaian`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `penilaian_alternatif`
--
ALTER TABLE `penilaian_alternatif`
  ADD PRIMARY KEY (`id_penilaian`);

--
-- Indexes for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`id_subkriteria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kriteria_penilaian`
--
ALTER TABLE `kriteria_penilaian`
  MODIFY `id_kriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penilaian_alternatif`
--
ALTER TABLE `penilaian_alternatif`
  MODIFY `id_penilaian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `id_subkriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
