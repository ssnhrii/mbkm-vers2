<?php
include("../function/koneksi.php");

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['nim_nik'])) {
    echo "  <script>
                    alert('NIM/NIK tidak ditemukan!');
                    window.location.href='data-dosen.php';
                </script>";
    exit;
}

$nim_nik = $conn->real_escape_string($_GET['nim_nik']);
$dosen = null;

$sql = "SELECT * FROM users WHERE nim_nik = '$nim_nik' AND role = 'dosen'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $dosen = $result->fetch_assoc();
} else {
    echo "<script>alert('Data dosen tidak ditemukan!');window.location.href='data-dosen.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari form
    $nama_lengkap = $conn->real_escape_string($_POST['namaLengkap']);
    // $nim_nik = $conn->real_escape_string($_POST['nim_nik']);
    $id_prodi = isset($_POST['id_prodi']) ? $conn->real_escape_string($_POST['id_prodi']) : null;
    $email = $conn->real_escape_string($_POST['email']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $no_handphone = $conn->real_escape_string($_POST['phone']);
    $role = "dosen";
    $username = $conn->real_escape_string($_POST['username'] ?? $nim_nik);

    // Validasi input
    if (empty($id_prodi)) {
        echo "<script>alert('Prodi harus dipilih!');window.history.back();</script>";
        exit;
    }
    if (empty($username)) {
        echo "<script>alert('Username tidak boleh kosong!');window.history.back();</script>";
        exit;
    }

    $sql = "UPDATE users 
            SET nama_lengkap = '$nama_lengkap', id_prodi = '$id_prodi', email = '$email', alamat = '$alamat', 
                no_handphone = '$no_handphone', username = '$username'
            WHERE nim_nik = '$nim_nik' AND role = 'dosen'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!');window.location.href='data-dosen.php';</script>";
    } else {
        echo "SQL Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style-data-dosen.css">
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row m-0">
            <!-- Sidebar -->
            <div class="col-lg-2 bg-dark text-white p-3 vh-100">
                <div class="text-center my-3">
                    <img src="../assets/img/logo MBKM.png" alt="Logo" class="img-fluid" style="max-width: 120px;">
                </div>
                <nav class="nav flex-column">
                    <a href="dashboard-admin.php" class="nav-link text-white mb-2">
                        <i class="fas fa-home me-2"></i> DASHBOARD
                    </a>
                    <a href="data-dosen.php" class="nav-link text-white active">
                        <i class="fas fa-file-alt me-2"></i> MANAJEMEN USER
                    </a>
                </nav>
            </div>
            <div class="col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 header">
                    <h3>Edit Dosen</h3>
                    <!-- Profil Dropdown -->
                    <div class="user-menu">
                        <!-- Profile Icon -->
                        <div class="profile-icon" onclick="toggleDropdown()">
                            <img src="../assets/img/icon.jpg" alt="Profile Icon" />
                        </div>
                        <!-- Dropdown Menu -->
                        <div class="dropdown" id="dropdownMenu">
                            <span><br />Nama: <?php echo $data['nama_lengkap']; ?></span>
                            <a href="profile.php"><button><i class="fas fa-user"></i> Profile</button></a>
                            <a href='change-password.php?data=<?php echo $data['nim_nik'] ?>'
                                class='btn btn-light btn-sm'><i class='fas fa-key'></i> Change Password</a>
                            <a href="../function/logout.php"><button><i class="fas fa-sign-out-alt"></i>
                                    Logout</button></a>
                        </div>
                    </div>
                </div>
                <!-- Form Edit Dosen -->
                <div class="card shadow-sm p-4">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="namaLengkap" id="namaLengkap"
                                placeholder="Masukkan Nama Lengkap"
                                value="<?= htmlspecialchars($dosen['nama_lengkap']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nim_nik" class="form-label">NIM/NIK</label>
                            <input type="text" class="form-control" id="nim_nik"
                                value="<?= htmlspecialchars($dosen['nim_nik']) ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="id_prodi" class="form-label">Prodi</label>
                            <select class="form-select" name="id_prodi" id="id_prodi" required>
                                <option value="">Pilih Prodi</option>
                                <?php
                                $prodiResult = $conn->query("SELECT * FROM prodi");
                                while ($prodi = $prodiResult->fetch_assoc()) {
                                    $selected = $dosen['id_prodi'] == $prodi['id_prodi'] ? 'selected' : '';
                                    echo "<option value='" . $prodi['id_prodi'] . "' $selected>" . htmlspecialchars($prodi['nama_prodi']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="<?= htmlspecialchars($dosen['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat"
                                required><?= htmlspecialchars($dosen['alamat']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Handphone</label>
                            <input type="text" class="form-control" name="phone" id="phone"
                                value="<?= htmlspecialchars($dosen['no_handphone']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username"
                                value="<?= htmlspecialchars($dosen['username']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
</body>

</html>