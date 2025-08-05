<?php
session_start();

// Periksa apakah pengguna sudah masuk
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$nim_nik = $_GET['nim_nik'];

include '../function/koneksi.php';

// Query untuk mengambil data pengajuan berdasarkan NIM/NIK pengguna
$sql = "SELECT u.nim_nik, u.username AS nama, pr.nama_prodi AS program_studi, 
               p.created_at, p.status_pengajuan, b.status_berkas, p.id_pengajuan
        FROM pengajuan_usulan p
        JOIN users u ON p.nim_nik = u.nim_nik
        JOIN prodi pr ON u.id_prodi = pr.id_prodi
        LEFT JOIN upload_berkas b ON p.id_pengajuan = b.id_pengajuan
        WHERE p.nim_nik = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nim_nik);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Pengajuan</title>
  <link rel="stylesheet" href="../assets/css/style-pengajuan.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="../assets/img/Logo MBKM.png" alt="Logo">
    </div>
    <nav>
      <a href="dashboard-mahasiswa.php" class="dashboard">
        <span class="icon"><i class="fas fa-home-alt"></i></span>
        <span class="text">DASHBOARD</span>
      </a>
      <a href="pengajuan.php" class="pengajuan active">
        <span class="icon"><i class="fas fa-file-alt"></i></span>
        <span class="text">PENGAJUAN</span>
      </a>
    </nav>
  </div>
  <div class="content">
    <div class="header d-flex justify-content-between align-items-center">
      <h1>Pengajuan</h1>
      <div class="user-menu position-relative">
        <div class="profile-icon" onclick="toggleDropdown()">
          <img src="../assets/img/icon.jpg" alt="Profile Icon">
        </div>
        <div class="dropdown" id="dropdownMenu">
          <span><br />NIM: <?php echo htmlspecialchars($nim_nik, ENT_QUOTES, 'UTF-8'); ?></span>
          <button><i class="fas fa-user"></i> Profile</button>
          <button><i class="fas fa-key"></i> Change Password</button>
          <a href="../function/logout.php"><button><i class="fas fa-sign-out-alt"></i> Logout</button></a>
        </div>
      </div>
    </div>
    <div class="header d-flex justify-content-between align-items-center my-4">
      <h1>Riwayat Pengajuan</h1>
      <button type="button" class="btn btn-primary">Tambah Pengajuan</button>
    </div>
    <table id="pengajuanTable" class="display" style="width:100%">
      <thead>
        <tr>
          <th>NIM/NIK</th>
          <th>Nama</th>
          <th>Program Studi</th>
          <th>Tanggal Pengajuan</th>
          <th>Status Pengajuan</th>
          <th>Status Berkas</th>
          <th>Detail</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['nim_nik']}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['program_studi']}</td>
                        <td>{$row['created_at']}</td>
                        <td>{$row['status_pengajuan']}</td>
                        <td>{$row['status_berkas']}</td>
                        <td><a href='detail_pengajuan.php?id={$row['id_pengajuan']}' class='btn btn-info btn-sm'>Detail</a></td>
                        <td><a href='hapus_pengajuan.php?id={$row['id_pengajuan']}' class='btn btn-danger btn-sm'>Hapus</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Belum ada data pengajuan.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <script>
    $(document).ready(function () {
      $('#pengajuanTable').DataTable();
    });

    function toggleDropdown() {
      const dropdownMenu = document.getElementById('dropdownMenu');
      dropdownMenu.classList.toggle('show');
    }
  </script>
</body>
</html>
