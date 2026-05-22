<?php
// Koneksi ke database
require __DIR__ . '/../koneksi.php';
// Pastikan file koneksi.php ada di direktori yang sesuai';

$login_success = false; // Default status login

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil password dan role dari database
    $query = "SELECT password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $role);
    $stmt->fetch();
    $stmt->close();

    if ($hashed_password) {
        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            // Password cocok
            error_log("Login Berhasil untuk username: $username");
            $login_success = true;

            // Mulai session untuk menyimpan data user
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            echo "<script>console.log('Username Session: " . $_SESSION['username'] . "' );</script>";
            echo "<script>console.log('Role Session: " . $_SESSION['role'] . "' );</script>";

            // Redirect URL berdasarkan role
            switch (strtolower($role)) {
                case 'mahasiswa':
                    $redirect_url = '../../views/mhs/dashboard-mahasiswa.php';
                    break;
                case 'dosen':
                    $redirect_url = '../../views/dosen/dashboard-dosen.php';
                    break;
                case 'admin':
                    $redirect_url = '../../views/admin/dashboard-admin.php';
                    break;
                default:
                    $redirect_url = '../../views/auth/login.php';
            }
        } else {
            // Password salah
            error_log("Password Salah untuk username: $username");
        }
    } else {
        // Username tidak ditemukan
        error_log("Username tidak ditemukan: $username");
    }
}
