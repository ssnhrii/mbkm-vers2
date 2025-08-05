<?php
include 'koneksi.php';

$id_pengajuan = $_GET['data'];
$nim_nik = $_GET['nim_nik'];
$statusPengajuan = "Ditolak";

$sql = "UPDATE upload_berkas 
SET status_berkas = 'Diterima' 
WHERE id_pengajuan = ? LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_pengajuan);

if ($stmt->execute()) {
    header("Location: ../view/persetujuan-pengajuan.php");
    exit();
} else {
    echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
}

$stmt->close();