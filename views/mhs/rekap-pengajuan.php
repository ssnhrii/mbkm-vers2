<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Mahasiswa') {
    header('Location: ../auth/login.php'); exit();
}
include '../../controllers/proses-berkas.php';
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
        table.dataTable tbody tr:hover { background:#eff6ff; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <?php include '../partials/sidebar-mhs.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
        <?php include '../partials/header.php'; ?>

        <main class="flex-1 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Rekap Pengajuan MBKM</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Pantau status pengajuan dan berkas Anda</p>
                </div>
                <a href="formulir.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition shadow-sm">
                    <i class="fas fa-plus"></i> Pengajuan Baru
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="rekapTable" class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIM</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prodi</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Tgl Pengajuan</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status Pengajuan</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status Berkas</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Detail</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        <?php
                        $sql = "SELECT u.nim_nik, u.nama_lengkap, p.nama_prodi, n.created_at, n.status_pengajuan, n.id_pengajuan
                                FROM users u
                                LEFT JOIN pengajuan_usulan n ON u.nim_nik = n.nim_nik
                                LEFT JOIN prodi p ON u.id_prodi = p.id_prodi
                                WHERE u.nim_nik = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('s', $data['nim_nik']);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $statusColors = [
                            'Menunggu Persetujuan' => 'bg-yellow-100 text-yellow-800',
                            'Diterima'             => 'bg-green-100 text-green-800',
                            'Ditolak'              => 'bg-red-100 text-red-800',
                        ];

                        if ($result && $result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                                $rowBerkas = null;
                                if ($row['id_pengajuan'] && $row['status_pengajuan'] === 'Diterima') {
                                    $stmtB = $conn->prepare("SELECT * FROM upload_berkas WHERE id_pengajuan = ?");
                                    $stmtB->bind_param('i', $row['id_pengajuan']);
                                    $stmtB->execute();
                                    $rowBerkas = $stmtB->get_result()->fetch_assoc();
                                }
                                $sc = $statusColors[$row['status_pengajuan']] ?? 'bg-gray-100 text-gray-500';
                                $bc = $statusColors[$rowBerkas['status_berkas'] ?? ''] ?? 'bg-orange-100 text-orange-700';
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-mono text-xs text-gray-600"><?= htmlspecialchars($row['nim_nik']) ?></td>
                            <td class="px-4 py-3 font-medium text-gray-800"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                            <td class="px-4 py-3">
                                <span class="inline-block bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                    <?= htmlspecialchars($row['nama_prodi'] ?? '—') ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-xs text-gray-500">
                                <?= $row['created_at'] ? date('d/m/Y', strtotime($row['created_at'])) : '—' ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <?php if ($row['status_pengajuan']): ?>
                                <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full <?= $sc ?>">
                                    <?= htmlspecialchars($row['status_pengajuan']) ?>
                                </span>
                                <?php else: ?>
                                <span class="text-xs text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <?php if ($row['status_pengajuan'] === 'Diterima'): ?>
                                    <?php if ($rowBerkas && $rowBerkas['status_berkas']): ?>
                                    <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full <?= $bc ?>">
                                        <?= htmlspecialchars($rowBerkas['status_berkas']) ?>
                                    </span>
                                    <?php else: ?>
                                    <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-100 text-orange-700">
                                        Belum Upload
                                    </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                <span class="text-xs text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <?php if ($row['id_pengajuan']): ?>
                                    <a href="detail-pengajuan.php?data=<?= $row['id_pengajuan'] ?>&nim_nik=<?= $row['nim_nik'] ?>"
                                        class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition">
                                        <i class="fas fa-eye"></i> Form
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($rowBerkas && in_array($rowBerkas['status_berkas'], ['Menunggu Persetujuan','Diterima','Ditolak'])): ?>
                                    <a href="upload-berkas.php?data=<?= $row['id_pengajuan'] ?>&nim_nik=<?= $row['nim_nik'] ?>"
                                        class="inline-flex items-center gap-1 bg-cyan-50 hover:bg-cyan-100 text-cyan-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition">
                                        <i class="fas fa-folder-open"></i> Berkas
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <?php if ($row['status_pengajuan'] === 'Menunggu Persetujuan'): ?>
                                <div class="flex flex-col items-center gap-1">
                                    <a href="edit-pengajuan.php?data=<?= $row['id_pengajuan'] ?>&nim_nik=<?= $row['nim_nik'] ?>"
                                        class="inline-flex items-center gap-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition w-full justify-center">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="confirmDelete('<?= $row['id_pengajuan'] ?>', '<?= $row['nim_nik'] ?>')"
                                        class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition w-full justify-center">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                                <?php elseif ($row['status_pengajuan'] === 'Diterima' && (!$rowBerkas || $rowBerkas['status_berkas'] === 'Ditolak')): ?>
                                <a href="upload-berkas.php?data=<?= $row['id_pengajuan'] ?>&nim_nik=<?= $row['nim_nik'] ?>"
                                    class="inline-flex items-center gap-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition">
                                    <i class="fas fa-upload"></i> Upload Berkas
                                </a>
                                <?php else: ?>
                                <span class="text-xs text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">
                            Anda belum memiliki pengajuan.
                            <a href="formulir.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>" class="text-blue-600 hover:underline ml-1">Buat pengajuan sekarang</a>
                        </td></tr>
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

function confirmDelete(id, nim) {
    Swal.fire({
        title: 'Hapus Pengajuan?',
        text: 'Data pengajuan akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then(r => {
        if (r.isConfirmed) window.location.href = `../../controllers/delete_pengajuan.php?data=${id}&nim_nik=${nim}`;
    });
}
</script>
</body>
</html>
