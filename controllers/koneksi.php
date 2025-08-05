<?php
$host = "localhost"; // Server database
$user = "root"; // Username database
$password = ""; // Password database (kosong jika default XAMPP/LAMP/MAMP)
$db = "sis_polibatam"; // Nama database

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $password, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
