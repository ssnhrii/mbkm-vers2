<?php
session_start();
if (!isset($_SESSION['username'])) { header('Location: ../auth/login.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengajuan Terkirim — MBKM Polibatam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md text-center">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Icon -->
            <div class="w-20 h-20 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-clock text-yellow-500 text-3xl"></i>
            </div>

            <h1 class="text-xl font-bold text-gray-800 mb-2">Pengajuan Berhasil Dikirim!</h1>
            <p class="text-sm text-gray-500 mb-6">
                Pengajuan MBKM Anda telah berhasil dikirim dan sedang menunggu persetujuan dari dosen pembimbing.
                Anda akan mendapat notifikasi setelah pengajuan diproses.
            </p>

            <!-- Spinner -->
            <div class="flex items-center justify-center gap-2 text-sm text-yellow-600 bg-yellow-50 rounded-xl px-4 py-3 mb-6">
                <svg class="animate-spin h-4 w-4 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Menunggu persetujuan...
            </div>

            <div class="flex gap-3">
                <a href="rekap-pengajuan.php"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                    <i class="fas fa-list-alt"></i> Lihat Rekap
                </a>
                <a href="dashboard-mahasiswa.php"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-4">&copy; <?= date('Y') ?> MBKM Politeknik Negeri Batam</p>
    </div>
</body>
</html>
