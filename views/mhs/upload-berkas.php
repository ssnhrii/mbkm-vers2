<?php
// Pastikan user sudah login dan memiliki role mahasiswa
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Ambil data mahasiswa dari database
include('../function/proses-berkas.php');

$sqlDetail = "
    SELECT 
        ub.*, 
        k.komentar AS komentar
    FROM 
        upload_berkas ub
    LEFT JOIN 
        komentar k ON ub.komentar = k.Id_komentar
    WHERE 
        ub.id_pengajuan = ?";
$stmtDetail = $conn->prepare($sqlDetail);
$stmtDetail->bind_param("i", $_GET['data']);
$stmtDetail->execute();
$resultDetail = $stmtDetail->get_result();
$rowDetail = $resultDetail->fetch_assoc();

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
        <div class="header" id="header">
            <h1>
                Upload Berkas Akhir
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


        <div class="berkas-main">
            <form
                action="../function/proses-upload-berkas.php?data=<?php echo $_GET['data']; ?>&nim_nik=<?php echo $_GET['nim_nik']; ?>"
                method="post" enctype="multipart/form-data">
                <div class="berkas-body">
                    <p>Transkip Nilai</p>
                    <?php if (!empty($rowDetail['file_path'])): ?>
                        <p>File saat ini: <a href="<?php echo htmlspecialchars($rowDetail['file_path']); ?>"
                                target="_blank">
                                <?php echo htmlspecialchars(basename($rowDetail['file_path'])); ?>
                            </a></p>
                    <?php endif; ?>
                    <input type="file" name="transkip_nilai" id="">
                </div>
                <div class="berkas-body">
                    <p>Dokumen MBKM</p>
                    <?php if (!empty($rowDetail['dokumen_mbkm'])): ?>
                        <p>File saat ini: <a href="<?php echo htmlspecialchars($rowDetail['dokumen_mbkm']); ?>"
                                target="_blank">
                                <?php echo htmlspecialchars(basename($rowDetail['dokumen_mbkm'])); ?>
                            </a></p>
                    <?php endif; ?>

                    <input type="file" name="dokumen_mbkm" id="">
                </div>
                <?php
                if (isset($rowDetail['status_berkas'])) {
                    if ($rowDetail['status_berkas'] === 'Menunggu Persetujuan' || $rowDetail['status_berkas'] === null) {
                        echo '<button type="submit" class="btn btn-primary btn-sm">Simpan</button>';
                    } elseif ($rowDetail['status_berkas'] === 'Diterima') {
                        echo '<p class="btn btn-success btn-sm" style="cursor: default;">Diterima</p>';
                    } else {
                        echo '<p class="btn btn-danger btn-sm" style="cursor: default;">Ditolak</p>';
                    }
                } else {
                    echo '<button type="submit" class="btn btn-primary btn-sm">Simpan</button>';
                }
                ?>
            </form>
            <?php
            if (isset($rowDetail['status_berkas'])) {
                if ($rowDetail['komentar']) {
                    echo '<div class="berkas-komentar">
                    <div>
                        <p>Komentar : </p>
                        <p>';
                    echo $rowDetail['komentar'];
                    echo '</p>
                    </div>
                </div>';
                }
            }
            ?>
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