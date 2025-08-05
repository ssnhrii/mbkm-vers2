<?php
// Pastikan user sudah login dan memiliki role mahasiswa
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Dosen') {
    header('Location: login.php');
    exit();
}

// Ambil data mahasiswa dari database
include('../function/proses-dashboard.php');

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Polibatam Student Information System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/style-dashboard-mahasiswa.css" />
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="../assets/img/Logo MBKM.png" alt="Logo" />
        </div>
        <nav>
            <a href="dashboard-dosen.php" class="dashboard active" onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-home-alt"></i></span>
                <span class="text">DASHBOARD</span>
            </a>
            <a href="persetujuan-pengajuan.php" class="persetujuan pengajuan" onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-clipboard-check"></i></span>
                <span class="text">PERSETUJUAN PENGAJUAN</span>
            </a>
            <a href="rekap-pengajuan-dosen.php" class="rekap pengajuan" onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-file-signature"></i></span>
                <span class="text">REKAP PENGAJUAN</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <div class="header">
            <h1>
                Selamat Datang Di Sistem Informasi Dan Layanan Mahasiswa Polibatam
            </h1>
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
            <h5>Daftar Pengajuan</h5>
        </div>

        <div class="table-container">
            <table id="dosenTable" class="table table-striped">
                <thead>
                    <tr>
                        <th class='text-center'>NIM/NIK</th>
                        <th class='text-center'>Nama</th>
                        <th class='text-center'>Program Studi</th>
                        <th class='text-center'>Jumlah Pengajuan</th>
                        <th class='text-center'>Tanggal Pengajuan</th>
                        <th class='text-center'>Jenis Program</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "
SELECT 
    u.nim_nik, 
    u.nama_lengkap, 
    p.nama_prodi, 
    GROUP_CONCAT(DISTINCT n.jenis_program ORDER BY n.created_at DESC SEPARATOR ', ') AS jenis_program,
    GROUP_CONCAT(DATE_FORMAT(n.created_at, '%d/%m/%y %H:%i:%s') ORDER BY n.created_at DESC SEPARATOR ', ') AS tanggal_pengajuan, 
    COUNT(n.id_pengajuan) AS jumlah_pengajuan
FROM 
    users u
INNER JOIN 
    pengajuan_usulan n ON u.nim_nik = n.nim_nik
LEFT JOIN 
    prodi p ON u.id_prodi = p.id_prodi
GROUP BY 
    u.nim_nik, u.nama_lengkap, p.nama_prodi
LIMIT 10;
";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Cek apakah data tersedia
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                                echo "<td class='text-center'>" . htmlspecialchars($row['nim_nik']) . "</td>";
                                echo "<td class='text-center'>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
                                echo "<td class='text-center'>" . htmlspecialchars($row['nama_prodi']) . "</td>";
                                echo "<td class='text-center'>" . htmlspecialchars($row['jumlah_pengajuan']) . "</td>";
                                echo "<td class='text-center'>";
                                $tanggal_pengajuan = $row['tanggal_pengajuan'];
                                $tanggal_array = explode(', ', $tanggal_pengajuan);
                                foreach ($tanggal_array as $tanggal) {
                                    echo date("d/m/y", strtotime($tanggal)) . "<br>";
                                }
                                echo "</td>";
                                $jenis_array = explode(', ', $row['jenis_program']);
                                echo"<td class='text-center'>";
                                foreach ($jenis_array as $jenis) {
                                    echo"$jenis" . "<br>";
                                }
                                    echo"</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>ANDA BELUM MELAKUKAN PENGAJUAN...</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#pengajuanTable').DataTable();
            })
            function toggleDropdown() {
                const dropdown = document.getElementById("dropdownMenu");
                dropdown.classList.toggle("show");
            }

            window.onclick = function (event) {
                if (!event.target.matches(".profile-icon img")) {
                    const dropdown = document.getElementById("dropdownMenu");
                    if (dropdown.classList.contains("show")) {
                        dropdown.classList.remove("show");
                    }
                }
            };

            function activateMenu(element) {
                document.querySelectorAll(".sidebar nav a").forEach((menu) => {
                    menu.classList.remove("active");
                });
                element.classList.add("active");
            }
        </script>
</body>

</html>