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
$sql = "SELECT u.nim_nik, u.nama_lengkap, u.no_handphone, u.email, u.alamat, p.nama_prodi 
        FROM users u 
        JOIN prodi p ON u.id_prodi = p.id_prodi 
        WHERE u.username = ?";
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
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="../assets/css/style-profile.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Profil Anda</h1>
        <div class="profile-item">
            <label for="nim">NIM</label>
            <input type="text" id="nim" value="<?php echo htmlspecialchars($user['nim_nik']); ?>" readonly>
        </div>
        <div class="profile-item">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" readonly>
        </div>
        <div class="profile-item">
            <label for="phone">No. Handphone</label>
            <input type="text" id="phone" value="<?php echo htmlspecialchars($user['no_handphone']); ?>" readonly>
        </div>
        <div class="profile-item">
            <label for="email">Email</label>
            <input type="text" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
        </div>
        <div class="profile-item">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" value="<?php echo htmlspecialchars($user['alamat']); ?>" readonly>
        </div>
        <div class="profile-item">
            <label for="prodi">Prodi</label>
            <input type="text" id="prodi" value="<?php echo htmlspecialchars($user['nama_prodi']); ?>" readonly>
        </div>
        <div class="edit-button">
            <button onclick="window.location.href='Edit Profile.php';">Edit</button>
        </div>
    </div>
</body>

</html>
