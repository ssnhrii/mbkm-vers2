-- phpMyAdmin SQL Dump (Updated)
-- Politeknik Negeri Batam - Sistem MBKM
-- Updated: sesuai Pedoman Merdeka Belajar v5 (2021) & Formulir No.BO.8.7.1-V0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `mbkm`

-- --------------------------------------------------------
-- Table: `kode_otp`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kode_otp` (
  `id`         int NOT NULL AUTO_INCREMENT,
  `email`      varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_otp`   varchar(4)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `timecreate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=12;

-- --------------------------------------------------------
-- Table: `komentar`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `komentar` (
  `Id_komentar` int NOT NULL AUTO_INCREMENT,
  `komentar`    varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id_komentar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=3;

-- --------------------------------------------------------
-- Table: `prodi`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `prodi` (
  `id_prodi`   int NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_prodi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=14;

INSERT INTO `prodi` (`id_prodi`, `nama_prodi`) VALUES
(1, 'IF'),
(2, 'TRM'),
(3, 'RKS'),
(4, 'TRPL');

-- --------------------------------------------------------
-- Table: `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `nim_nik`      bigint NOT NULL,
  `username`     varchar(10)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(50)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email`        varchar(50)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_handphone` varchar(15)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat`       text         CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_prodi`     int NOT NULL,
  `password`     varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role`         enum('Dosen','Mahasiswa','Admin','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`nim_nik`),
  UNIQUE KEY `email`    (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `id_prodi` (`id_prodi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`nim_nik`, `username`, `nama_lengkap`, `email`, `no_handphone`, `alamat`, `id_prodi`, `password`, `role`) VALUES
(217122, 'dosen', 'Dosen Pembimbing 1', 'dosen@gmail.com', '089977554422', 'Polibatam', 4, '$2y$10$P2MYsr9xT4uQt/kw9RIsP.AsSWx0/yZIXTmZ2g.2HzIqwJGXIKP0K', 'Dosen'),
(221271, 'admin', 'Admin - Pem1',       'admin@gmail.com', '081277559877', 'Polibatam', 4, '$2y$10$V3BtrjKHHL.xhf/9OXM.Le7g97oKIIBr1kS3e69IduIPhW0FF9xT2', 'Admin');

-- --------------------------------------------------------
-- Table: `pengajuan_usulan`
-- CHANGELOG:
--   [UPDATE v2] jenis_program: 'Penelitian / Riset' → 'Penelitian/Riset'
--   [UPDATE v2] posisi_di_perusahaan: NOT NULL → DEFAULT NULL (opsional, hanya wajib MSIB)
--   [UPDATE v2] nama_mata_kuliah_jumlah_sks: diperluas ke 2000 char, format KODE|Nama|SKS
--   [UPDATE v2] klaim_mata_kuliah: kolom baru untuk klaim/konversi MK semua program
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pengajuan_usulan` (
  `id_pengajuan`              int NOT NULL AUTO_INCREMENT,
  `nim_nik`                   bigint NOT NULL,
  `dosen_pembimbing`          bigint NOT NULL,
  `jenis_program`             enum(
                                'Penelitian/Riset',
                                'Proyek Kemanusiaan',
                                'Kegiatan Wirausaha',
                                'Studi/Proyek Independen',
                                'Membangun Desa / Kuliah Kerja Nyata Tematik',
                                'Magang Praktik Kerja',
                                'Asistensi Mengajar Di Satuan Pendidikan',
                                'Pertukaran Pelajar'
                              ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alasan_memilih_program`    varchar(500)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `judul_program`             varchar(200)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_mitra`                varchar(200)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `durasi_kegiatan`           varchar(100)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `posisi_di_perusahaan`      varchar(100)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rincian_kegiatan`          text          CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sumber_pendanaan`          varchar(100)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_anggota`            varchar(10)   CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_anggota`              varchar(500)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_pertukaran_pelajar`  enum(
                                'Antar Prodi di Politeknik Negeri Batam',
                                'Antar Prodi pada Perguruan Tinggi yang berbeda',
                                'Prodi sama pada Perguruan Tinggi yang berbeda'
                              ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_program_studi`        varchar(100)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_mata_kuliah_jumlah_sks` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `klaim_mata_kuliah`         varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_pengajuan`          varchar(20)   CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at`                timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengajuan`),
  KEY `nim_nik`          (`nim_nik`),
  KEY `dosen_pembimbing` (`dosen_pembimbing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=11;

-- --------------------------------------------------------
-- Table: `upload_berkas`
-- CHANGELOG:
--   [UPDATE v2] Tambah 7 kolom berkas portofolio sesuai pedoman MBKM (9 dokumen total)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `upload_berkas` (
  `id_berkas`               int NOT NULL AUTO_INCREMENT,
  `id_pengajuan`            int NOT NULL,
  `file_path`               varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dokumen_mbkm`            varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `surat_rekomendasi`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `surat_keterangan_sehat`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `surat_persetujuan_ortu`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `surat_pakta_integritas`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `biodata_cv`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sertifikat_pelatihan`    varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `karya_tulis_produk`      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `komentar`                int DEFAULT NULL,
  `status_berkas`           varchar(20)  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_berkas`),
  KEY `komentar`     (`komentar`),
  KEY `id_pengajuan` (`id_pengajuan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=5;

-- --------------------------------------------------------
-- Foreign Key Constraints
-- --------------------------------------------------------
ALTER TABLE `kode_otp`
  ADD CONSTRAINT `kode_otp_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `pengajuan_usulan`
  ADD CONSTRAINT `pengajuan_usulan_ibfk_1` FOREIGN KEY (`nim_nik`)          REFERENCES `users` (`nim_nik`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pengajuan_usulan_ibfk_2` FOREIGN KEY (`dosen_pembimbing`) REFERENCES `users` (`nim_nik`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `upload_berkas`
  ADD CONSTRAINT `upload_berkas_ibfk_1` FOREIGN KEY (`komentar`)     REFERENCES `komentar` (`Id_komentar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `upload_berkas_ibfk_2` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_usulan` (`id_pengajuan`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`) ON DELETE RESTRICT ON UPDATE RESTRICT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
