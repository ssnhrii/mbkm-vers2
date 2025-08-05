<?php
include 'koneksi.php';

if (isset($_GET['nim_nik'])) {
    $nim_nik = $_GET['nim_nik'];

    if (!empty($nim_nik) && preg_match('/^[0-9]+$/', $nim_nik)) {
        $sql = "DELETE FROM users WHERE nim_nik = ? AND role = 'dosen'";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $nim_nik);
            if ($stmt->execute()) {
                header("Location: ../view/data-dosen.php?message=success");
            } else {
                header("Location: ../view/data-dosen.php?message=error");
            }
            $stmt->close();
        } else {
            header("Location: ../view/data-dosen.php?message=error");
        }
    } else {
        header("Location: ../view/data-dosen.php?message=invalid");
    }
} else {
    header("Location: ../view/data-dosen.php?message=missing");
}

$conn->close();
?>
