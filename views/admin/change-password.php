<?php
// Koneksi ke database
include '../function/koneksi.php'; // Pastikan file koneksi.php ada di direktori yang sesuai';

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$update_success = false;
$update_error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['oldpassword'];
    $new_password = $_POST['newpassword'];
    $confirm_new_password = $_POST['confirmnewpassword'];
    
    if (isset($_GET['data'])) {
        $nim_nik = $_GET['data'];
    } else {
        $update_error = true;
        $error_message = "NIM/NIK tidak ditemukan.";
    }

    if ($new_password !== $confirm_new_password) {
        $update_error = true;
        $error_message = "Konfirmasi password baru tidak cocok.";
    }

    if (!$update_error) {
        $query = "SELECT password FROM users WHERE nim_nik = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nim_nik);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        if ($hashed_password) {
            if (password_verify($old_password, $hashed_password)) {
                $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                $update_query = "UPDATE users SET password = ? WHERE nim_nik = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("ss", $new_hashed_password, $nim_nik);

                if ($update_stmt->execute()) {
                    $update_success = true;
                    $success_message = "Password berhasil diubah.";
                    echo "<script>alert('Password berhasil diubah!');window.location.href='data-dosen.php';</script>";
                } else {
                    $update_error = true;
                    $error_message = "Terjadi kesalahan saat mengubah password.";
                    echo "<script>alert('Terjadi kesalahan saat mengubah password!');window.location.href='data-dosen.php';</script>";
                }

                $update_stmt->close();
            } else {
                $update_error = true;
                echo "<script>alert('Password lama salah!');window.location.href='data-dosen.php';</script>";
                $error_message = "Password lama salah.";
            }
        } else {
            $update_error = true;
            echo "<script>alert('Pengguna tidak ditemukan!');window.location.href='data-dosen.php';</script>";
            $error_message = "Pengguna tidak ditemukan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Login Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../assets/css/style-login.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css?v=<?= time(); ?>">
    <script src="script.js?v=<?= time(); ?>"></script>
</head>

<body>
    <div class="overlay">
        <div class="login-container">
            <img src="../assets/img/Logo MBKM.png" alt="Logo MBKM" class="img-fluid" />
            <h3 class="text-center">Login</h3>

            <!-- Form Login -->
            <form method="POST" action="">

                <div class="mb-3 position-relative d-flex flex-column">
                    <input type="password" id="oldpassword" name="oldpassword" class="form-control" placeholder="Password Lama"
                        required />
                    <i class="fa fa-eye toggle-password" id="toggleOldPassword"></i>
                </div>

                <div class="mb-3 position-relative d-flex flex-column">
                    <input type="password" id="newpassword" name="newpassword" class="form-control" placeholder="Password Baru"
                        required />
                    <i class="fa fa-eye toggle-password" id="toggleNewPassword"></i>
                </div>

                <div class="mb-3 position-relative d-flex flex-column">
                    <input type="password" id="confirmnewpassword" name="confirmnewpassword" class="form-control" placeholder="Konfirmasi Password Baru"
                        required />
                    <i class="fa fa-eye toggle-password" id="togglePasswordConfirmPassword"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="lupa-password.php" class="text-decoration-none text-primary">Lupa Password? </a>
                </div>

                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                <a href="registrasi.php" class="d-block text-center mt-3 text-decoration-none text-primary">Belum
                    Punya Akun? Daftar</a>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleOldPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('oldpassword');
            const toggleIcon = document.getElementById('toggleOldPassword');
            togglePasswordVisibility(passwordField, toggleIcon);
        });

        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('newpassword');
            const toggleIcon = document.getElementById('toggleNewPassword');
            togglePasswordVisibility(passwordField, toggleIcon);
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('confirmnewpassword');
            const toggleIcon = document.getElementById('toggleConfirmPassword');
            togglePasswordVisibility(passwordField, toggleIcon);
        });

        function togglePasswordVisibility(passwordField, toggleIcon) {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>