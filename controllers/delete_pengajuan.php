<?php
include 'koneksi.php';

if (isset($_GET['data']) && isset($_GET['nim_nik'])) {
    $id_pengajuan = htmlspecialchars($_GET['data']);
    $nim_nik = htmlspecialchars($_GET['nim_nik']);

    try {
        $sql = "DELETE FROM pengajuan_usulan WHERE id_pengajuan = ? AND nim_nik = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([$id_pengajuan, $nim_nik])) {
            $_SESSION['success'] = "Pengajuan berhasil dihapus.";
            header("Location: ../view/rekap-pengajuan.php");
            exit;
        } else {
            $_SESSION['error'] = "Gagal menghapus pengajuan.";
            header("Location: ../view/rekap-pengajuan.php");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Error deleting pengajuan: " . $e->getMessage());
        $_SESSION['error'] = "Terjadi kesalahan saat menghapus pengajuan.";
        header("Location: ../view/rekap-pengajuan.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Parameter tidak lengkap.";
    header("Location: ../view/rekap-pengajuan.php");
    exit;
}

?>