<?php
// Koneksi ke database
require __DIR__ . '/../koneksi.php';
// Pastikan file koneksi.php ada di direktori yang sesuai';

// Initialize variables
$error_messages = [];
$success_message = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $nim_nik = trim($_POST['nim_nik']);
    $username = trim($_POST['username']);
    $namaLengkap = trim($_POST['namaLengkap']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $alamat = trim($_POST['alamat']);
    $prodi = $_POST['prodi'] ?? '';
    $jurusan = $_POST['jurusan'] ?? '';
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'] ?? '';

    // Validate inputs
    if (empty($nim_nik)) $error_messages[] = "NIM/NIK harus diisi";
    if (empty($username)) $error_messages[] = "Username harus diisi";
    if (empty($namaLengkap)) $error_messages[] = "Nama lengkap harus diisi";
    if (empty($phone)) $error_messages[] = "Nomor handphone harus diisi";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $error_messages[] = "Email tidak valid";
    if (empty($alamat)) $error_messages[] = "Alamat harus diisi";
    if (empty($jurusan)) $error_messages[] = "Jurusan harus dipilih";
    if (empty($prodi)) $error_messages[] = "Program studi harus dipilih";
    if (empty($password)) $error_messages[] = "Password harus diisi";
    if ($password !== $confirm_password) $error_messages[] = "Password dan konfirmasi password tidak sama";

    // Check if program study belongs to selected department
    if (!empty($jurusan) && !empty($prodi) && empty($error_messages)) {
        $check_prodi = "SELECT id_prodi FROM prodi WHERE id_prodi = ? AND id_jurusan = ?";
        $stmt = $conn->prepare($check_prodi);
        $stmt->bind_param("ii", $prodi, $jurusan);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $error_messages[] = "Program studi tidak valid untuk jurusan yang dipilih";
        }
        $stmt->close();
    }

    // Check if username or email already exists
    if (empty($error_messages)) {
        $check_query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['username'] === $username) $error_messages[] = "Username sudah digunakan";
                if ($row['email'] === $email) $error_messages[] = "Email sudah terdaftar";
            }
        }
        $stmt->close();
    }

    // If no errors, proceed with registration
    if (empty($error_messages)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $insert_query = "INSERT INTO users (nim_nik, username, nama_lengkap, phone, email, alamat, id_prodi, id_jurusan, password, role) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'mahasiswa')";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssssssiis", $nim_nik, $username, $namaLengkap, $phone, $email, $alamat, $prodi, $jurusan, $hashed_password);

        if ($stmt->execute()) {
            $success_message = "Registrasi berhasil! Silakan login.";
            // Clear form
            $_POST = array();
        } else {
            $error_messages[] = "Terjadi kesalahan saat menyimpan data. Silakan coba lagi.";
        }
        $stmt->close();
    }
}

// Get all departments (jurusan)
$query_all_jurusan = "SELECT id_jurusan, nama_jurusan FROM jurusan";
$result_all_jurusan = mysqli_query($conn, $query_all_jurusan);

// Get all study programs grouped by jurusan
$query_prodi_by_jurusan = "SELECT id_prodi, nama_prodi, id_jurusan FROM prodi";
$result_prodi_by_jurusan = mysqli_query($conn, $query_prodi_by_jurusan);

$prodi_options = [];
while ($row = mysqli_fetch_assoc($result_prodi_by_jurusan)) {
    $prodi_options[$row['id_jurusan']][] = $row;
}

// Convert to JSON for JavaScript
$prodi_options_json = json_encode($prodi_options);
?>
