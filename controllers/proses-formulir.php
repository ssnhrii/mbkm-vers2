<?php
include 'koneksi.php'; // Pastikan Anda menyertakan file koneksi database

// Memastikan nim_nik ada dalam URL dan merupakan angka valid
if (isset($_GET['nim_nik'])) {
    // Mengambil nilai nim_nik dari parameter URL
    $nim_nik = $_GET['nim_nik'];

    // Query untuk mengambil data mahasiswa
    $query = "SELECT nama_lengkap, nim_nik, id_prodi FROM users WHERE nim_nik = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nim_nik); // Gunakan "s" karena nim_nik mungkin berupa string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        // Data mahasiswa ditemukan
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
    // Validasi data dari formulir
    $dosenPembimbing = $_POST['dosenPembimbing'] ?? '';
    $program = $_POST['program'] ?? '';
    $alasan = $_POST['alasan'] ?? '';
    $judulProgram = $_POST['judulProgram'] ?? '';
    $namaLembaga = $_POST['namaLembaga'] ?? '';
    $durasi = $_POST['durasi'] ?? '';
    $posisi = $_POST['posisi'] ?? '';
    $rincian = $_POST['rincian'] ?? '';

    // Data tambahan untuk program tertentu
    $sumberPendanaan = $_POST['sumberPendanaan'] ?? null;
    $jumlahAnggota = $_POST['jumlahAnggota'] ?? null;
    $namaAnggota = $_POST['namaAnggota'] ?? null;

    $jenisPertukaran = $_POST['jenisPertukaran'] ?? null;
    $prodiTujuan = $_POST['prodiTujuan'] ?? null;
    $mataKuliah = $_POST['mataKuliah'] ?? [];

    // Validasi data wajib
    if (empty($dosenPembimbing) || empty($program) || empty($alasan) || empty($judulProgram) || empty($namaLembaga) || empty($durasi) || empty($posisi) || empty($rincian)) {
        echo "Semua bidang wajib harus diisi.";
        exit();
    }

    // SQL untuk menyimpan data
    $query = "INSERT INTO pengajuan_usulan (nim_nik, dosen_pembimbing, jenis_program, alasan_memilih_program, judul_program, nama_mitra, durasi_kegiatan, posisi_di_perusahaan, rincian_kegiatan, sumber_pendanaan, jumlah_anggota, nama_anggota, jenis_pertukaran_pelajar, nama_program_studi, status_pengajuan, created_at, nama_mata_kuliah_jumlah_sks) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

    // Nilai status pengajuan default adalah "Menunggu Persetujuan"
    $statusPengajuan = "Menunggu Persetujuan";
    $mataKuliahString = implode(",", $mataKuliah);

    // Eksekusi query
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "ssssssssssssssss",
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
        $statusPengajuan,
        $mataKuliahString
    );

    if ($stmt->execute()) {
        // Berhasil disimpan, arahkan ke halaman menunggu persetujuan
        header("Location: ../view/menunggu-persetujuan.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }
}
?>
