<?php
session_start();
include '../../controllers/koneksi.php';
if (!isset($_SESSION['username'])) { header('Location: ../auth/login.php'); exit(); }

$username = $_SESSION['username'];
$sql = "SELECT nim_nik, nama_lengkap, phone, email, alamat, id_prodi, role FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) { header('Location: ../auth/login.php'); exit(); }

$formSuccess = '';
$formError   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $alamat       = trim($_POST['alamat'] ?? '');
    $id_prodi     = trim($_POST['id_prodi'] ?? '');

    $upd = $conn->prepare("UPDATE users SET nama_lengkap=?, phone=?, email=?, alamat=?, id_prodi=? WHERE username=?");
    $upd->bind_param('ssssss', $nama_lengkap, $phone, $email, $alamat, $id_prodi, $username);
    if ($upd->execute()) {
        $formSuccess = 'Profil berhasil diperbarui.';
        // Refresh user data
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    } else {
        $formError = 'Gagal memperbarui profil.';
    }
}

$backUrl = match($user['role']) {
    'Admin' => '../admin/dashboard-admin.php',
    'Dosen' => '../dosen/dashboard-dosen.php',
    default => '../mhs/dashboard-mahasiswa.php',
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profil — MBKM Polibatam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4 py-10">
    <div class="w-full max-w-lg">
        <a href="profile.php" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Profil
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Edit Profil</h2>
                <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi akun Anda</p>
            </div>

            <form method="POST" action="" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NIM / NIK</label>
                    <input type="text" value="<?= htmlspecialchars($user['nim_nik']) ?>" readonly
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Handphone</label>
                        <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                    <textarea name="alamat" rows="2"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"><?= htmlspecialchars($user['alamat']) ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Program Studi</label>
                    <select name="id_prodi"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                        <?php
                        $rp = $conn->query("SELECT id_prodi, nama_prodi FROM prodi");
                        while ($p = $rp->fetch_assoc()):
                        ?>
                        <option value="<?= $p['id_prodi'] ?>" <?= $user['id_prodi'] == $p['id_prodi'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['nama_prodi']) ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" name="update"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="profile.php"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

<script>
<?php if ($formSuccess): ?>
Swal.fire({ title:'Berhasil!', text:'<?= addslashes(htmlspecialchars($formSuccess)) ?>', icon:'success', confirmButtonColor:'#3b82f6', timer:2000, showConfirmButton:false })
    .then(() => { window.location.href = 'profile.php'; });
<?php endif; ?>
<?php if ($formError): ?>
Swal.fire({ title:'Gagal!', text:'<?= addslashes(htmlspecialchars($formError)) ?>', icon:'error', confirmButtonColor:'#3b82f6' });
<?php endif; ?>
</script>
</body>
</html>


