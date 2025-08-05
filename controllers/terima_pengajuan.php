<?php
include 'koneksi.php';

$id_pengajuan = $_GET['data'];
$nim_nik = $_GET['nim_nik'];
$statusPengajuan = "Ditolak";

$sql = "UPDATE pengajuan_usulan 
SET status_pengajuan = 'Diterima' 
WHERE id_pengajuan = ? AND nim_nik = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id_pengajuan, $nim_nik);

if ($stmt->execute()) {
    header("Location: ../view/persetujuan-pengajuan.php");
    exit();
} else {
    echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
}

$stmt->close();