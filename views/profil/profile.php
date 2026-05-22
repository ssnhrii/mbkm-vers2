<?php
session_start();
include '../../controllers/koneksi.php';
if (!isset($_SESSION['username'])) { header('Location: ../auth/login.php'); exit(); }

$username = $_SESSION['username'];
$sql = "SELECT u.nim_nik, u.nama_lengkap, u.phone, u.email, u.alamat, u.role, p.nama_prodi
        FROM users u LEFT JOIN prodi p ON u.id_prodi = p.id_prodi WHERE u.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    header('Location: ../auth/login.php'); exit();
}

// Determine back URL based on role
$backUrl = match($user['role']) {
    'Admin'    => '../admin/dashboard-admin.php',
    'Dosen'    => '../dosen/dashboard-dosen.php',
    default    => '../mhs/dashboard-mahasiswa.php',
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil — MBKM Polibatam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
        <!-- Back -->
        <a href="<?= htmlspecialchars($backUrl) ?>"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8 text-white text-center">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-3xl font-bold mx-auto mb-3">
                    <?= strtoupper(substr($user['nama_lengkap'], 0, 1)) ?>
                </div>
                <h2 class="text-lg font-bold"><?= htmlspecialchars($user['nama_lengkap']) ?></h2>
                <span class="inline-block mt-1 text-xs bg-white/20 px-3 py-0.5 rounded-full font-medium">
                    <?= htmlspecialchars($user['role']) ?>
                </span>
            </div>

            <!-- Info -->
            <div class="p-6 space-y-3">
                <?php
                $fields = [
                    ['icon'=>'fa-id-card',   'label'=>'NIM / NIK',       'value'=>$user['nim_nik']],
                    ['icon'=>'fa-user',      'label'=>'Nama Lengkap',     'value'=>$user['nama_lengkap']],
                    ['icon'=>'fa-phone',     'label'=>'No. Handphone',    'value'=>$user['phone']],
                    ['icon'=>'fa-envelope',  'label'=>'Email',            'value'=>$user['email']],
                    ['icon'=>'fa-map-marker-alt','label'=>'Alamat',       'value'=>$user['alamat']],
                    ['icon'=>'fa-graduation-cap','label'=>'Program Studi','value'=>$user['nama_prodi'] ?? '—'],
                ];
                foreach ($fields as $f): ?>
                <div class="flex items-start gap-3 py-2 border-b border-gray-50 last:border-0">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0 mt-0.5">
                        <i class="fas <?= $f['icon'] ?> text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium"><?= $f['label'] ?></p>
                        <p class="text-sm text-gray-800 font-medium"><?= htmlspecialchars($f['value'] ?? '—') ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Actions -->
            <div class="px-6 pb-6 flex gap-3">
                <a href="edit-profile.php"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                    <i class="fas fa-user-edit"></i> Edit Profil
                </a>
                <a href="../../controllers/logout.php"
                    onclick="return confirmLogout(event, this.href)"
                    class="flex-1 bg-red-50 hover:bg-red-100 text-red-700 font-semibold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </div>
    </div>

<script>
function confirmLogout(e, href) {
    e.preventDefault();
    Swal.fire({ title:'Keluar?', text:'Anda akan keluar dari sistem.', icon:'question', showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#6b7280', confirmButtonText:'Ya, Keluar', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) window.location.href = href; });
    return false;
}
</script>
</body>
</html>
