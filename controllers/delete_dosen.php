<?php
session_start();
include 'koneksi.php';

if (isset($_GET['nim_nik'])) {
    $nim_nik = $_GET['nim_nik'];

    if (!empty($nim_nik) && preg_match('/^[0-9]+$/', $nim_nik)) {
        $stmt = $conn->prepare("DELETE FROM users WHERE nim_nik = ? AND role = 'dosen'");
        $stmt->bind_param('s', $nim_nik);
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../views/admin/data-dosen.php?message=success");
        } else {
            header("Location: ../views/admin/data-dosen.php?message=error");
        }
        $stmt->close();
    } else {
        header("Location: ../views/admin/data-dosen.php?message=invalid");
    }
} else {
    header("Location: ../views/admin/data-dosen.php?message=missing");
}
$conn->close();
exit;
?>
