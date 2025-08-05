<?php
// Pastikan sesi dimulai hanya jika belum aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Koneksi ke database
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

// Ambil data mahasiswa dari database
$username = $_SESSION['username'];
$query = "SELECT nim_nik, username, nama_lengkap, email, no_handphone, alamat, id_prodi, role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Periksa apakah data ditemukan
if ($data) {
    // Ambil nama prodi jika ada relasi dengan tabel prodi
    $prodi = "";
    if ($data['id_prodi']) {
        $queryProdi = "SELECT nama_prodi FROM prodi WHERE id_prodi = ?";
        $stmtProdi = $conn->prepare($queryProdi);
        $stmtProdi->bind_param("i", $data['id_prodi']);
        $stmtProdi->execute();
        $resultProdi = $stmtProdi->get_result();
        $prodiData = $resultProdi->fetch_assoc();
        $prodi = $prodiData['nama_prodi'] ?? "";
    }
} else {
    // Jika data tidak ditemukan, arahkan ke halaman error
    header("Location: error.php");
    exit;
}
?>
