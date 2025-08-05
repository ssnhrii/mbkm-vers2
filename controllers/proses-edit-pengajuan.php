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

    // Membuat query SQL dengan langsung menyisipkan data variabel
    $mataKuliahString = implode(",", $mataKuliah); // Konversi array mataKuliah menjadi string
    $statusPengajuan = "Menunggu Persetujuan";
    $id_pengajuan = $_GET['data'];

    $sql = "UPDATE pengajuan_usulan 
            SET 
                dosen_pembimbing = '$dosenPembimbing', 
                jenis_program = '$program', 
                alasan_memilih_program = '$alasan', 
                judul_program = '$judulProgram', 
                nama_mitra = '$namaLembaga', 
                durasi_kegiatan = '$durasi', 
                posisi_di_perusahaan = '$posisi', 
                rincian_kegiatan = '$rincian', 
                sumber_pendanaan = '$sumberPendanaan', 
                jumlah_anggota = '$jumlahAnggota', 
                nama_anggota = '$namaAnggota', 
                jenis_pertukaran_pelajar = '$jenisPertukaran', 
                nama_program_studi = '$prodiTujuan', 
                status_pengajuan = '$statusPengajuan', 
                created_at = NOW(), 
                nama_mata_kuliah_jumlah_sks = '$mataKuliahString' 
            WHERE id_pengajuan = '$id_pengajuan'";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        // Berhasil disimpan, arahkan ke halaman menunggu persetujuan
        header("Location: ../view/dashboard-mahasiswa.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}
?>