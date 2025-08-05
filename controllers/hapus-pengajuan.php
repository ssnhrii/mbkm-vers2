<?php
// hapus_pengajuan.php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['nim_nik'])) {
    header("Location: login.php"); // Ganti dengan halaman login Anda
    exit();
}

$nim_nik = $_SESSION['nim_nik'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nim'])) {
        $nim_to_delete = $_POST['nim'];

        include 'config.php';

        // Pastikan hanya pengguna yang berhak yang bisa menghapus
        // Misalnya, hanya menghapus pengajuan milik mereka
        $sql = "DELETE FROM tabel_pengajuan WHERE nim = ? AND nim = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nim_to_delete, $nim_nik);
        if ($stmt->execute()) {
            // Redirect kembali ke halaman pengajuan dengan pesan sukses
            header("Location: pengajuan.php?message=Pengajuan berhasil dihapus");
            exit();
        } else {
            // Redirect kembali dengan pesan error
            header("Location: pengajuan.php?error=Gagal menghapus pengajuan");
            exit();
        }
    }
}

// Jika tidak melalui POST, redirect ke halaman pengajuan
header("Location: pengajuan.php");
exit();
?>
