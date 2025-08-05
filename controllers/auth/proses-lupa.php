<?php
session_start();
require __DIR__ . '/../koneksi.php';// Koneksi database

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php'; // Autoload PHPMailer

// Fungsi Kirim Email
function kirimEmail($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mbkmpolibatam24@gmail.com'; // Email Anda
        $mail->Password = 'iwkn ziet umem eemd'; // Password Email App Password Anda
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('mbkmpolibatam24@gmail.com', 'Kampus Merdeka');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Kode OTP Anda';
        $mail->Body = "Kode OTP Anda adalah: <b>$otp</b>. Kode ini berlaku selama 5 menit.";
        $mail->send();
    } catch (Exception $e) {
        echo "Gagal mengirim email: {$mail->ErrorInfo}";
    }
}

// Proses Kirim OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Verifikasi Email
    if (isset($_POST['email']) && (!isset($_SESSION['step']) || $_SESSION['step'] === 'email')) {
        $email = $_POST['email'];

        // Cek apakah email ada di database
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $otp = rand(1000, 9999); // Generate OTP
            $timecreate = date('Y-m-d H:i:s');

            // Simpan OTP ke database
            $insertOtp = $conn->prepare("INSERT INTO kode_otp (email, kode_otp, timecreate) VALUES (?, ?, ?)");
            $insertOtp->bind_param("sis", $email, $otp, $timecreate);
            $insertOtp->execute();

            // Kirim OTP ke email
            kirimEmail($email, $otp);

            // Update sesi ke langkah OTP
            $_SESSION['step'] = 'otp';
            $_SESSION['reset_email'] = $email;
            $_SESSION['message'] = "Kode OTP berhasil dikirim ke email Anda.";
        } else {
            $_SESSION['message'] = "Email tidak terdaftar.";
        }
    }
    // Step 2: Validasi OTP
    elseif (isset($_POST['otp']) && $_SESSION['step'] === 'otp') {
        $otp = $_POST['otp'];

        $stmt = $conn->prepare("SELECT timecreate FROM kode_otp WHERE email = ? AND kode_otp = ?");
        $stmt->bind_param("si", $_SESSION['reset_email'], $otp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $timecreate = strtotime($row['timecreate']);
            $now = time();

            if (($now - $timecreate) <= 300) { // Validasi 5 menit
                $_SESSION['step'] = 'password'; // Pindah ke langkah reset password
                $_SESSION['message'] = "OTP valid. Silakan masukkan password baru.";
            } else {
                $_SESSION['message'] = "Kode OTP sudah kedaluwarsa.";
            }

            // Hapus OTP setelah validasi
            $deleteOtp = $conn->prepare("DELETE FROM kode_otp WHERE email = ?");
            $deleteOtp->bind_param("s", $_SESSION['reset_email']);
            $deleteOtp->execute();
        } else {
            $_SESSION['message'] = "Kode OTP tidak valid.";
        }
    }
    // Step 3: Reset Password
    elseif (isset($_POST['password'], $_POST['confirm-password']) && $_SESSION['step'] === 'password') {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];

        if ($password === $confirmPassword) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Update password di database
            $updatePassword = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $updatePassword->bind_param("ss", $hashedPassword, $_SESSION['reset_email']);
            if ($updatePassword->execute()) {
                unset($_SESSION['reset_email']);
                unset($_SESSION['step']);
                $_SESSION['message'] = "Password berhasil diubah. Silakan login kembali.";
                header("Location: login.php");
                exit;
            } else {
                $_SESSION['message'] = "Gagal mengubah password.";
            }
        } else {
            $_SESSION['message'] = "Password tidak sesuai.";
        }
    }
}
?>