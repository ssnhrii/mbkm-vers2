<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Dosen') {
    header('Location: ../auth/login.php'); exit();
}
include '../../controllers/proses-dashboard.php';
$pageTitle = 'Persetujuan Pengajuan';
$activePage = 'persetujuan';
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
        table.dataTable thead th { background:#f9fafb; color:#374151; font-weight:600; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em; }
        table.dataTable tbody tr:hover { background:#eef2ff; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <?php include '../partials/sidebar-dosen.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
        <?php include '../partials/header.php'; ?>

        <main class="flex-1 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Persetujuan Pengajuan MBKM</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Tinjau dan setujui pengajuan mahasiswa</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="pengajuanTable" class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIM/NIK</th>
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
                        $sql = "SELECT p.*, u1.nim_nik AS mhs_nim, u3.nama_lengkap AS nama_pengaju, pr.nama_prodi
                                FROM pengajuan_usulan p
                                INNER JOIN users u1 ON p.nim_nik = u1.nim_nik
                                INNER JOIN users u3 ON p.nim_nik = u3.nim_nik
                                INNER JOIN prodi pr ON u1.id_prodi = pr.id_prodi";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                                // Fetch berkas
                                $stmtB = $conn->prepare("SELECT * FROM upload_berkas WHERE id_pengajuan = ?");
                                $stmtB->bind_param('i', $row['id_pengajuan']);
                                $stmtB->execute();
                                $rowBerkas = $stmtB->get_result()->fetch_assoc();

                                $statusColors = [
                                    'Menunggu Persetujuan' => 'bg-yellow-100 text-yellow-800',
                                    'Diterima'             => 'bg-green-100 text-green-800',
                                    'Ditolak'              => 'bg-red-100 text-red-800',
                                ];
                                $sc = $statusColors[$row['status_pengajuan']] ?? 'bg-gray-100 text-gray-600';
                                $bc = $statusColors[$rowBerkas['status_berkas'] ?? ''] ?? 'bg-gray-100 text-gray-400';
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-mono text-xs text-gray-600"><?= htmlspecialchars($row['mhs_nim']) ?></td>
                            <td class="px-4 py-3 font-medium text-gray-800"><?= htmlspecialchars($row['nama_pengaju']) ?></td>
                            <td class="px-4 py-3">
                                <span class="inline-block bg-indigo-50 text-indigo-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                    <?= htmlspecialchars($row['nama_prodi']) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-xs text-gray-500">
                                <?= $row['created_at'] ? date('d/m/Y', strtotime($row['created_at'])) : '—' ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full <?= $sc ?>">
                                    <?= htmlspecialchars($row['status_pengajuan'] ?? '—') ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <?php if ($rowBerkas && $rowBerkas['status_berkas']): ?>
                                <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full <?= $bc ?>">
                                    <?= htmlspecialchars($rowBerkas['status_berkas']) ?>
                                </span>
                                <?php else: ?>
                                <span class="text-xs text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <a href="../mhs/detail-pengajuan.php?data=<?= $row['id_pengajuan'] ?>&nim_nik=<?= $row['nim_nik'] ?>"
                                        class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition">
                                        <i class="fas fa-eye"></i> Form
                                    </a>
                                    <?php if ($rowBerkas && in_array($rowBerkas['status_berkas'], ['Menunggu Persetujuan','Diterima'])): ?>
                                    <a href="../mhs/upload-berkas.php?data=<?= $row['id_pengajuan'] ?>&nim_nik=<?= $row['nim_nik'] ?>"
                                        class="inline-flex items-center gap-1 bg-cyan-50 hover:bg-cyan-100 text-cyan-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition">
                                        <i class="fas fa-folder-open"></i> Berkas
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <?php if ($row['status_pengajuan'] === 'Menunggu Persetujuan'): ?>
                                <div class="flex flex-col items-center gap-1">
                                    <a href="../../controllers/terima_pengajuan.php?data=<?= $row['id_pengajuan'] ?>&nim_nik=<?= $row['nim_nik'] ?>"
                                        onclick="return confirmAction(event, this.href, 'Terima Pengajuan?', 'Pengajuan akan disetujui.', 'Terima', '#10b981')"
                                        class="inline-flex items-center gap-1 bg-green-50 hover:bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition w-full justify-center">
                                        <i class="fas fa-check"></i> Terima
                                    </a>
                                    <a href="../../controllers/tolak_pengajuan.php?data=<?= $row['id_pengajuan'] ?>&nim_nik=<?= $row['nim_nik'] ?>"
                                        onclick="return confirmAction(event, this.href, 'Tolak Pengajuan?', 'Pengajuan akan ditolak.', 'Tolak', '#ef4444')"
                                        class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition w-full justify-center">
                                        <i class="fas fa-times"></i> Tolak
                                    </a>
                                </div>
                                <?php elseif ($row['status_pengajuan'] === 'Diterima' && $rowBerkas && $rowBerkas['status_berkas'] === 'Menunggu Persetujuan'): ?>
                                <div class="flex flex-col items-center gap-1">
                                    <a href="../../controllers/terima_berkas.php?data=<?= $row['id_pengajuan'] ?>&nim_nik=<?= $row['nim_nik'] ?>"
                                        onclick="return confirmAction(event, this.href, 'Terima Berkas?', 'Berkas akhir akan disetujui.', 'Terima', '#10b981')"
                                        class="inline-flex items-center gap-1 bg-green-50 hover:bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition w-full justify-center">
                                        <i class="fas fa-check"></i> Terima
                                    </a>
                                    <button onclick="openTolakModal(<?= $row['id_pengajuan'] ?>, <?= $row['nim_nik'] ?>)"
                                        class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium px-2.5 py-1.5 rounded-lg transition w-full justify-center">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>
                                <?php else: ?>
                                <span class="text-xs text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada data pengajuan.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Tolak Berkas -->
<div id="tolakModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-800">Alasan Penolakan Berkas</h3>
            <button onclick="closeTolakModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form action="../../controllers/tolak_berkas.php" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Komentar / Alasan</label>
                <textarea name="comment" rows="4" required placeholder="Tuliskan alasan penolakan..."
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 transition resize-none"></textarea>
            </div>
            <input type="hidden" name="id_pengajuan" id="modal_id_pengajuan">
            <input type="hidden" name="nim_nik" id="modal_nim_nik">
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">
                    Tolak Berkas
                </button>
                <button type="button" onclick="closeTolakModal()"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-lg text-sm transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#pengajuanTable').DataTable({ language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' } });
});

function confirmAction(e, href, title, text, btnText, color) {
    e.preventDefault();
    Swal.fire({
        title, text, icon: 'question',
        showCancelButton: true,
        confirmButtonColor: color,
        cancelButtonColor: '#6b7280',
        confirmButtonText: btnText,
        cancelButtonText: 'Batal'
    }).then(r => { if (r.isConfirmed) window.location.href = href; });
    return false;
}

function openTolakModal(id, nim) {
    document.getElementById('modal_id_pengajuan').value = id;
    document.getElementById('modal_nim_nik').value = nim;
    document.getElementById('tolakModal').classList.remove('hidden');
}
function closeTolakModal() {
    document.getElementById('tolakModal').classList.add('hidden');
}
</script>
</body>
</html>
