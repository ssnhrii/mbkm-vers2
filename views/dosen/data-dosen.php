<?php
// Import file koneksi database
include '../function/koneksi.php';
include('../function/proses-dashboard.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style-data-dosen.css">
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <img src="../assets/img/logo MBKM.png" alt="Logo" />
    </div>
    <nav>
      <a href="dashboard-admin.php" class="dashboard" onclick="activateMenu(this)">
        <span class="icon"><i class="fas fa-home-alt"></i></span>
        <span class="text">DASHBOARD</span>
      </a>
      <a href="data-dosen.php" class="pengajuan active" onclick="activateMenu(this)">
        <span class="icon"><i class="fas fa-file-alt"></i></span>
        <span class="text">MANAJEMEN USER</span>
      </a>
    </nav>
  </div>

  <div class="content">
    <!-- Header -->
    <div class="header">
      <h1>Manajemen User</h1>
      <div class="user-menu">
        <!-- Profile Icon -->
        <div class="profile-icon" onclick="toggleDropdown()">
          <img src="../assets/img/icon.jpg" alt="Profile Icon" />
        </div>
        <!-- Dropdown Menu -->
        <div class="dropdown" id="dropdownMenu">
          <span><br />Nama: <?php echo $data['nama_lengkap']; ?></span>
          <a href="profile.php"><button><i class="fas fa-user"></i> Profile</button></a>
          <a href="change-password.php?data=<?php echo $data['nim_nik'] ?>">
            <button><i class="fas fa-key"></i> Change Password</button>
          </a>
          <a href="../function/logout.php"><button><i class="fas fa-sign-out-alt"></i> Logout</button></a>
        </div>
      </div>
    </div>

    <!-- Daftar Dosen -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5>Daftar Dosen</h5>
      <a href="daftar-dosen.php" class="btn btn-success">Add Dosen</a>
    </div>

    <div class="table-container">
      <table id="dosenTable" class="table table-striped">
        <thead>
          <tr>
            <th>NIM/NIK</th>
            <th>Nama</th>
            <th>Prodi</th>
            <th>No. Handphone</th>
            <th>Alamat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Query untuk mengambil data dosen
          $sql = "SELECT u.nim_nik, u.nama_lengkap, p.nama_prodi, u.no_handphone, u.alamat 
                  FROM users u
                  LEFT JOIN prodi p ON u.id_prodi = p.id_prodi
                  WHERE u.role = 'dosen'";
          $result = $conn->query($sql);

          // Cek apakah data tersedia
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['nim_nik']) . "</td>";
              echo "<td>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
              echo "<td>" . htmlspecialchars($row['nama_prodi']) . "</td>";
              echo "<td>" . htmlspecialchars($row['no_handphone']) . "</td>";
              echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
              echo "<td>
                          <a href='edit-dosen.php?nim_nik=" . urlencode($row['nim_nik']) . "' class='btn btn-primary btn-sm'>Edit</a>
                          <a href='../function/delete_dosen.php?nim_nik=" . urlencode($row['nim_nik']) . "' 
                             class='btn btn-danger btn-sm' 
                             onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Delete</a>
                        </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='6' class='text-center'>Tidak ada data dosen</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Script -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Aktifkan DataTables
    $(document).ready(function () {
      $('#dosenTable').DataTable();

      const urlParams = new URLSearchParams(window.location.search);
      const message = urlParams.get('message');

      if (message === 'success') {
        alert('Data dosen berhasil dihapus.');
      } else if (message === 'error') {
        alert('Terjadi kesalahan saat menghapus data dosen.');
      } else if (message === 'invalid') {
        alert('Input tidak valid.');
      } else if (message === 'missing') {
        alert('Parameter nim_nik tidak ditemukan.');
      }
    });

    // Fungsi untuk toggle menu dropdown
    function toggleDropdown() {
      const dropdown = document.getElementById("dropdownMenu");
      dropdown.classList.toggle("show");
    }

    // Menutup dropdown jika klik di luar elemen
    window.onclick = function (event) {
      if (!event.target.closest(".profile-icon") && !event.target.closest("#dropdownMenu")) {
        const dropdown = document.getElementById("dropdownMenu");
        if (dropdown && dropdown.classList.contains("show")) {
          dropdown.classList.remove("show");
        }
      }
    };

    // Aktifkan menu sidebar
    function activateMenu(element) {
      document.querySelectorAll(".sidebar nav a").forEach((menu) => {
        menu.classList.remove("active");
      });
      element.classList.add("active");
    }
  </script>
</body>

</html>