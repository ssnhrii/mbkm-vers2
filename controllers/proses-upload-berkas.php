<?php
include 'koneksi.php';

$id_pengajuan    = $_GET['data']    ?? '';
$nim_nik         = $_GET['nim_nik'] ?? '';
$statusBerkas    = "Menunggu Persetujuan";
$uploadDir       = '../uploads/';
$maxFileSize     = 5 * 1024 * 1024; // 5 MB per file
$allowedTypes    = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
$allowedExt      = ['pdf', 'jpg', 'jpeg', 'png'];

// Buat folder uploads jika belum ada
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Daftar field berkas sesuai pedoman (name => label)
$berkasFields = [
    'transkip_nilai'        => 'Transkrip Nilai',
    'dokumen_mbkm'          => 'Dokumen / Laporan MBKM',
    'surat_rekomendasi'     => 'Surat Rekomendasi Perguruan Tinggi/Jurusan',
    'surat_keterangan_sehat'=> 'Surat Keterangan Sehat',
    'surat_persetujuan_ortu'=> 'Surat Persetujuan Orang Tua',
    'surat_pakta_integritas'=> 'Surat Pakta Integritas',
    'biodata_cv'            => 'Biodata / Curriculum Vitae',
    'sertifikat_pelatihan'  => 'Sertifikat Pelatihan / Workshop',
    'karya_tulis_produk'    => 'Karya Tulis / Produk',
];

// Kolom DB untuk tiap berkas (map name → kolom di upload_berkas)
$dbColMap = [
    'transkip_nilai'         => 'file_path',          // kolom lama
    'dokumen_mbkm'           => 'dokumen_mbkm',       // kolom lama
    'surat_rekomendasi'      => 'surat_rekomendasi',
    'surat_keterangan_sehat' => 'surat_keterangan_sehat',
    'surat_persetujuan_ortu' => 'surat_persetujuan_ortu',
    'surat_pakta_integritas' => 'surat_pakta_integritas',
    'biodata_cv'             => 'biodata_cv',
    'sertifikat_pelatihan'   => 'sertifikat_pelatihan',
    'karya_tulis_produk'     => 'karya_tulis_produk',
];

// Helper: validasi & upload satu file, return path atau '' jika tidak diupload
function uploadSingleFile($fieldName, $uploadDir, $allowedTypes, $allowedExt, $maxFileSize, &$errors) {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return null; // tidak diupload — bukan error
    }
    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Gagal upload '{$fieldName}' (error code: " . $_FILES[$fieldName]['error'] . ").";
        return false;
    }
    if ($_FILES[$fieldName]['size'] > $maxFileSize) {
        $errors[] = "File '{$fieldName}' melebihi batas 5 MB.";
        return false;
    }
    $ext = strtolower(pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) {
        $errors[] = "Format file '{$fieldName}' tidak diizinkan. Gunakan: " . implode(', ', $allowedExt);
        return false;
    }
    // Nama file unik untuk menghindari tabrakan
    $safeName = time() . '_' . $fieldName . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES[$fieldName]['name']));
    $destPath = $uploadDir . $safeName;
    if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $destPath)) {
        $errors[] = "Gagal menyimpan file '{$fieldName}'.";
        return false;
    }
    return $destPath;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors    = [];
    $filePaths = []; // fieldName => path

    foreach (array_keys($berkasFields) as $field) {
        $path = uploadSingleFile($field, $uploadDir, $allowedTypes, $allowedExt, $maxFileSize, $errors);
        if ($path !== false) {
            $filePaths[$field] = $path; // null jika tidak diupload, string jika berhasil
        }
    }

    if (!empty($errors)) {
        $errMsg = addslashes(implode('\n', $errors));
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script><script>Swal.fire({title:'Upload Gagal',html:'<ul class=\"text-left text-sm\">" . implode('', array_map(fn($e) => '<li>• ' . addslashes(htmlspecialchars($e)) . '</li>', $errors)) . "</ul>',icon:'error',confirmButtonColor:'#3b82f6'}).then(()=>history.back());</script>";
        exit();
    }

    // Cek apakah sudah ada record untuk id_pengajuan ini
    $checkSql  = "SELECT id_berkas FROM upload_berkas WHERE id_pengajuan = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $id_pengajuan);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $existing    = $checkResult->fetch_assoc();

    if ($existing) {
        // UPDATE — hanya update kolom yang baru diupload
        $setParts = ["status_berkas = ?"]; 
        $params   = [$statusBerkas];
        $types    = "s";

        foreach ($filePaths as $field => $path) {
            if ($path !== null) {
                $col        = $dbColMap[$field];
                $setParts[] = "$col = ?";
                $params[]   = $path;
                $types     .= "s";
            }
        }
        $params[] = $id_pengajuan;
        $types   .= "i";

        $sql  = "UPDATE upload_berkas SET " . implode(', ', $setParts) . " WHERE id_pengajuan = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
    } else {
        // INSERT baru
        $cols   = ['id_pengajuan', 'status_berkas'];
        $vals   = ['?', '?'];
        $params = [$id_pengajuan, $statusBerkas];
        $types  = "is";

        foreach ($filePaths as $field => $path) {
            if ($path !== null) {
                $cols[]   = $dbColMap[$field];
                $vals[]   = '?';
                $params[] = $path;
                $types   .= "s";
            }
        }

        $sql  = "INSERT INTO upload_berkas (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ")";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
    }

    if ($stmt->execute()) {
        header("Location: ../views/mhs/rekap-pengajuan.php?nim_nik=" . urlencode($nim_nik));
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
    }
}
?>
