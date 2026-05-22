<?php
// views/mhs/detail-pengajuan.php
include '../../controllers/proses-formulir.php';

// Session verification & currentUser fetching
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php'); exit();
}
$username = $_SESSION['username'];
$stmtUser = $conn->prepare("SELECT nim_nik, username, nama_lengkap, email, phone, alamat, id_prodi, role FROM users WHERE username = ?");
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$currentUser = $stmtUser->get_result()->fetch_assoc();
if (!$currentUser) {
    header('Location: ../auth/login.php'); exit();
}

$id_pengajuan = $_GET['data'] ?? '';
$sqlDetail = "SELECT pu.*, u.nama_lengkap AS nama_dosen, pr.nama_prodi
              FROM pengajuan_usulan pu
              LEFT JOIN users u ON pu.dosen_pembimbing = u.nim_nik
              LEFT JOIN users umhs ON pu.nim_nik = umhs.nim_nik
              LEFT JOIN prodi pr ON umhs.id_prodi = pr.id_prodi
              WHERE pu.id_pengajuan = ?";
$stmtDetail = $conn->prepare($sqlDetail);
$stmtDetail->bind_param('i', $id_pengajuan);
$stmtDetail->execute();
$rowDetail = $stmtDetail->get_result()->fetch_assoc();

function parseMKString($str) {
    if (empty(trim($str))) return [];
    $rows = [];
    foreach (explode(',', $str) as $item) {
        $p = explode('|', trim($item));
        if (count($p) >= 3) $rows[] = ['kode'=>$p[0],'nama'=>$p[1],'sks'=>$p[2]];
        elseif (!empty($p[0])) $rows[] = ['kode'=>'','nama'=>$p[0],'sks'=>''];
    }
    return $rows;
}
$pertukaranMKRows = parseMKString($rowDetail['nama_mata_kuliah_jumlah_sks'] ?? '');
$klaimMKRows      = parseMKString($rowDetail['klaim_mata_kuliah'] ?? '');

$pageTitle = 'Detail Pengajuan';
$activePage = 'rekap';
$profileUrl = '../profil/profile.php';
$changePasswordUrl = ($currentUser['role'] ?? '') === 'Dosen'
    ? '../dosen/change-password.php?data=' . ($currentUser['nim_nik'] ?? '')
    : (($currentUser['role'] ?? '') === 'Admin'
        ? '../admin/change-password.php?data=' . ($currentUser['nim_nik'] ?? '')
        : 'change-password.php?data=' . ($currentUser['nim_nik'] ?? '')
    );
?>
<!DOCTYPE html>
<html lang="id">
<head>
<?php include '../partials/page-head.php'; ?>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
<?php
if (($currentUser['role'] ?? '') === 'Dosen') {
    include '../partials/sidebar-dosen.php';
} elseif (($currentUser['role'] ?? '') === 'Admin') {
    include '../partials/sidebar-admin.php';
} else {
    include '../partials/sidebar-mhs.php';
}
?>
<div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
<?php include '../partials/header.php'; ?>
<main class="flex-1 p-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <?php if (($currentUser['role'] ?? '') === 'Mahasiswa'): ?>
            <a href="rekap-pengajuan.php?nim_nik=<?= htmlspecialchars($data['nim_nik'] ?? '') ?>" class="hover:text-blue-600 transition">Rekap Pengajuan</a>
        <?php else: ?>
            <a href="../dosen/persetujuan-pengajuan.php" class="hover:text-blue-600 transition">Persetujuan Pengajuan</a>
        <?php endif; ?>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Detail Pengajuan</span>
    </div>

    <!-- Status -->
    <?php
    $sc = match($rowDetail['status_pengajuan'] ?? '') {
        'Diterima' => 'bg-green-100 text-green-800',
        'Ditolak'  => 'bg-red-100 text-red-800',
        default    => 'bg-yellow-100 text-yellow-800',
    };
    ?>
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-gray-800">Detail Formulir Pengajuan MBKM</h2>
        <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full <?= $sc ?>">
            <?= htmlspecialchars($rowDetail['status_pengajuan'] ?? 'Belum ada status') ?>
        </span>
    </div>

    <?php
    function detailCard($letter, $title, $colorClass, $content) {
        echo "<div class='bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4'>";
        echo "<div class='bg-{$colorClass}-50 border-b border-{$colorClass}-100 px-6 py-3 flex items-center gap-2'>";
        echo "<span class='w-6 h-6 rounded-full bg-{$colorClass}-600 text-white text-xs font-bold flex items-center justify-center'>{$letter}</span>";
        echo "<h3 class='text-sm font-bold text-gray-800'>{$title}</h3>";
        echo "</div><div class='p-6'>{$content}</div></div>";
    }

    function detailRow($label, $value) {
        return "<div class='flex flex-col sm:flex-row sm:items-start gap-1 py-2 border-b border-gray-50 last:border-0'>
            <span class='text-xs font-semibold text-gray-500 sm:w-48 flex-shrink-0'>{$label}</span>
            <span class='text-sm text-gray-800'>" . nl2br(htmlspecialchars($value ?? '—')) . "</span>
        </div>";
    }
    ?>

    <!-- A. Data Pribadi -->
    <?php
    ob_start();
    echo detailRow('Nama', $data['nama_lengkap']);
    echo detailRow('NIM / NIK', $data['nim_nik']);
    echo detailRow('Program Studi Asal', $rowDetail['nama_prodi'] ?? $data['id_prodi']);
    echo detailRow('Dosen Pembimbing / Wali', $rowDetail['nama_dosen'] ?? '—');
    $c = ob_get_clean();
    detailCard('A','Data Pribadi','blue',$c);
    ?>

    <!-- B. Detail Program -->
    <?php
    ob_start();
    echo detailRow('Jenis Program', $rowDetail['jenis_program']);
    echo detailRow('Alasan Memilih Program', $rowDetail['alasan_memilih_program']);
    echo detailRow('Judul Program / Kegiatan', $rowDetail['judul_program']);
    echo detailRow('Nama Lembaga Mitra', $rowDetail['nama_mitra']);
    echo detailRow('Durasi Kegiatan', $rowDetail['durasi_kegiatan']);
    if (!empty($rowDetail['posisi_di_perusahaan'])) echo detailRow('Posisi di Perusahaan', $rowDetail['posisi_di_perusahaan']);
    echo detailRow('Rincian Kegiatan', $rowDetail['rincian_kegiatan']);
    echo detailRow('Tanggal Pengajuan', $rowDetail['created_at'] ? date('d/m/Y H:i', strtotime($rowDetail['created_at'])) : '—');
    $c = ob_get_clean();
    detailCard('B','Detail Program','blue',$c);
    ?>

    <!-- C. Membangun Desa (conditional) -->
    <?php if ($rowDetail['jenis_program'] === 'Membangun Desa / Kuliah Kerja Nyata Tematik'): ?>
    <?php
    ob_start();
    echo detailRow('Sumber Pendanaan', $rowDetail['sumber_pendanaan']);
    echo detailRow('Jumlah Anggota', $rowDetail['jumlah_anggota']);
    echo detailRow('Nama Anggota', $rowDetail['nama_anggota']);
    $c = ob_get_clean();
    detailCard('C','Khusus: Membangun Desa / KKN Tematik','orange',$c);
    ?>
    <?php endif; ?>

    <!-- D. Pertukaran Pelajar (conditional) -->
    <?php if ($rowDetail['jenis_program'] === 'Pertukaran Pelajar'): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
        <div class="bg-purple-50 border-b border-purple-100 px-6 py-3 flex items-center gap-2">
            <span class="w-6 h-6 rounded-full bg-purple-600 text-white text-xs font-bold flex items-center justify-center">D</span>
            <h3 class="text-sm font-bold text-gray-800">Khusus: Pertukaran Pelajar</h3>
        </div>
        <div class="p-6 space-y-3">
            <?= detailRow('Jenis Pertukaran', $rowDetail['jenis_pertukaran_pelajar']) ?>
            <?= detailRow('Program Studi Tujuan', $rowDetail['nama_program_studi']) ?>
            <?php if (!empty($pertukaranMKRows)): ?>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-2">Daftar Mata Kuliah yang Diambil</p>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50"><tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 w-28">Kode MK</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500">Nama Mata Kuliah</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-500 w-16">SKS</th>
                        </tr></thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($pertukaranMKRows as $mk): ?>
                            <tr>
                                <td class="px-3 py-2 font-mono text-xs text-gray-600"><?= htmlspecialchars($mk['kode']) ?></td>
                                <td class="px-3 py-2 text-sm text-gray-800"><?= htmlspecialchars($mk['nama']) ?></td>
                                <td class="px-3 py-2 text-center text-sm font-semibold text-gray-700"><?= htmlspecialchars($mk['sks']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- E. Klaim Mata Kuliah -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
        <div class="bg-teal-50 border-b border-teal-100 px-6 py-3 flex items-center gap-2">
            <span class="w-6 h-6 rounded-full bg-teal-600 text-white text-xs font-bold flex items-center justify-center">E</span>
            <h3 class="text-sm font-bold text-gray-800">Klaim / Konversi Mata Kuliah</h3>
        </div>
        <div class="p-6">
            <?php if (!empty($klaimMKRows)): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50"><tr>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 w-28">Kode MK</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500">Nama Mata Kuliah</th>
                        <th class="px-3 py-2 text-center text-xs font-semibold text-gray-500 w-16">SKS</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($klaimMKRows as $mk): ?>
                        <tr>
                            <td class="px-3 py-2 font-mono text-xs text-gray-600"><?= htmlspecialchars($mk['kode']) ?></td>
                            <td class="px-3 py-2 text-sm text-gray-800"><?= htmlspecialchars($mk['nama']) ?></td>
                            <td class="px-3 py-2 text-center text-sm font-semibold text-gray-700"><?= htmlspecialchars($mk['sks']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="text-sm text-gray-400 italic">Belum ada klaim mata kuliah.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Back -->
    <?php
    $backUrl = (($currentUser['role'] ?? '') === 'Mahasiswa')
        ? "rekap-pengajuan.php?nim_nik=" . htmlspecialchars($data['nim_nik'] ?? '')
        : "../dosen/persetujuan-pengajuan.php";
    $backText = (($currentUser['role'] ?? '') === 'Mahasiswa')
        ? "Kembali ke Rekap"
        : "Kembali ke Persetujuan";
    ?>
    <a href="<?= $backUrl ?>"
        class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-xl text-sm transition">
        <i class="fas fa-arrow-left"></i> <?= $backText ?>
    </a>
</main>
</div>
</div>
</body>
</html>
