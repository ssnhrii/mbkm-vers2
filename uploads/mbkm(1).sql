-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for mbkm
CREATE DATABASE IF NOT EXISTS `mbkm` /*!40100 DEFAULT CHARACTER SET armscii8 COLLATE armscii8_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mbkm`;

-- Dumping structure for table mbkm.kode_otp
CREATE TABLE IF NOT EXISTS `kode_otp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_otp` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `timecreate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  CONSTRAINT `kode_otp_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mbkm.kode_otp: ~0 rows (approximately)

-- Dumping structure for table mbkm.komentar
CREATE TABLE IF NOT EXISTS `komentar` (
  `Id_komentar` int NOT NULL AUTO_INCREMENT,
  `komentar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`Id_komentar`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mbkm.komentar: ~0 rows (approximately)

-- Dumping structure for table mbkm.pengajuan_usulan
CREATE TABLE IF NOT EXISTS `pengajuan_usulan` (
  `id_pengajuan` int NOT NULL AUTO_INCREMENT,
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
  `status_pengajuan` enum('Menunggu Persetujuan','Ditolak','Diterima') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan`),
  KEY `nim_nik` (`nim_nik`),
  KEY `dosen_pembimbing` (`dosen_pembimbing`),
  CONSTRAINT `pengajuan_usulan_ibfk_1` FOREIGN KEY (`nim_nik`) REFERENCES `users` (`nim_nik`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pengajuan_usulan_ibfk_2` FOREIGN KEY (`dosen_pembimbing`) REFERENCES `users` (`nim_nik`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mbkm.pengajuan_usulan: ~0 rows (approximately)

-- Dumping structure for table mbkm.prodi
CREATE TABLE IF NOT EXISTS `prodi` (
  `id_prodi` int NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_prodi`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mbkm.prodi: ~7 rows (approximately)
REPLACE INTO `prodi` (`id_prodi`, `nama_prodi`) VALUES
	(1, 'Teknik Informatika'),
	(2, 'Sistem Informasi'),
	(3, 'Teknik Elektro'),
	(4, 'TRPL'),
	(6, 'TRM'),
	(7, 'MANAJEMEN'),
	(8, 'RKS');

-- Dumping structure for table mbkm.upload_berkas
CREATE TABLE IF NOT EXISTS `upload_berkas` (
  `id_berkas` int NOT NULL AUTO_INCREMENT,
  `id_pengajuan` int NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dokumen_mbkm` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `komentar` int DEFAULT NULL,
  `status_berkas` enum('Menunggu Persetujuan','Ditolak','Diterima') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_berkas`),
  KEY `komentar` (`komentar`),
  KEY `id_pengajuan` (`id_pengajuan`),
  CONSTRAINT `upload_berkas_ibfk_1` FOREIGN KEY (`komentar`) REFERENCES `komentar` (`Id_komentar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `upload_berkas_ibfk_2` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_usulan` (`id_pengajuan`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mbkm.upload_berkas: ~0 rows (approximately)

-- Dumping structure for table mbkm.users
CREATE TABLE IF NOT EXISTS `users` (
  `nim_nik` bigint NOT NULL,
  `username` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_handphone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_prodi` int NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('Dosen','Mahasiswa','Admin','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`nim_nik`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `id_prodi` (`id_prodi`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mbkm.users: ~4 rows (approximately)
REPLACE INTO `users` (`nim_nik`, `username`, `nama_lengkap`, `email`, `no_handphone`, `alamat`, `id_prodi`, `password`, `role`) VALUES
	(217122, 'dosen', 'Dosen Pembimbing 1', 'dosen@gmail.com', '089977554422', 'huyuu jauh', 4, '$2y$10$P2MYsr9xT4uQt/kw9RIsP.AsSWx0/yZIXTmZ2g.2HzIqwJGXIKP0K', 'Dosen'),
	(221271, 'admin', 'Admin - Pem1', 'admin@gmail.com', '081277559877', 'jauh sekali', 4, '$2y$10$V3BtrjKHHL.xhf/9OXM.Le7g97oKIIBr1kS3e69IduIPhW0FF9xT2', 'Admin'),
	(224345, 'agus riady', 'Agus Riady', 'agusriady@polibatam.ac.id', '089887766554', 'Ampar Batu', 8, '$2y$10$7MdAb/E/4z8c1cb5.o9qIeAJ55HXuTESb89/ZGERiLZszpVeqnNo6', 'Dosen'),
	(90722120805, 'Erikk22', 'Erik Chris Jericho Gerald', 'meliala366m12@gmail.com', '085836147196', 'Oleana Park', 4, '$2y$10$sajGQy9AE1DyBr4rz7pOMeYZDeYz0soiC33gqdks8Afn5PRb8Plga', 'Mahasiswa');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
