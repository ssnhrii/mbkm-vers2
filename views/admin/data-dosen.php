<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../auth/login.php'); exit();
}
include '../../controllers/koneksi.php';
include '../../controllers/proses-dashboard.php';
$pageTitle = 'Manajemen User';
$activePage = 'manajemen';
$profileUrl = '../profil/profile.php';
$changePasswordUrl = 'change-password.php?data=' . ($data['nim_nik'] ?? '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?php include '../partials/page-head.php'; ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_filter input { border:1px solid #d1d5db; border-radius:0.5rem; padding:0.375rem 0.75rem; font-size:0.875rem; }
        .dataTables_wrapper .dataTables_length select { border:1px solid #d1d5db; border-radius:0.5rem; padding:0.25rem 0.5rem; font-size:0.875rem; }
        table.dataTable thead th { background:#f9fafb; color:#374151; font-weight:600; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; }
        table.dataTable tbody tr:hover { background:#f0fdf4; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <?php include '../partials/sidebar-admin.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
        <?php include '../partials/header.php'; ?>

        <main class="flex-1 p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Manajemen User Dosen</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Kelola data dosen yang terdaftar di sistem</p>
                </div>
                <a href="daftar-dosen.php"
                    class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition shadow-sm">
                    <i class="fas fa-plus"></i> Tambah Dosen
                </a>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="dosenTable" class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIM/NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prodi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No. HP</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Alamat</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php
                            $sql = "SELECT u.nim_nik, u.nama_lengkap, p.nama_prodi, u.phone, u.alamat
                                    FROM users u LEFT JOIN prodi p ON u.id_prodi = p.id_prodi
                                    WHERE u.role = 'dosen'";
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0):
                                while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-mono text-xs text-gray-600"><?= htmlspecialchars($row['nim_nik']) ?></td>
                                <td class="px-4 py-3 font-medium text-gray-800"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                <td class="px-4 py-3">
                                    <span class="inline-block bg-emerald-50 text-emerald-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                        <?= htmlspecialchars($row['nama_prodi'] ?? '—') ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600"><?= htmlspecialchars($row['phone']) ?></td>
                                <td class="px-4 py-3 text-gray-600 max-w-xs truncate"><?= htmlspecialchars($row['alamat']) ?></td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="edit-dosen.php?nim_nik=<?= urlencode($row['nim_nik']) ?>"
                                            class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button onclick="confirmDelete('<?= urlencode($row['nim_nik']) ?>', '<?= addslashes(htmlspecialchars($row['nama_lengkap'])) ?>')"
                                            class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                                <?php endwhile;
                            else: ?>
                            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada data dosen.</td></tr>
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
    $('#dosenTable').DataTable({ language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' } });

    const p = new URLSearchParams(window.location.search);
    const msg = p.get('message');
    if (msg === 'success') Swal.fire({ title: 'Berhasil!', text: 'Data dosen berhasil dihapus.', icon: 'success', confirmButtonColor: '#10b981' });
    else if (msg === 'error') Swal.fire({ title: 'Gagal!', text: 'Terjadi kesalahan saat menghapus data.', icon: 'error', confirmButtonColor: '#10b981' });
});

function confirmDelete(nimNik, nama) {
    Swal.fire({
        title: 'Hapus Dosen?',
        html: `Data <strong>${nama}</strong> akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then(r => {
        if (r.isConfirmed) window.location.href = `../../controllers/delete_dosen.php?nim_nik=${nimNik}`;
    });
}
</script>
</body>
</html>

