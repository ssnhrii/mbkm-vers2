<?php
// Pastikan user sudah login dan memiliki role mahasiswa
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Mahasiswa') {
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
            <a href="dashboard-mahasiswa.php" class="dashboard" onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-home-alt"></i></span>
                <span class="text">DASHBOARD</span>
            </a>
            <nav>
                <a href="formulir.php?nim_nik=<?php echo $data['nim_nik']; ?>" class="pengajuan"
                    onclick="activateMenu(this)">
                    <span class="icon"><i class="fas fa-file-alt"></i></span>
                    <span class="text">PENGAJUAN</span>
                </a>
            </nav>
            <a href="rekap-pengajuan.php?nim_nik=<?php echo $data['nim_nik']; ?>" class="rekap active"
                onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-file-alt"></i></span>
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
            <a href="formulir.php?nim_nik=<?php echo $data['nim_nik']; ?>" class="btn btn-success">Daftar</a>
        </div>

        <div class="table-container">
            <table id="dosenTable" class="table table-striped">
                <thead>
                    <tr>
                        <th class='text-center'>NIM/NIK</th>
                        <th class='text-center'>Nama</th>
                        <th class='text-center'>Program Studi</th>
                        <th class='text-center'>Tanggal Pengajuan</th>
                        <th class='text-center'>Status Pengajuan</th>
                        <th class='text-center'>Status Berkas</th>
                        <th class='text-center'>Detail</th>
                        <th class='text-center'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT u.nim_nik, u.nama_lengkap, p.nama_prodi, n.created_at, n.status_pengajuan, n.id_pengajuan
                    FROM users u
                    LEFT JOIN pengajuan_usulan n ON u.nim_nik = n.nim_nik
                    LEFT JOIN prodi p ON u.id_prodi = p.id_prodi
                    WHERE u.nim_nik = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $data['nim_nik']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Cek apakah data tersedia
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['nim_nik']) . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['nama_prodi']) . "</td>";
                            if($row['created_at']) {
                                $timestamp = strtotime($row['created_at']);
                                $formatted_date = date("d/m/y", $timestamp);
                                echo "<td class='text-center'>" . htmlspecialchars($formatted_date) . "</td>";
                            } else {
                                echo"<td></td>";
                            }
                            $status_class = '';
                            switch ($row['status_pengajuan']) {
                                case 'Menunggu Persetujuan':
                                    $status_class = 'btn-warning';
                                    break;
                                case 'Ditolak':
                                    $status_class = 'btn-danger';
                                    break;
                                case 'Diterima':
                                    $status_class = 'btn-success';
                                    break;
                                default:
                                    $status_class = 'btn-secondary';
                                    break;
                            }

                            if($row['status_pengajuan']) {
                                echo "<td class='text-center'><p class='btn $status_class btn-sm' style='cursor: default;'>" . htmlspecialchars($row['status_pengajuan']) . "</p></td>";
                                if ($row['status_pengajuan'] === 'Diterima') {
                                    $sqlBerkas = "SELECT *
                                    FROM upload_berkas
                                    WHERE id_pengajuan = ?";
    
                                    $stmtBerkas = $conn->prepare($sqlBerkas);
                                    $stmtBerkas->bind_param("i", $row['id_pengajuan']);
                                    $stmtBerkas->execute();
                                    $resultBerkas = $stmtBerkas->get_result();
                                    $rowBerkas = $resultBerkas->fetch_assoc();
    
                                    if (isset($rowBerkas)) {
                                        if ($rowBerkas['status_berkas'] === 'Menunggu Persetujuan') {
                                            echo "<td class='text-center'>
                                            <p class='btn btn-warning btn-sm' style='cursor: default;'>Menunggu Persetujuan</p>
                                        </td>";
                                        } else if ($rowBerkas['status_berkas'] === 'Ditolak') {
                                            echo"<td class='text-center'><p class='btn btn-danger btn-sm' style='cursor: default;'>" . htmlspecialchars($rowBerkas['status_berkas']) . "</p></td>";
                                        } else if ($rowBerkas['status_berkas'] === null) {
                                            echo "<td class='text-center'>
                                                <p class='btn btn-warning btn-sm' style='cursor: default;'>Anda belum meng-upload berkas akhir</p>
                                            </td>";
                                        } else if ($rowBerkas['status_berkas'] === 'Diterima') {
                                            echo"<td class='text-center'><p class='btn btn-success btn-sm' style='cursor: default;'>" . htmlspecialchars($rowBerkas['status_berkas']) . "</p></td>";
                                        }
                                    } else {
                                        echo "<td class='text-center'>
                                        <p class='btn btn-warning btn-sm' style='cursor: default;'>Anda belum meng-upload berkas akhir</p>
                                    </td>";
                                    }
    
                                } else {
                                    echo "<td></td>";
                                }
                            } else {
                                echo "<td></td>";
                            }
                            $flex_class = 'display: flex; flex-direction: column; gap: 4px; height: 100%;';
                            echo "<td class='text-center' style='"; (isset($rowBerkas) &&  $rowBerkas['status_berkas'] ? $flex_class : isset($rowBerkas) &&  $rowBerkas['Diterima']) ? $flex_class : ''; echo"'>";
                            if($row['id_pengajuan']) {
                                echo "<a href=detail-pengajuan.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . " class='btn btn-primary btn-sm'>Lihat Form</a>";
                            }
                            if (isset($rowBerkas)) {
                                if ($rowBerkas['status_berkas'] === 'Menunggu Persetujuan') {
                                    echo "<a href=upload-berkas.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . " class='btn btn-info btn-sm'>Lihat Berkas akhir</a>";
                                } else if ($rowBerkas['status_berkas'] === 'Diterima') {
                                    echo "<a href=upload-berkas.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . " class='btn btn-info btn-sm'>Lihat Berkas akhir</a>";
                                }
                            } else {
                                echo "<p class='text-center'>
                            </p>";
                            }
                            echo "</td>";
                            if ($row['status_pengajuan'] === 'Ditolak') {
                                echo "<td></td>";
                            } else if ($row['status_pengajuan'] === 'Diterima') {
                                if(isset($rowBerkas)) {
                                    if($rowBerkas['status_berkas'] === 'Ditolak') {
                                        echo "<td class='text-center'><a href=upload-berkas.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . " class='btn btn-info btn-sm'>Lihat Berkas akhir</a></td>";
                                    } else {
                                        echo"<td></td>";
                                    }
                                } else {
                                    echo "<td class='text-center'><a href=upload-berkas.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . " class='btn btn-info btn-sm'>Upload Berkas akhir</a></td>";
                                }
                            } else if ($row['status_pengajuan'] === 'Menunggu Persetujuan') {
                                echo "<td class='text-center'>
                              <a href='edit-pengajuan.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . "' class='btn btn-primary btn-sm'>Edit</a>
                              <a href='../function/delete_pengajuan.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . "'
                                 class='btn btn-danger btn-sm' 
                                 onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Delete</a>
                            </td>";
                            }
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