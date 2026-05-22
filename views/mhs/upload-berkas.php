<?php
session_start();
if (!isset($_SESSION['username'])) { header('Location: ../auth/login.php'); exit(); }
include '../../controllers/proses-berkas.php';

$id_pengajuan = $_GET['data']    ?? '';
$nim_nik      = $_GET['nim_nik'] ?? '';

$sqlDetail = "SELECT ub.*, k.komentar AS komentar_text FROM upload_berkas ub LEFT JOIN komentar k ON ub.komentar = k.Id_komentar WHERE ub.id_pengajuan = ?";
$stmtDetail = $conn->prepare($sqlDetail);
$stmtDetail->bind_param('i', $id_pengajuan);
$stmtDetail->execute();
$rowDetail = $stmtDetail->get_result()->fetch_assoc();

$statusBerkas = $rowDetail['status_berkas'] ?? null;
$isEditable   = ($statusBerkas !== 'Diterima');

$berkasConfig = [
    ['field'=>'transkip_nilai',       'dbCol'=>'file_path',              'label'=>'Transkrip Nilai',                    'note'=>'Wajib untuk semua pendaftar',                    'required'=>true,  'icon'=>'fa-file-alt'],
    ['field'=>'dokumen_mbkm',         'dbCol'=>'dokumen_mbkm',           'label'=>'Dokumen / Laporan MBKM',             'note'=>'Laporan akhir kegiatan MBKM',                    'required'=>true,  'icon'=>'fa-file-pdf'],
    ['field'=>'surat_rekomendasi',    'dbCol'=>'surat_rekomendasi',      'label'=>'Surat Rekomendasi PT / Jurusan Asal','note'=>'Wajib untuk pendaftar dari luar Polibatam',      'required'=>false, 'icon'=>'fa-envelope-open-text'],
    ['field'=>'surat_keterangan_sehat','dbCol'=>'surat_keterangan_sehat','label'=>'Surat Keterangan Sehat',             'note'=>'Dari dokter/fasilitas kesehatan',                'required'=>false, 'icon'=>'fa-heartbeat'],
    ['field'=>'surat_persetujuan_ortu','dbCol'=>'surat_persetujuan_ortu','label'=>'Surat Persetujuan Orang Tua',        'note'=>'Dilengkapi materai Rp10.000',                    'required'=>false, 'icon'=>'fa-home'],
    ['field'=>'surat_pakta_integritas','dbCol'=>'surat_pakta_integritas','label'=>'Surat Pakta Integritas',             'note'=>'Pernyataan kesediaan mengikuti ketentuan MBKM', 'required'=>false, 'icon'=>'fa-file-signature'],
    ['field'=>'biodata_cv',           'dbCol'=>'biodata_cv',             'label'=>'Biodata / Curriculum Vitae (CV)',    'note'=>'CV terbaru',                                     'required'=>false, 'icon'=>'fa-id-card'],
    ['field'=>'sertifikat_pelatihan', 'dbCol'=>'sertifikat_pelatihan',   'label'=>'Sertifikat Pelatihan / Workshop',    'note'=>'Jika ada (opsional)',                            'required'=>false, 'icon'=>'fa-certificate'],
    ['field'=>'karya_tulis_produk',   'dbCol'=>'karya_tulis_produk',     'label'=>'Karya Tulis / Produk',               'note'=>'Jika ada (opsional)',                            'required'=>false, 'icon'=>'fa-book-open'],
];

// Determine logged-in user role for dynamic sidebar/view-mode
$currentUser = $data; // proses-berkas.php already set $data = current session user
$userRole    = $currentUser['role'] ?? 'Mahasiswa';

// Dosen can only view, not edit
if ($userRole === 'Dosen') {
    $isEditable = false;
}

$pageTitle = 'Upload Berkas MBKM';
$activePage = 'rekap';
$profileUrl = '../profil/profile.php';
$changePasswordUrl = ($userRole === 'Dosen')
    ? '../dosen/change-password.php?data=' . htmlspecialchars($currentUser['nim_nik'] ?? '')
    : (($userRole === 'Admin')
        ? '../admin/change-password.php?data=' . htmlspecialchars($currentUser['nim_nik'] ?? '')
        : 'change-password.php?data=' . htmlspecialchars($nim_nik));

$backUrl  = ($userRole === 'Mahasiswa')
    ? "rekap-pengajuan.php?nim_nik=" . htmlspecialchars($nim_nik)
    : "../dosen/persetujuan-pengajuan.php";
$backText = ($userRole === 'Mahasiswa') ? 'Kembali ke Rekap' : 'Kembali ke Persetujuan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<?php include '../partials/page-head.php'; ?>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
<?php
if ($userRole === 'Dosen') {
    include '../partials/sidebar-dosen.php';
} elseif ($userRole === 'Admin') {
    include '../partials/sidebar-admin.php';
} else {
    include '../partials/sidebar-mhs.php';
}
?>
<div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
<?php include '../partials/header.php'; ?>
<main class="flex-1 p-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <?php if ($userRole === 'Mahasiswa'): ?>
            <a href="rekap-pengajuan.php?nim_nik=<?= htmlspecialchars($nim_nik) ?>" class="hover:text-blue-600 transition">Rekap Pengajuan</a>
        <?php else: ?>
            <a href="../dosen/persetujuan-pengajuan.php" class="hover:text-blue-600 transition">Persetujuan Pengajuan</a>
        <?php endif; ?>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Upload Berkas</span>
    </div>

    <div class="mb-5">
        <h2 class="text-xl font-bold text-gray-800">Upload Berkas Portofolio MBKM</h2>
        <p class="text-sm text-gray-500 mt-0.5">Pedoman MBKM v5 — Formulir No. BO.8.7.1-V0</p>
    </div>

    <!-- Status Banner -->
    <?php
    $bannerCfg = [
        'Diterima'             => ['bg-green-50 border-green-200 text-green-800', 'fa-check-circle text-green-500', 'Berkas Anda telah <strong>Diterima</strong>. Tidak ada perubahan yang dapat dilakukan.'],
        'Ditolak'              => ['bg-red-50 border-red-200 text-red-800',       'fa-times-circle text-red-500',   'Berkas Anda <strong>Ditolak</strong>. Silakan upload ulang berkas yang diperlukan.'],
        'Menunggu Persetujuan' => ['bg-yellow-50 border-yellow-200 text-yellow-800','fa-clock text-yellow-500',     'Berkas sedang <strong>Menunggu Persetujuan</strong> dari reviewer.'],
    ];
    $bc = $bannerCfg[$statusBerkas] ?? ['bg-gray-50 border-gray-200 text-gray-600','fa-info-circle text-gray-400','Belum ada berkas yang diupload.'];
    ?>
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border <?= $bc[0] ?> mb-5 text-sm">
        <i class="fas <?= $bc[1] ?> text-lg flex-shrink-0"></i>
        <span><?= $bc[2] ?></span>
    </div>

    <?php if ($userRole === 'Dosen'): ?>
    <!-- View-Only Banner for Dosen -->
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border bg-indigo-50 border-indigo-200 text-indigo-800 mb-5 text-sm">
        <i class="fas fa-eye text-indigo-500 text-lg flex-shrink-0"></i>
        <span><strong>Mode Lihat Saja.</strong> Anda sedang mengakses berkas mahasiswa sebagai Dosen. Berkas tidak dapat diedit dari portal ini.</span>
    </div>
    <?php endif; ?>

    <!-- Komentar Reviewer -->
    <?php if (!empty($rowDetail['komentar_text'])): ?>
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 mb-5 text-sm text-yellow-800">
        <p class="font-semibold mb-1"><i class="fas fa-comment-alt mr-1"></i> Komentar Reviewer:</p>
        <p><?= nl2br(htmlspecialchars($rowDetail['komentar_text'])) ?></p>
    </div>
    <?php endif; ?>

    <!-- Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 mb-5 text-xs text-blue-700">
        <i class="fas fa-info-circle mr-1"></i>
        Format: <strong>PDF, JPG, PNG</strong> — Maks. <strong>5 MB</strong> per file.
        Mahasiswa dengan IPK &lt; 2,75 wajib melampirkan semua dokumen portofolio.
    </div>

    <!-- Form Upload -->
    <form action="../../controllers/proses-upload-berkas.php?data=<?= htmlspecialchars($id_pengajuan) ?>&nim_nik=<?= htmlspecialchars($nim_nik) ?>"
          method="POST" enctype="multipart/form-data">

        <div class="space-y-3 mb-6">
        <?php foreach ($berkasConfig as $berkas):
            $existPath = $rowDetail[$berkas['dbCol']] ?? null;
        ?>
        <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-sm transition">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0 mt-0.5">
                    <i class="fas <?= $berkas['icon'] ?> text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-sm font-semibold text-gray-800"><?= htmlspecialchars($berkas['label']) ?></span>
                        <?php if ($berkas['required']): ?>
                        <span class="inline-block text-xs bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-semibold">WAJIB</span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs text-gray-500 mb-2"><?= htmlspecialchars($berkas['note']) ?></p>

                    <?php if (!empty($existPath)): ?>
                    <div class="flex items-center gap-1.5 text-xs text-green-700 mb-2">
                        <i class="fas fa-check-circle"></i>
                        <a href="<?= htmlspecialchars($existPath) ?>" target="_blank" class="hover:underline font-medium">
                            <?= htmlspecialchars(basename($existPath)) ?>
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if ($isEditable): ?>
                    <input type="file" name="<?= $berkas['field'] ?>" id="file_<?= $berkas['field'] ?>"
                        accept=".pdf,.jpg,.jpeg,.png"
                        <?= ($berkas['required'] && empty($existPath)) ? 'required' : '' ?>
                        class="block w-full text-xs text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    <?php if (!empty($existPath)): ?>
                    <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengganti file.</p>
                    <?php endif; ?>
                    <?php else: ?>
                    <p class="text-xs text-gray-400 flex items-center gap-1">
                        <i class="fas fa-lock"></i>
                        <?= ($userRole === 'Dosen') ? 'Mode lihat saja — Anda tidak dapat mengubah berkas.' : 'Berkas telah diterima dan tidak dapat diubah.' ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <?php if ($isEditable): ?>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Berkas
            </button>
            <?php endif; ?>
            <a href="<?= $backUrl ?>"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> <?= htmlspecialchars($backText) ?>
            </a>
        </div>
    </form>
</main>
</div>
</div>

<script>
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function() {
        const file = this.files[0];
        if (file && file.size > 5 * 1024 * 1024) {
            Swal.fire({ title: 'File Terlalu Besar', text: `"${file.name}" melebihi batas 5 MB.`, icon: 'warning', confirmButtonColor: '#3b82f6' });
            this.value = '';
        }
    });
});
</script>
</body>
</html>
