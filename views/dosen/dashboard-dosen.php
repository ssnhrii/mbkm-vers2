<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Dosen') {
    header('Location: ../auth/login.php'); exit();
}
include '../../controllers/proses-dashboard.php';
$pageTitle = 'Dashboard Dosen';
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
    <?php include '../partials/sidebar-dosen.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
        <?php include '../partials/header.php'; ?>

        <main class="flex-1 p-6">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white mb-6 shadow-md">
                <h2 class="text-xl font-bold mb-1">Selamat Datang, <?= htmlspecialchars($data['nama_lengkap']) ?>!</h2>
                <p class="text-indigo-100 text-sm">Panel Dosen — Sistem Informasi MBKM Politeknik Negeri Batam</p>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-indigo-50 border-b border-indigo-100 px-6 py-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-lg">
                        <?= strtoupper(substr($data['nama_lengkap'] ?? 'D', 0, 1)) ?>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($data['nama_lengkap']) ?></p>
                        <span class="inline-block text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full font-medium">Dosen</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Informasi Dosen</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php
                        $fields = [
                            'NIK'           => $data['nim_nik'],
                            'Username'      => $data['username'],
                            'Nama Lengkap'  => $data['nama_lengkap'],
                            'Email'         => $data['email'],
                            'No. Handphone' => $data['phone'],
                            'Alamat'        => $data['alamat'],
                            'Program Studi' => $prodi,
                        ];
                        foreach ($fields as $label => $value): ?>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs text-gray-400 font-medium"><?= $label ?></span>
                            <span class="text-sm text-gray-800 font-medium"><?= htmlspecialchars($value ?? '—') ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <a href="<?= htmlspecialchars($profileUrl) ?>"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            <i class="fas fa-user-edit"></i> Edit Profil
                        </a>
                        <a href="persetujuan-pengajuan.php"
                            class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
                            <i class="fas fa-clipboard-check"></i> Lihat Pengajuan
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>

