<?php
// Pastikan user sudah login dan memiliki role dosen
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Dosen') {
    header('Location: login.php');
    exit();
}

// Ambil data mahasiswa dari database
include ('../function/proses-dashboard.php');

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polibatam Student Information System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/style-dashboard-dosen.css" />
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

        <!-- Welcome Message -->
        <div class="welcome">Anda dapat menikmati layanan secara online</div>

        <!-- Information Box -->
        <div class="info">
            Silahkan lakukan update data diri terlebih dahulu di menu PROFILE atau
            <a href="profile.php">KLIK DISINI</a> sebelum melakukan pengajuan, sebagai
            pemutakhiran data untuk berbagai kebutuhan. Terima Kasih
        </div>

        <!-- Student Data -->
        <div class="student-data">
            <img src="../assets/img/stickman.jpeg" alt="Student Photo" />
            <div class="student-details">
                <h2>DATA DOSEN</h2>
                <div class="details-row">
                    <span class="label">NIK</span>
                    <span class="separator">:</span>
                    <span class="value"><?php echo $data['nim_nik']; ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Username</span>
                    <span class="separator">:</span>
                    <span class="value"><?php echo $data['username']; ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Nama Lengkap</span>
                    <span class="separator">:</span>
                    <span class="value"><?php echo $data['nama_lengkap']; ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Email</span>
                    <span class="separator">:</span>
                    <span class="value"><?php echo $data['email']; ?></span>
                </div>
                <div class="details-row">
                    <span class="label">No. Handphone</span>
                    <span class="separator">:</span>
                    <span class="value"><?php echo $data['no_handphone']; ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Alamat</span>
                    <span class="separator">:</span>
                    <span class="value"><?php echo $data['alamat']; ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Prodi</span>
                    <span class="separator">:</span>
                    <span class="value"><?php echo $prodi; ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Role</span>
                    <span class="separator">:</span>
                    <span class="value"><?php echo $data['role']; ?></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdownMenu");
            dropdown.classList.toggle("show");
        }

        window.onclick = function(event) {
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