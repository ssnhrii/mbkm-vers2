<?php
session_start();
include '../controllers/koneksi.php';

$sql = "SELECT u.nim_nik, u.nama_lengkap, p.nama_prodi, COUNT(pu.nim_nik) AS total_pengajuan
        FROM pengajuan_usulan pu
        JOIN users u ON pu.nim_nik = u.nim_nik
        LEFT JOIN prodi p ON u.id_prodi = p.id_prodi
        GROUP BY u.nim_nik, u.nama_lengkap, p.nama_prodi
        ORDER BY u.nim_nik";
$result = $conn->query($sql);
$rows = [];
while ($r = $result->fetch_assoc()) $rows[] = $r;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rekap Pengajuan — MBKM Polibatam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select { border:1px solid #d1d5db; border-radius:0.5rem; padding:0.375rem 0.75rem; font-size:0.875rem; }
        table.dataTable thead th { background:#f9fafb; color:#374151; font-weight:600; font-size:0.75rem; text-transform:uppercase; }
        table.dataTable tbody tr:hover { background:#eff6ff; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Rekap Pengajuan MBKM</h1>
            <p class="text-sm text-gray-500 mt-0.5">Ringkasan total pengajuan per mahasiswa</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table id="rekapTable" class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIM</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prodi</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Total Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($rows as $row): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-mono text-xs text-gray-600"><?= htmlspecialchars($row['nim_nik']) ?></td>
                            <td class="px-4 py-3 font-medium text-gray-800"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                            <td class="px-4 py-3">
                                <span class="inline-block bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                    <?= htmlspecialchars($row['nama_prodi'] ?? '—') ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block bg-gray-100 text-gray-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                    <?= $row['total_pengajuan'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($rows)): ?>
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada data pengajuan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
