<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Dosen') {
    header('Location: ../auth/login.php'); exit();
}
include '../../controllers/proses-dashboard.php';
$pageTitle = 'Rekap Pengajuan';
$activePage = 'rekap';
$profileUrl = '../profil/profile.php';
$changePasswordUrl = 'change-password.php?data=' . ($data['nim_nik'] ?? '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?php include '../partials/page-head.php'; ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border:1px solid #d1d5db; border-radius:0.5rem; padding:0.375rem 0.75rem; font-size:0.875rem;
        }
        table.dataTable thead th { background:#f9fafb; color:#374151; font-weight:600; font-size:0.75rem; text-transform:uppercase; }
        table.dataTable tbody tr:hover { background:#eef2ff; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <?php include '../partials/sidebar-dosen.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
        <?php include '../partials/header.php'; ?>

        <main class="flex-1 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800">Rekap Pengajuan MBKM</h2>
                <p class="text-sm text-gray-500 mt-0.5">Ringkasan semua pengajuan mahasiswa</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="rekapTable" class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIM/NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prodi</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Jml Pengajuan</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jenis Program</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        <?php
                        $sql = "SELECT u.nim_nik, u.nama_lengkap, p.nama_prodi,
                                    GROUP_CONCAT(DISTINCT n.jenis_program ORDER BY n.created_at DESC SEPARATOR '||') AS jenis_program,
                                    GROUP_CONCAT(DATE_FORMAT(n.created_at,'%d/%m/%Y') ORDER BY n.created_at DESC SEPARATOR '||') AS tanggal_pengajuan,
                                    COUNT(n.id_pengajuan) AS jumlah_pengajuan
                                FROM users u
                                INNER JOIN pengajuan_usulan n ON u.nim_nik = n.nim_nik
                                LEFT JOIN prodi p ON u.id_prodi = p.id_prodi
                                GROUP BY u.nim_nik, u.nama_lengkap, p.nama_prodi";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                                $tanggals = explode('||', $row['tanggal_pengajuan']);
                                $jeniss   = explode('||', $row['jenis_program']);
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-mono text-xs text-gray-600"><?= htmlspecialchars($row['nim_nik']) ?></td>
                            <td class="px-4 py-3 font-medium text-gray-800"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                            <td class="px-4 py-3">
                                <span class="inline-block bg-indigo-50 text-indigo-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                    <?= htmlspecialchars($row['nama_prodi'] ?? '—') ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block bg-gray-100 text-gray-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                    <?= $row['jumlah_pengajuan'] ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-xs text-gray-500">
                                <?= implode('<br>', array_map('htmlspecialchars', $tanggals)) ?>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-700">
                                <?php foreach ($jeniss as $j): ?>
                                <span class="inline-block bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full mb-0.5 font-medium">
                                    <?= htmlspecialchars($j) ?>
                                </span><br>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada data pengajuan.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#rekapTable').DataTable({ language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' } });
});
</script>
</body>
</html>
