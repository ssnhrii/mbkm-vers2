<?php
session_start();
include '../function/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Ambil data user berdasarkan session username
$username = $_SESSION['username'];
$sql = "SELECT nim_nik, nama_lengkap, no_handphone, email, alamat, id_prodi FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>
            alert('Data pengguna tidak ditemukan!');
            window.location.href = 'login.php';
        </script>";
    exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="../assets/css/style-edit-profile.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <div style="text-align: center;">
            <h2>Edit Profile</h2>
        </div>
        <form action="" method="POST">
            <div class="form-content">
                <div class="input-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($user['nim_nik']); ?>" readonly style="background-color: #f0f0f0; color: #666;">
                </div>
                <div class="input-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>">
                </div>
                <div class="input-group">
                    <label for="phone">No. Handphone</label>
                    <input type="text" id="phone" name="no_handphone" value="<?php echo htmlspecialchars($user['no_handphone']); ?>">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                <div class="input-group">
                    <label for="address">Alamat</label>
                    <textarea id="address" name="alamat" rows="3"><?php echo htmlspecialchars($user['alamat']); ?></textarea>
                </div>
                <div class="input-group">
                    <label for="program">Prodi</label>
                    <select id="program" name="id_prodi">
                        <?php
                        $query_prodi = "SELECT id_prodi, nama_prodi FROM prodi";
                        $result_prodi = mysqli_query($conn, $query_prodi);

                        while ($row = mysqli_fetch_assoc($result_prodi)) {
                            $selected = $row['id_prodi'] == $user['id_prodi'] ? 'selected' : '';
                            echo "<option value='" . $row['id_prodi'] . "' $selected>" . $row['nama_prodi'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" name="update" class="save-btn">Simpan</button>
            </div>
        </form>
    </div>

</body>

</html>

<?php
// Update data profile jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_handphone = $_POST['no_handphone'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $id_prodi = $_POST['id_prodi'];

    $sql_update = "UPDATE users SET nama_lengkap = ?, no_handphone = ?, email = ?, alamat = ?, id_prodi = ? WHERE username = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssss", $nama_lengkap, $no_handphone, $email, $alamat, $id_prodi, $username);

    if ($stmt_update->execute()) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil diperbarui!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = 'dashboard-mahasiswa.php';
                });
            </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat memperbarui data!',
                    confirmButtonText: 'Coba Lagi'
                }).then(() => {
                    window.history.back();
                });
            </script>";
    }

    $stmt_update->close();
}

$conn->close();
?>
