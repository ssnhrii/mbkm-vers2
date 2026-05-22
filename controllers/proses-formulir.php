<?php
include 'koneksi.php';

// Pastikan nim_nik ada dalam URL
if (isset($_GET['nim_nik'])) {
    $nim_nik = $_GET['nim_nik'];

    $query = "SELECT u.nama_lengkap, u.nim_nik, u.id_prodi, p.nama_prodi
              FROM users u
              LEFT JOIN prodi p ON u.id_prodi = p.id_prodi
              WHERE u.nim_nik = ?";
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

// Simpan data formulir ke database jika metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $dosenPembimbing     = $_POST['dosenPembimbing']            ?? '';
    $program             = $_POST['program']                     ?? '';
    $alasan              = $_POST['alasan']                      ?? '';
    $judulProgram        = $_POST['judulProgram']                ?? '';
    $namaLembaga         = $_POST['namaLembaga']                 ?? '';
    $durasi              = $_POST['durasi']                      ?? '';  // sudah digabung di JS
    $posisi              = $_POST['posisi']                      ?? null; // opsional (hanya MSIB)
    $rincian             = $_POST['rincian']                     ?? '';

    // Data tambahan Membangun Desa / KKN
    $sumberPendanaan     = $_POST['sumberPendanaan']             ?? null;
    $jumlahAnggota       = $_POST['jumlahAnggota']               ?? null;
    $namaAnggota         = $_POST['namaAnggota']                 ?? null;

    // Data tambahan Pertukaran Pelajar
    $jenisPertukaran     = $_POST['jenisPertukaran']             ?? null;
    $prodiTujuan         = $_POST['prodiTujuan']                 ?? null;
    // Mata kuliah pertukaran: format "KODE|Nama|SKS,KODE2|Nama2|SKS2" (sudah digabung di JS)
    $mataKuliahString    = $_POST['mataKuliahPertukaranString']  ?? '';

    // Klaim mata kuliah (semua jenis program): format sama
    $klaimMataKuliah     = $_POST['klaimMataKuliahString']       ?? null;

    // Validasi data wajib
    if (
        empty($dosenPembimbing) || empty($program) || empty($alasan) ||
        empty($judulProgram)    || empty($namaLembaga) ||
        empty($durasi)          || empty($rincian)
    ) {
        echo "<script>Swal.fire({title:'Validasi Gagal',text:'Semua bidang wajib harus diisi.',icon:'warning',confirmButtonColor:'#3b82f6'}).then(()=>history.back());</script>";
        exit();
    }

    // Posisi wajib untuk Magang Praktik Kerja (MSIB)
    if ($program === 'Magang Praktik Kerja' && empty($posisi)) {
        echo "<script>Swal.fire({title:'Validasi Gagal',text:'Posisi di perusahaan wajib diisi untuk Magang Praktik Kerja (MSIB).',icon:'warning',confirmButtonColor:'#3b82f6'}).then(()=>history.back());</script>";
        exit();
    }

    // Nilai status default
    $statusPengajuan = "Menunggu Persetujuan";

    $query = "INSERT INTO pengajuan_usulan (
                nim_nik, dosen_pembimbing, jenis_program,
                alasan_memilih_program, judul_program, nama_mitra,
                durasi_kegiatan, posisi_di_perusahaan, rincian_kegiatan,
                sumber_pendanaan, jumlah_anggota, nama_anggota,
                jenis_pertukaran_pelajar, nama_program_studi,
                nama_mata_kuliah_jumlah_sks, klaim_mata_kuliah,
                status_pengajuan, created_at
              ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sssssssssssssssss",
        $nim_nik,
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
        $statusPengajuan
    );

    if ($stmt->execute()) {
        header("Location: ../views/mhs/menunggu-persetujuan.php");
        exit();
    } else {
        echo "<script>Swal.fire({title:'Gagal',text:'Terjadi kesalahan: " . addslashes($stmt->error) . "',icon:'error',confirmButtonColor:'#3b82f6'});</script>";
    }
}
?>
