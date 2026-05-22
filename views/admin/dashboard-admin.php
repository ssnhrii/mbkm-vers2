<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../auth/login.php'); exit();
}
include '../../controllers/proses-dashboard.php';
$pageTitle = 'Dashboard Admin';
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
    <?php include '../partials/sidebar-admin.php'; ?>

    <!-- Main -->
    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
        <?php include '../partials/header.php'; ?>

        <main class="flex-1 p-6">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-500 rounded-2xl p-6 text-white mb-6 shadow-md">
                <h2 class="text-xl font-bold mb-1">Selamat Datang, <?= htmlspecialchars($data['nama_lengkap']) ?>!</h2>
                <p class="text-emerald-100 text-sm">Panel Admin — Sistem Informasi MBKM Politeknik Negeri Batam</p>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-emerald-50 border-b border-emerald-100 px-6 py-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-lg">
                        <?= strtoupper(substr($data['nama_lengkap'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($data['nama_lengkap']) ?></p>
                        <span class="inline-block text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium">
                            <?= htmlspecialchars($data['role']) ?>
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Informasi Akun</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php
                        $fields = [
                            'NIM / NIK'      => $data['nim_nik'],
                            'Username'       => $data['username'],
                            'Nama Lengkap'   => $data['nama_lengkap'],
                            'Email'          => $data['email'],
                            'No. Handphone'  => $data['phone'],
                            'Alamat'         => $data['alamat'],
                            'Program Studi'  => $prodi,
                            'Role'           => $data['role'],
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
                            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            <i class="fas fa-user-edit"></i> Edit Profil
                        </a>
                        <a href="data-dosen.php"
                            class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
                            <i class="fas fa-users-cog"></i> Manajemen User
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>

