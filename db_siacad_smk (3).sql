-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2026 at 04:30 AM
-- Server version: 26.10.0
-- PHP Version: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_siacad_smk`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int NOT NULL,
  `nip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `jenis_kelamin`, `user_id`) VALUES
(1, '19850101001', 'Budi Santoso', 'L', 2),
(2, '19860202002', 'Andi Wijaya', 'L', 3),
(3, '19870303003', 'Siti Aminah', 'P', 4),
(4, '19880404004', 'Rina Marlina', 'P', 5),
(5, '19890505005', 'Dedi Kurniawan', 'L', 6),
(6, '19900606006', 'Agus Setiawan', 'L', NULL),
(7, '19910707007', 'Dewi Anggraini', 'P', NULL),
(8, '19920808008', 'Fitri Handayani', 'P', NULL),
(9, '19930909009', 'Rudi Hermawan', 'L', NULL),
(10, '19941010010', 'Nina Kartika', 'P', NULL),
(11, '6483269836', 'Alexander', 'P', 13);

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id` int NOT NULL,
  `kode_mapel` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_mapel` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guru_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id`, `kode_mapel`, `nama_mapel`, `guru_id`) VALUES
(1, 'MP001', 'Pemrograman Web', 1),
(2, 'MP002', 'Basis Data', 2),
(3, 'MP003', 'Pemrograman Berorientasi Objek', 3),
(4, 'MP004', 'Matematika', 4),
(5, 'MP005', 'Bahasa Indonesia', 5),
(6, 'MP006', 'Bahasa Inggris', 6),
(7, 'MP007', 'Jaringan Komputer', 7),
(8, 'MP008', 'Sistem Operasi', 8),
(9, 'MP009', 'Pendidikan Pancasila', 9),
(10, 'MP010', 'Produk Kreatif dan Kewirausahaan', 10);

-- --------------------------------------------------------

--
-- Table structure for table `mengajar`
--

CREATE TABLE `mengajar` (
  `id` int NOT NULL,
  `mapel_id` int DEFAULT NULL,
  `siswa_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mengajar`
--

INSERT INTO `mengajar` (`id`, `mapel_id`, `siswa_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `nama_siswa`
--

CREATE TABLE `nama_siswa` (
  `id` int NOT NULL,
  `nis` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nama_siswa`
--

INSERT INTO `nama_siswa` (`id`, `nis`, `nama`, `kelas`, `jenis_kelamin`, `user_id`) VALUES
(1, '2401001', 'Ahmad Fauzan', 'XI RPL 1', 'L', 7),
(2, '2401002', 'Putri Amelia', 'XI RPL 1', 'P', 8),
(3, '2401003', 'Rizky Ramadhan', 'XI RPL 1', 'L', 9),
(4, '2401004', 'Nadia Safitri', 'XI RPL 1', 'P', 10),
(5, '2401005', 'Fajar Nugraha', 'XI RPL 1', 'L', NULL),
(6, '2401006', 'Aulia Rahma', 'XI RPL 1', 'P', NULL),
(7, '2401007', 'Dimas Pratama', 'XI RPL 1', 'L', NULL),
(8, '2401008', 'Intan Permata', 'XI RPL 1', 'P', NULL),
(9, '2401009', 'Reza Maulana', 'XI RPL 1', 'L', NULL),
(10, '2401010', 'Citra Lestari', 'XI RPL 1', 'P', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_rapor`
--

CREATE TABLE `nilai_rapor` (
  `id` int NOT NULL,
  `siswa_id` int DEFAULT NULL,
  `mapel_id` int DEFAULT NULL,
  `nilai_kkm` int DEFAULT NULL,
  `nilai_pengetahuan` int DEFAULT NULL,
  `nilai_keterampilan` int DEFAULT NULL,
  `nilai_akhir` int DEFAULT NULL,
  `Keterangan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai_rapor`
--

INSERT INTO `nilai_rapor` (`id`, `siswa_id`, `mapel_id`, `nilai_kkm`, `nilai_pengetahuan`, `nilai_keterampilan`, `nilai_akhir`, `Keterangan`) VALUES
(1, 1, 1, 75, 88, 90, 89, 'Tuntas'),
(2, 2, 2, 75, 85, 87, 86, 'Tuntas'),
(3, 3, 3, 75, 78, 80, 79, 'Tuntas'),
(4, 4, 4, 75, 92, 90, 91, 'Tuntas'),
(5, 5, 5, 75, 80, 82, 81, 'Tuntas'),
(6, 6, 6, 75, 70, 72, 71, 'Belum Tuntas'),
(7, 7, 7, 75, 86, 84, 85, 'Tuntas'),
(8, 8, 8, 75, 90, 92, 91, 'Tuntas'),
(9, 9, 9, 75, 76, 78, 77, 'Tuntas'),
(10, 10, 10, 75, 95, 94, 95, 'Tuntas');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int NOT NULL,
  `nis` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_siswa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama_siswa`, `kelas`, `jenis_kelamin`, `user_id`) VALUES
(1, '2401001', 'Ahmad Fauzan', 'XI RPL 1', 'L', 7),
(2, '2401002', 'Putri Amelia', 'XI RPL 1', 'P', 8),
(3, '2401003', 'Rizky Ramadhan', 'XI RPL 1', 'L', 9),
(4, '2401004', 'Nadia Safitri', 'XI RPL 1', 'P', 10),
(5, '2401005', 'Fajar Nugraha', 'XI RPL 1', 'L', NULL),
(6, '2401006', 'Aulia Rahma', 'XI RPL 1', 'P', NULL),
(7, '2401007', 'Dimas Pratama', 'XI RPL 1', 'L', NULL),
(8, '2401008', 'Intan Permata', 'XI RPL 1', 'P', NULL),
(9, '2401009', 'Reza Maulana', 'XI RPL 1', 'L', NULL),
(10, '2401010', 'Citra Lestari', 'XI RPL 1', 'P', NULL),
(11, '778597', 'lucy', 'XI - IPA 2', 'L', 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','guru','siswa') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'admin', '2026-11-18 06:41:03'),
(2, 'budi', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'guru', '2026-11-18 06:41:03'),
(3, 'andi', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'guru', '2026-11-18 06:41:03'),
(4, 'siti', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'guru', '2026-11-18 06:41:03'),
(5, 'rina', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'guru', '2026-11-18 06:41:03'),
(6, 'dedi', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'guru', '2026-11-18 06:41:03'),
(7, 'siswa01', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'siswa', '2026-11-18 06:41:03'),
(8, 'siswa02', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'siswa', '2026-11-18 06:41:03'),
(9, 'siswa03', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'siswa', '2026-11-18 06:41:03'),
(10, 'siswa04', '$2y$12$CSE7BRezS3I7vjZT89NNOe.9VQoxtenbj8gFfI7M0edLQhebObudq', 'siswa', '2026-11-18 06:41:03'),
(11, 'lucifer', '$2y$12$BH2vvAabJryq5hUKnoJULuePSOB5P4FhlpO2qiJpLNdrTwzrnjfcq', 'siswa', '2026-11-18 12:03:27'),
(12, 'alinskie', '$2y$12$GyELdqb/9vSF4QoK7h61kejWscicva293FMpUp7ViLNV9J1IoB6ZO', 'admin', '2026-11-20 02:01:18'),
(13, 'Alexa', '$2y$12$CKQVoxX/0eZybzuv8BG5V.MsQm69sA0xh2PUhMe5ao1BxeBZdhejO', 'guru', '2026-11-20 02:02:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indexes for table `mengajar`
--
ALTER TABLE `mengajar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mapel_id` (`mapel_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `nama_siswa`
--
ALTER TABLE `nama_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mengajar`
--
ALTER TABLE `mengajar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nama_siswa`
--
ALTER TABLE `nama_siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `mapel`
--
ALTER TABLE `mapel`
  ADD CONSTRAINT `mapel_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`);

--
-- Constraints for table `mengajar`
--
ALTER TABLE `mengajar`
  ADD CONSTRAINT `mengajar_ibfk_1` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`),
  ADD CONSTRAINT `mengajar_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`);

--
-- Constraints for table `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD CONSTRAINT `nilai_rapor_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`),
  ADD CONSTRAINT `nilai_rapor_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
