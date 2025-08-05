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
            <a href="dashboard-mahasiswa.php" class="dashboard active" onclick="activateMenu(this)">
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
            <a href="rekap-pengajuan.php?nim_nik=<?php echo $data['nim_nik']; ?>" class="pengajuan"
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
                    $sql = "SELECT 
    p.*, 
    u1.nim_nik AS nama_nim_nik, 
    u2.nama_lengkap AS nama_dosen_pembimbing,
    u3.nama_lengkap AS nama_pengaju,
    pr.nama_prodi AS nama_prodi
FROM 
    pengajuan_usulan p
INNER JOIN 
    users u1 ON p.nim_nik = u1.nim_nik
INNER JOIN 
    users u2 ON p.dosen_pembimbing = u2.nim_nik
INNER JOIN 
    users u3 ON p.nim_nik = u3.nim_nik
INNER JOIN
    prodi pr ON u1.id_prodi = pr.id_prodi;
";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Cek apakah data tersedia
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['nama_nim_nik']) . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['nama_pengaju']) . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['nama_prodi']) . "</td>";
                            if ($row['created_at']) {
                                $timestamp = strtotime($row['created_at']);
                                $formatted_date = date("d/m/y", $timestamp);
                                echo "<td class='text-center'>" . htmlspecialchars($formatted_date) . "</td>";
                            } else {
                                echo "<td></td>";
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

                            if ($row['status_pengajuan']) {
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
                                            echo "<td class='text-center'><p class='btn btn-danger btn-sm' style='cursor: default;'>" . htmlspecialchars($rowBerkas['status_berkas']) . "</p></td>";
                                        } else if ($rowBerkas['status_berkas'] === null) {
                                            echo "<td class='text-center'>
                                            </td>";
                                        } else if ($rowBerkas['status_berkas'] === 'Diterima') {
                                            echo "<td class='text-center'><p class='btn btn-success btn-sm' style='cursor: default;'>" . htmlspecialchars($rowBerkas['status_berkas']) . "</p></td>";
                                        }
                                    } else {
                                        echo "<td class='text-center'>
                                    </td>";
                                    }

                                } else {
                                    echo "<td></td>";
                                }
                            } else {
                                echo "<td></td>";
                            }
                            $flex_class = 'display: flex; flex-direction: column; gap: 4px; height: 100%;';
                            echo "<td class='text-center' style='";
                            (isset($rowBerkas) && $rowBerkas['status_berkas'] ? $flex_class : isset($rowBerkas) && $rowBerkas['Diterima']) ? $flex_class : '';
                            echo "'>";
                            if ($row['id_pengajuan']) {
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
                                if (isset($rowBerkas)) {
                                    if ($rowBerkas['status_berkas'] === 'Diterima' || $rowBerkas['status_berkas'] === 'Ditolak') {
                                        echo "<td></td>";
                                    } else {
                                        echo "<td class='text-center'>
                                  <a href='../function/terima_berkas.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . "' class='btn btn-success btn-sm'>Terima</a>
<a href='#' 
   class='btn btn-danger btn-sm' 
   data-bs-toggle='modal' 
   data-bs-target='#tolakModal'
   data-id_pengajuan='" . htmlspecialchars($row['id_pengajuan']) . "'
   data-nim_nik=" . htmlspecialchars($row['nim_nik']) . "'
   id='tolakBtn'>Tolak</a>
                                </td>";
                                    }
                                } else {
                                    echo "<td></td>";
                                }
                            } else if ($row['status_pengajuan'] === 'Menunggu Persetujuan') {
                                echo "<td class='text-center'>
                              <a href='../function/terima_pengajuan.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . "' class='btn btn-success btn-sm'>Terima</a>
                              <a href='../function/tolak_pengajuan.php?data=" . htmlspecialchars($row['id_pengajuan']) . "&nim_nik=" . htmlspecialchars($row['nim_nik']) . "'
                                 class='btn btn-danger btn-sm' 
                                 onclick='return confirm(\"Apakah Anda yakin ingin menolak data ini?\");'>Tolak</a>
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

        <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tolakModalLabel">Alasan Penolakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../function/tolak_berkas.php" method="POST">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Komentar:</label>
                                <textarea id="comment" class="form-control" name="comment" rows="4" required></textarea>
                            </div>
                            <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="">
                            <input type="hidden" name="nim_nik" id="nim_nik" value="">
                            <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $('#tolakModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); 
                var id_pengajuan = button.data('id_pengajuan');
                var nim_nik = button.data('nim_nik');

                var modal = $(this);
                modal.find('#id_pengajuan').val(id_pengajuan);
                modal.find('#nim_nik').val(nim_nik); 
            });

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