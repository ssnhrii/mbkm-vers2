<?php
// Redirect ke rekap-pengajuan.php (halaman ini sudah digabung)
session_start();
if (!isset($_SESSION['username'])) { header('Location: ../auth/login.php'); exit(); }
include '../../controllers/proses-berkas.php';
header('Location: rekap-pengajuan.php?nim_nik=' . urlencode($data['nim_nik']));
exit;
?>
