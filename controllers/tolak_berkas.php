<?php
include 'koneksi.php'; // Pastikan koneksi database sudah ada

function tolakPengajuan($id_pengajuan, $nim_nik, $comment)
{
    global $conn;

    // 1. Menambahkan komentar ke tabel 'komentar'
    $stmt = $conn->prepare("INSERT INTO komentar (komentar) VALUES (?)");
    $stmt->bind_param("s", $comment);

    if ($stmt->execute()) {
        // Ambil id_komentar yang baru saja ditambahkan
        $id_komentar = $conn->insert_id; // Menyimpan ID komentar terakhir yang dimasukkan

        // 2. Mengupdate kolom 'komentar' di tabel 'pengajuan_usulan' dengan id_komentar
        $update_stmt = $conn->prepare("UPDATE upload_berkas SET komentar = ?, status_berkas = 'Ditolak' WHERE id_pengajuan = ?");
        $update_stmt->bind_param("ss", $id_komentar, $id_pengajuan);

        if ($update_stmt->execute()) {
            echo "Location: ../view/persetujuan-pengajuan.php";
        } else {
            echo "Error mengupdate pengajuan: " . $update_stmt->error;
        }
    } else {
        echo "Error menambahkan komentar: " . $stmt->error;
    }
}

// Mengambil data dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengajuan = $_POST['id_pengajuan'];
    $nim_nik = $_POST['nim_nik'];
    $comment = $_POST['comment'];

    // Panggil fungsi untuk menolak pengajuan dan menambahkan komentar
    tolakPengajuan($id_pengajuan, $nim_nik, $comment);
}
?>
