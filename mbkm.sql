-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2025 at 05:49 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbkm`
--

-- --------------------------------------------------------

--
-- Table structure for table `kode_otp`
--

CREATE TABLE `kode_otp` (
  `id` int NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_otp` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `timecreate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `Id_komentar` int NOT NULL,
  `komentar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_usulan`
--

CREATE TABLE `pengajuan_usulan` (
  `id_pengajuan` int NOT NULL,
  `nim_nik` bigint NOT NULL,
  `dosen_pembimbing` bigint NOT NULL,
  `jenis_program` enum('Penelitian / Riset','Proyek Kemanusiaan','Kegiatan Wirausaha','Studi/Proyek Independen','Membangun Desa / Kuliah Kerja Nyata Tematik','Magang Praktik Kerja','Asistensi Mengajar Di Satuan Pendidikan','Pertukaran Pelajar') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alasan_memilih_program` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `judul_program` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_mitra` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `durasi_kegiatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `posisi_di_perusahaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rincian_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sumber_pendanaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_anggota` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_anggota` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_pertukaran_pelajar` enum('Antar Prodi di Politeknik Negeri Batam','Antar Prodi pada Perguruan Tinggi yang berbeda','Prodi sama pada Perguruan Tinggi yang berbeda') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_program_studi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_mata_kuliah_jumlah_sks` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_pengajuan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int NOT NULL,
  `nama_prodi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `nama_prodi`) VALUES
(1, 'IF'),
(2, 'TRM'),
(3, 'RKS'),
(4, 'TRPL');

-- --------------------------------------------------------

--
-- Table structure for table `upload_berkas`
--

CREATE TABLE `upload_berkas` (
  `id_berkas` int NOT NULL,
  `id_pengajuan` int NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dokumen_mbkm` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `komentar` int DEFAULT NULL,
  `status_berkas` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `nim_nik` bigint NOT NULL,
  `username` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_handphone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_prodi` int NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('Dosen','Mahasiswa','Admin','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`nim_nik`, `username`, `nama_lengkap`, `email`, `no_handphone`, `alamat`, `id_prodi`, `password`, `role`) VALUES
(217122, 'dosen', 'Dosen Pembimbing 1', 'dosen@gmail.com', '089977554422', 'huyuu jauh', 4, '$2y$10$P2MYsr9xT4uQt/kw9RIsP.AsSWx0/yZIXTmZ2g.2HzIqwJGXIKP0K', 'Dosen'),
(221271, 'admin', 'Admin - Pem1', 'admin@gmail.com', '081277559877', 'jauh sekali', 4, '$2y$10$V3BtrjKHHL.xhf/9OXM.Le7g97oKIIBr1kS3e69IduIPhW0FF9xT2', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kode_otp`
--
ALTER TABLE `kode_otp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`Id_komentar`);

--
-- Indexes for table `pengajuan_usulan`
--
ALTER TABLE `pengajuan_usulan`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `nim_nik` (`nim_nik`),
  ADD KEY `dosen_pembimbing` (`dosen_pembimbing`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indexes for table `upload_berkas`
--
ALTER TABLE `upload_berkas`
  ADD PRIMARY KEY (`id_berkas`),
  ADD KEY `komentar` (`komentar`),
  ADD KEY `id_pengajuan` (`id_pengajuan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`nim_nik`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kode_otp`
--
ALTER TABLE `kode_otp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `Id_komentar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengajuan_usulan`
--
ALTER TABLE `pengajuan_usulan`
  MODIFY `id_pengajuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `upload_berkas`
--
ALTER TABLE `upload_berkas`
  MODIFY `id_berkas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kode_otp`
--
ALTER TABLE `kode_otp`
  ADD CONSTRAINT `kode_otp_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pengajuan_usulan`
--
ALTER TABLE `pengajuan_usulan`
  ADD CONSTRAINT `pengajuan_usulan_ibfk_1` FOREIGN KEY (`nim_nik`) REFERENCES `users` (`nim_nik`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pengajuan_usulan_ibfk_2` FOREIGN KEY (`dosen_pembimbing`) REFERENCES `users` (`nim_nik`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `upload_berkas`
--
ALTER TABLE `upload_berkas`
  ADD CONSTRAINT `upload_berkas_ibfk_1` FOREIGN KEY (`komentar`) REFERENCES `komentar` (`Id_komentar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `upload_berkas_ibfk_2` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_usulan` (`id_pengajuan`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
