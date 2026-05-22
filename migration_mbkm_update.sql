-- =============================================================
-- MIGRATION: Update MBKM sesuai Pedoman Merdeka Belajar v5
-- Politeknik Negeri Batam (2021)
-- Jalankan query ini di phpMyAdmin atau MySQL CLI
-- =============================================================

-- 1. Fix ENUM jenis_program: 'Penelitian / Riset' -> 'Penelitian/Riset'
ALTER TABLE `pengajuan_usulan`
  MODIFY COLUMN `jenis_program` enum(
    'Penelitian/Riset',
    'Proyek Kemanusiaan',
    'Kegiatan Wirausaha',
    'Studi/Proyek Independen',
    'Membangun Desa / Kuliah Kerja Nyata Tematik',
    'Magang Praktik Kerja',
    'Asistensi Mengajar Di Satuan Pendidikan',
    'Pertukaran Pelajar'
  ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

-- 2. Jadikan posisi_di_perusahaan nullable (tidak wajib untuk semua program)
ALTER TABLE `pengajuan_usulan`
  MODIFY COLUMN `posisi_di_perusahaan` varchar(100)
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL;

-- 3. Tambah kolom klaim_mata_kuliah (untuk konversi nilai semua jenis program)
ALTER TABLE `pengajuan_usulan`
  ADD COLUMN `klaim_mata_kuliah` varchar(2000)
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
    AFTER `nama_mata_kuliah_jumlah_sks`;

-- 4. Perpanjang nama_mata_kuliah_jumlah_sks (untuk data Pertukaran Pelajar)
ALTER TABLE `pengajuan_usulan`
  MODIFY COLUMN `nama_mata_kuliah_jumlah_sks` varchar(2000)
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL;

-- 5. Tambah kolom berkas portofolio ke upload_berkas (9 dokumen resmi pedoman MBKM)
--    Kolom lama: file_path (transkip), dokumen_mbkm → tetap dipertahankan
ALTER TABLE `upload_berkas`
  ADD COLUMN `surat_rekomendasi`        varchar(255) DEFAULT NULL AFTER `dokumen_mbkm`,
  ADD COLUMN `surat_keterangan_sehat`   varchar(255) DEFAULT NULL AFTER `surat_rekomendasi`,
  ADD COLUMN `surat_persetujuan_ortu`   varchar(255) DEFAULT NULL AFTER `surat_keterangan_sehat`,
  ADD COLUMN `surat_pakta_integritas`   varchar(255) DEFAULT NULL AFTER `surat_persetujuan_ortu`,
  ADD COLUMN `biodata_cv`               varchar(255) DEFAULT NULL AFTER `surat_pakta_integritas`,
  ADD COLUMN `sertifikat_pelatihan`     varchar(255) DEFAULT NULL AFTER `biodata_cv`,
  ADD COLUMN `karya_tulis_produk`       varchar(255) DEFAULT NULL AFTER `sertifikat_pelatihan`;

-- Verifikasi struktur tabel setelah migration
DESCRIBE `pengajuan_usulan`;
DESCRIBE `upload_berkas`;
