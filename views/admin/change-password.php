<?php
session_start();
include '../../controllers/koneksi.php';
if (!isset($_SESSION['username'])) { header('Location: ../auth/login.php'); exit(); }

$nim_nik = $_GET['data'] ?? '';
$formError = '';
$formSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPwd  = $_POST['oldpassword'] ?? '';
    $newPwd  = $_POST['newpassword'] ?? '';
    $confPwd = $_POST['confirmnewpassword'] ?? '';

    if ($newPwd !== $confPwd) {
        $formError = 'Konfirmasi password baru tidak cocok.';
    } elseif (strlen($newPwd) < 8) {
        $formError = 'Password baru minimal 8 karakter.';
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE nim_nik = ?");
        $stmt->bind_param('s', $nim_nik);
        $stmt->execute();
        $stmt->bind_result($hashedPwd);
        $stmt->fetch();
        $stmt->close();

        if ($hashedPwd && password_verify($oldPwd, $hashedPwd)) {
            $newHash = password_hash($newPwd, PASSWORD_BCRYPT);
            $upd = $conn->prepare("UPDATE users SET password = ? WHERE nim_nik = ?");
            $upd->bind_param('ss', $newHash, $nim_nik);
            $formSuccess = $upd->execute() ? 'Password berhasil diubah.' : 'Gagal mengubah password.';
            if (!$upd->execute()) $formError = 'Gagal mengubah password.';
        } else {
            $formError = 'Password lama salah.';
        }
    }
}

// Determine back URL
$role = $_SESSION['role'] ?? '';
$backUrl = match($role) {
    'Admin' => 'dashboard-admin.php',
    'Dosen' => '../dosen/dashboard-dosen.php',
    default => '../mhs/dashboard-mahasiswa.php',
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ganti Password — MBKM Polibatam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <a href="<?= htmlspecialchars($backUrl) ?>" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4 transition">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Ganti Password</h2>
                <p class="text-sm text-gray-500 mt-0.5">Perbarui password akun Anda</p>
            </div>

            <form method="POST" action="" class="p-6 space-y-4">
                <?php
                function pwdField($id, $name, $placeholder) {
                    echo "<div>
                        <label class='block text-sm font-medium text-gray-700 mb-1.5'>{$placeholder}</label>
                        <div class='relative'>
                            <input type='password' id='{$id}' name='{$name}' required placeholder='{$placeholder}'
                                class='w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition'>
                            <button type='button' onclick=\"togglePwd('{$id}','icon_{$id}')\" tabindex='-1'
                                class='absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600'>
                                <i class='fas fa-eye text-sm' id='icon_{$id}'></i>
                            </button>
                        </div>
                    </div>";
                }
                pwdField('oldpassword','oldpassword','Password Lama');
                pwdField('newpassword','newpassword','Password Baru');
                pwdField('confirmnewpassword','confirmnewpassword','Konfirmasi Password Baru');
                ?>
                <p class="text-xs text-gray-400">Password minimal 8 karakter.</p>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                        <i class="fas fa-key"></i> Ganti Password
                    </button>
                    <a href="<?= htmlspecialchars($backUrl) ?>"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

<script>
function togglePwd(fieldId, iconId) {
    const f = document.getElementById(fieldId), i = document.getElementById(iconId);
    if (f.type === 'password') { f.type = 'text'; i.classList.replace('fa-eye','fa-eye-slash'); }
    else { f.type = 'password'; i.classList.replace('fa-eye-slash','fa-eye'); }
}
<?php if ($formError): ?>
Swal.fire({ title:'Gagal!', text:'<?= addslashes(htmlspecialchars($formError)) ?>', icon:'error', confirmButtonColor:'#3b82f6' });
<?php endif; ?>
<?php if ($formSuccess): ?>
Swal.fire({ title:'Berhasil!', text:'<?= addslashes(htmlspecialchars($formSuccess)) ?>', icon:'success', confirmButtonColor:'#3b82f6', timer:2000, showConfirmButton:false })
    .then(() => { window.location.href = '<?= htmlspecialchars($backUrl) ?>'; });
<?php endif; ?>
</script>
</body>
</html>
