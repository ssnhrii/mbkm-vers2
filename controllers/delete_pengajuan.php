<?php
session_start();
include 'koneksi.php';

if (isset($_GET['data']) && isset($_GET['nim_nik'])) {
    $id_pengajuan = (int)$_GET['data'];
    $nim_nik      = $_GET['nim_nik'];

    $stmt = $conn->prepare("DELETE FROM pengajuan_usulan WHERE id_pengajuan = ? AND nim_nik = ?");
    $stmt->bind_param('is', $id_pengajuan, $nim_nik);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        header("Location: ../views/mhs/rekap-pengajuan.php?nim_nik=" . urlencode($nim_nik) . "&msg=deleted");
    } else {
        header("Location: ../views/mhs/rekap-pengajuan.php?nim_nik=" . urlencode($nim_nik) . "&msg=error");
    }
} else {
    header("Location: ../views/mhs/rekap-pengajuan.php");
}
exit;
?>