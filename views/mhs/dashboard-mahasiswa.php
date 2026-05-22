<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Mahasiswa') {
    header('Location: ../auth/login.php'); exit();
}
include '../../controllers/proses-berkas.php';

// Count pengajuan
$stmtCount = $conn->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN status_pengajuan='Diterima' THEN 1 ELSE 0 END) as diterima, SUM(CASE WHEN status_pengajuan='Menunggu Persetujuan' THEN 1 ELSE 0 END) as menunggu FROM pengajuan_usulan WHERE nim_nik = ?");
$stmtCount->bind_param('s', $data['nim_nik']);
$stmtCount->execute();
$counts = $stmtCount->get_result()->fetch_assoc();

$pageTitle = 'Dashboard Mahasiswa';
$activePage = 'dashboard';
$profileUrl = '../profil/profile.php';
$changePasswordUrl = 'change-password.php?data=' . ($data['nim_nik'] ?? '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<?php include '../partials/page-head.php'; ?>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
<?php include '../partials/sidebar-mhs.php'; ?>
<div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
<?php include '../partials/header.php'; ?>
<main class="flex-1 p-6">

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white mb-6 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold mb-1">Selamat Datang, <?= htmlspecialchars($data['nama_lengkap']) ?>!</h2>
                <p class="text-blue-100 text-sm">Sistem Informasi MBKM — Politeknik Negeri Batam</p>
            </div>
            <div class="hidden sm:block w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold">
                <?= strtoupper(substr($data['nama_lengkap'], 0, 1)) ?>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                <i class="fas fa-file-alt text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Pengajuan</p>
                <p class="text-2xl font-bold text-gray-800"><?= $counts['total'] ?? 0 ?></p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center text-yellow-600 flex-shrink-0">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Menunggu Persetujuan</p>
                <p class="text-2xl font-bold text-gray-800"><?= $counts['menunggu'] ?? 0 ?></p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600 flex-shrink-0">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Diterima</p>
                <p class="text-2xl font-bold text-gray-800"><?= $counts['diterima'] ?? 0 ?></p>
            </div>
        </div>
    </div>

    <!-- Profile + Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Profile Card -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-blue-50 border-b border-blue-100 px-6 py-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg">
                    <?= strtoupper(substr($data['nama_lengkap'], 0, 1)) ?>
                </div>
                <div>
                    <p class="font-semibold text-gray-800"><?= htmlspecialchars($data['nama_lengkap']) ?></p>
                    <span class="inline-block text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-medium">Mahasiswa</span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <?php
                    $fields = [
                        'NIM / NIK'      => $data['nim_nik'],
                        'Username'       => $data['username'],
                        'Email'          => $data['email'],
                        'No. Handphone'  => $data['phone'],
                        'Program Studi'  => $prodi,
                        'Alamat'         => $data['alamat'],
                    ];
                    foreach ($fields as $label => $value): ?>
                    <div class="flex flex-col gap-0.5">
                        <span class="text-xs text-gray-400 font-medium"><?= $label ?></span>
                        <span class="text-sm text-gray-800 font-medium"><?= htmlspecialchars($value ?? '—') ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="formulir.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>"
                    class="flex items-center gap-3 p-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 transition group">
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center text-white flex-shrink-0">
                        <i class="fas fa-plus text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Buat Pengajuan</p>
                        <p class="text-xs text-blue-500">Daftar program MBKM</p>
                    </div>
                </a>
                <a href="rekap-pengajuan.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>"
                    class="flex items-center gap-3 p-3 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 transition">
                    <div class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center text-white flex-shrink-0">
                        <i class="fas fa-list-alt text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Rekap Pengajuan</p>
                        <p class="text-xs text-indigo-500">Pantau status pengajuan</p>
                    </div>
                </a>
                <a href="../profil/profile.php"
                    class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-700 transition">
                    <div class="w-9 h-9 rounded-lg bg-gray-600 flex items-center justify-center text-white flex-shrink-0">
                        <i class="fas fa-user-edit text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Edit Profil</p>
                        <p class="text-xs text-gray-500">Perbarui data diri</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

</main>
</div>
</div>
</body>
</html>

