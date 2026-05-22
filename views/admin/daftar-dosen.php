<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../auth/login.php'); exit();
}
include '../../controllers/koneksi.php';
include '../../controllers/proses-dashboard.php';

$formError = '';
$formSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = trim($_POST['namaLengkap'] ?? '');
    $nim_nik      = trim($_POST['nim_nik'] ?? '');
    $id_prodi     = trim($_POST['id_prodi'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $alamat       = trim($_POST['alamat'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $username     = trim($_POST['username'] ?? $nim_nik);

    if (empty($id_prodi) || empty($username) || empty($nama_lengkap) || empty($nim_nik)) {
        $formError = 'Semua field wajib harus diisi.';
    } else {
        $stmt = $conn->prepare("INSERT INTO users (nama_lengkap, nim_nik, id_prodi, email, alamat, phone, `wali-dosen`, kelas, role, username, password) VALUES (?,?,?,?,?,?,'','0','dosen',?,?)");
        $defaultPwd = password_hash('dosen123', PASSWORD_BCRYPT);
        $stmt->bind_param('ssssssss', $nama_lengkap, $nim_nik, $id_prodi, $email, $alamat, $phone, $username, $defaultPwd);
        if ($stmt->execute()) {
            $formSuccess = 'Data dosen berhasil ditambahkan.';
        } else {
            $formError = 'Gagal menyimpan data: ' . $conn->error;
        }
    }
}

$pageTitle = 'Tambah Dosen';
$activePage = 'manajemen';
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

    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
        <?php include '../partials/header.php'; ?>

        <main class="flex-1 p-6">
            <div class="max-w-2xl mx-auto">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <a href="data-dosen.php" class="hover:text-emerald-600 transition">Manajemen User</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-800 font-medium">Tambah Dosen</span>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-emerald-50 border-b border-emerald-100 px-6 py-4">
                        <h2 class="text-lg font-bold text-gray-800">Tambah Data Dosen</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Password default: <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs">dosenpolitekniknegeribatam</code></p>
                    </div>

                    <form method="POST" action="" class="p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="namaLengkap" placeholder="Nama lengkap dosen" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">NIM / NIK <span class="text-red-500">*</span></label>
                                <input type="text" name="nim_nik" placeholder="NIM atau NIK" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                                <input type="text" name="username" placeholder="Username login" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Program Studi <span class="text-red-500">*</span></label>
                                <select name="id_prodi" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition bg-white">
                                    <option value="">Pilih Prodi</option>
                                    <?php
                                    $rp = $conn->query("SELECT id_prodi, nama_prodi FROM prodi");
                                    while ($p = $rp->fetch_assoc()):
                                    ?>
                                    <option value="<?= $p['id_prodi'] ?>"><?= htmlspecialchars($p['nama_prodi']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" placeholder="email@polibatam.ac.id" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Handphone <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" placeholder="08xxxxxxxxxx" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="2" placeholder="Alamat lengkap" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition resize-none"></textarea>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="submit"
                                class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-lg text-sm transition flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Simpan Data
                            </button>
                            <a href="data-dosen.php"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-lg text-sm transition flex items-center justify-center gap-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
<?php if ($formError): ?>
Swal.fire({ title: 'Gagal!', text: '<?= addslashes(htmlspecialchars($formError)) ?>', icon: 'error', confirmButtonColor: '#10b981' });
<?php endif; ?>
<?php if ($formSuccess): ?>
Swal.fire({ title: 'Berhasil!', text: '<?= addslashes(htmlspecialchars($formSuccess)) ?>', icon: 'success', confirmButtonColor: '#10b981' })
    .then(() => { window.location.href = 'data-dosen.php'; });
<?php endif; ?>
</script>
</body>
</html>

