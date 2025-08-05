<?php
include 'koneksi.php';

$id_pengajuan = $_GET['data'];
$nim_nik = $_GET['nim_nik'];
$statusPengajuan = "Menunggu Persetujuan";

if ($_FILES['transkip_nilai']['error'] === UPLOAD_ERR_OK && $_FILES['dokumen_mbkm']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $transkipFile = $_FILES['transkip_nilai'];
    $dokumenFile = $_FILES['dokumen_mbkm'];
    
    $transkipPath = $uploadDir . basename($transkipFile['name']);
    $dokumenPath = $uploadDir . basename($dokumenFile['name']);
    
    if (move_uploaded_file($transkipFile['tmp_name'], $transkipPath) && move_uploaded_file($dokumenFile['tmp_name'], $dokumenPath)) {
        $query = "INSERT INTO upload_berkas (id_pengajuan, file_path, dokumen_mbkm, status_berkas) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $id_pengajuan, $transkipPath, $dokumenPath, $statusPengajuan);
        
        if ($stmt->execute()) {
            header("Location: ../view/rekap-pengajuan.php?nim_nik=$nim_nik");
            exit();
        } else {
            echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
        }
    } else {
        echo "Gagal mengunggah file.";
    }
} else {
    echo "Harap unggah kedua file.";
}
?>
