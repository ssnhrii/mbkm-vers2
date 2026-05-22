<?php
include 'koneksi.php';

// Memastikan nim_nik ada dalam URL
if (isset($_GET['nim_nik'])) {
    $nim_nik = $_GET['nim_nik'];

    $query = "SELECT nama_lengkap, nim_nik, id_prodi FROM users WHERE nim_nik = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nim_nik);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Data mahasiswa tidak ditemukan.";
        exit();
    }
} else {
    echo "Parameter nim_nik tidak ditemukan atau tidak valid.";
    exit();
}

// Proses update jika POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dosenPembimbing  = $_POST['dosenPembimbing']           ?? '';
    $program          = $_POST['program']                    ?? '';
    $alasan           = $_POST['alasan']                     ?? '';
    $judulProgram     = $_POST['judulProgram']               ?? '';
    $namaLembaga      = $_POST['namaLembaga']                ?? '';
    $durasi           = $_POST['durasi']                     ?? '';  // digabung JS
    $posisi           = $_POST['posisi']                     ?? null;
    $rincian          = $_POST['rincian']                    ?? '';

    $sumberPendanaan  = $_POST['sumberPendanaan']            ?? null;
    $jumlahAnggota    = $_POST['jumlahAnggota']              ?? null;
    $namaAnggota      = $_POST['namaAnggota']                ?? null;

    $jenisPertukaran  = $_POST['jenisPertukaran']            ?? null;
    $prodiTujuan      = $_POST['prodiTujuan']                ?? null;
    $mataKuliahString = $_POST['mataKuliahPertukaranString'] ?? '';
    $klaimMataKuliah  = $_POST['klaimMataKuliahString']      ?? null;

    // Validasi wajib
    if (
        empty($dosenPembimbing) || empty($program) || empty($alasan) ||
        empty($judulProgram)    || empty($namaLembaga) ||
        empty($durasi)          || empty($rincian)
    ) {
        echo "<script>Swal.fire({title:'Validasi Gagal',text:'Semua bidang wajib harus diisi.',icon:'warning',confirmButtonColor:'#3b82f6'}).then(()=>history.back());</script>";
        exit();
    }

    // Posisi wajib untuk Magang
    if ($program === 'Magang Praktik Kerja' && empty($posisi)) {
        echo "<script>Swal.fire({title:'Validasi Gagal',text:'Posisi di perusahaan wajib diisi untuk Magang Praktik Kerja (MSIB).',icon:'warning',confirmButtonColor:'#3b82f6'}).then(()=>history.back());</script>";
        exit();
    }

    $statusPengajuan = "Menunggu Persetujuan";
    $id_pengajuan    = $_GET['data'];

    $sql = "UPDATE pengajuan_usulan SET
                dosen_pembimbing          = ?,
                jenis_program             = ?,
                alasan_memilih_program    = ?,
                judul_program             = ?,
                nama_mitra                = ?,
                durasi_kegiatan           = ?,
                posisi_di_perusahaan      = ?,
                rincian_kegiatan          = ?,
                sumber_pendanaan          = ?,
                jumlah_anggota            = ?,
                nama_anggota              = ?,
                jenis_pertukaran_pelajar  = ?,
                nama_program_studi        = ?,
                nama_mata_kuliah_jumlah_sks = ?,
                klaim_mata_kuliah         = ?,
                status_pengajuan          = ?,
                created_at                = NOW()
            WHERE id_pengajuan = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssssi",
        $dosenPembimbing,
        $program,
        $alasan,
        $judulProgram,
        $namaLembaga,
        $durasi,
        $posisi,
        $rincian,
        $sumberPendanaan,
        $jumlahAnggota,
        $namaAnggota,
        $jenisPertukaran,
        $prodiTujuan,
        $mataKuliahString,
        $klaimMataKuliah,
        $statusPengajuan,
        $id_pengajuan
    );

    if ($stmt->execute()) {
        header("Location: ../views/mhs/rekap-pengajuan.php?nim_nik=" . urlencode($nim_nik));
        exit();
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }
}
?>