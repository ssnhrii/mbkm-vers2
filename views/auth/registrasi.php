<?php
// Koneksi ke database
include '../../controllers/auth/proses-registrasi.php'; // Pastikan file koneksi.php ada di direktori yang sesuai';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sistem MBKM</title>
    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .form-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 600px;
            transition: all 0.3s ease;
        }

        .form-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .logo {
            max-width: 180px;
            margin: 0 auto 1.5rem;
            display: block;
        }

        .form-control,
        .form-select {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .eye-icon {
            cursor: pointer;
            background-color: var(--light-color);
            border: 1px solid #ddd;
            border-left: none;
            border-radius: 0 8px 8px 0;
        }

        .eye-icon:hover {
            background-color: #dfe6e9;
        }

        .input-group-text {
            background-color: var(--light-color);
        }

        .text-danger {
            color: var(--accent-color) !important;
        }

        .alert {
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <!-- Logo Kampus Merdeka -->
        <img src="../../assets/img/logo-mbkm.png" alt="Logo MBKM" class="logo">
        <h2 class="text-center mb-4">Registrasi Akun</h2>

        <!-- Error Messages -->
        <?php if (!empty($error_messages)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach ($error_messages as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Form Registrasi -->
        <form action="" method="POST" onsubmit="return validateForm()">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nim" class="form-label">NIM/NIP <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nim_nik" id="nim"
                        placeholder="Masukkan NIM/NIP" required
                        value="<?php echo isset($_POST['nim_nik']) ? htmlspecialchars($_POST['nim_nik']) : ''; ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="username" id="username"
                        placeholder="Masukkan Username" required
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="namaLengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="namaLengkap" id="namaLengkap"
                    placeholder="Masukkan Nama Lengkap" required
                    value="<?php echo isset($_POST['namaLengkap']) ? htmlspecialchars($_POST['namaLengkap']) : ''; ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">No. Handphone <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control" name="phone" id="phone"
                            placeholder="Masukkan No. Handphone" required
                            value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Masukkan Email" required
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control" name="alamat" id="alamat" rows="2"
                    placeholder="Masukkan Alamat" required><?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                    <select class="form-select" name="jurusan" id="jurusan" required onchange="updateProdi()">
                        <option value="" selected disabled>Pilih Jurusan</option>
                        <?php while ($jurusan = mysqli_fetch_assoc($result_all_jurusan)): ?>
                            <option value="<?= $jurusan['id_jurusan'] ?>"
                                <?= (isset($_POST['jurusan']) && $_POST['jurusan'] == $jurusan['id_jurusan']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($jurusan['nama_jurusan']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="prodi" class="form-label">Program Studi <span class="text-danger">*</span></label>
                    <select class="form-select" name="prodi" id="prodi" required disabled>
                        <option value="" selected disabled>Pilih Jurusan terlebih dahulu</option>
                        <?php if (isset($_POST['jurusan']) && !empty($_POST['jurusan'])): ?>
                            <?php foreach ($prodi_options[$_POST['jurusan']] as $prodi): ?>
                                <option value="<?= $prodi['id_prodi'] ?>"
                                    <?= (isset($_POST['prodi']) && $_POST['prodi'] == $prodi['id_prodi']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($prodi['nama_prodi']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Masukkan Password" required>
                        <span class="input-group-text eye-icon" onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="form-text">Minimal 8 karakter</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="confirm-password" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="confirm-password" id="confirm-password"
                            placeholder="Konfirmasi Password" required>
                        <span class="input-group-text eye-icon" onclick="togglePassword('confirm-password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div id="password-error" class="alert alert-danger mb-3" style="display: none;"></div>

            <button type="submit" name="submit" class="btn btn-primary w-100 mt-3">
                <i class="fas fa-user-plus me-2"></i>Daftar
            </button>

            <div class="text-center mt-3">
                Sudah punya akun? <a href="login.php" class="text-primary">Login disini</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.js"></script>

    <script>
        // Data prodi yang dikonversi dari PHP ke JavaScript
        const prodiData = <?php echo $prodi_options_json; ?>;

        function togglePassword(fieldId, icon) {
            const field = document.getElementById(fieldId);
            const isPassword = field.type === 'password';
            field.type = isPassword ? 'text' : 'password';
            icon.querySelector('i').classList.toggle('fa-eye');
            icon.querySelector('i').classList.toggle('fa-eye-slash');
        }

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const errorDiv = document.getElementById('password-error');

            // Reset error display
            errorDiv.style.display = 'none';
            errorDiv.innerHTML = '';

            // Check password match
            if (password !== confirmPassword) {
                errorDiv.innerHTML = 'Password dan Konfirmasi Password tidak sesuai';
                errorDiv.style.display = 'block';
                return false;
            }

            // Check password length
            if (password.length < 8) {
                errorDiv.innerHTML = 'Password harus minimal 8 karakter';
                errorDiv.style.display = 'block';
                return false;
            }

            return true;
        }

        // Fungsi untuk mengupdate prodi berdasarkan jurusan yang dipilih
        function updateProdi() {
            const jurusanSelect = document.getElementById('jurusan');
            const prodiSelect = document.getElementById('prodi');
            const selectedJurusan = jurusanSelect.value;
            
            // Reset prodi select
            prodiSelect.innerHTML = '<option value="" selected disabled>Pilih Program Studi</option>';
            prodiSelect.disabled = !selectedJurusan;
            
            if (!selectedJurusan) return;
            
            // Isi opsi prodi berdasarkan jurusan yang dipilih
            if (prodiData[selectedJurusan]) {
                prodiData[selectedJurusan].forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi.id_prodi;
                    option.textContent = prodi.nama_prodi;
                    prodiSelect.appendChild(option);
                });
            }
            
            // Jika ada nilai yang dipilih sebelumnya, set ulang
            <?php if (isset($_POST['prodi']) && !empty($_POST['prodi'])): ?>
                if (document.querySelector(`#prodi option[value="<?= $_POST['prodi'] ?>"]`)) {
                    prodiSelect.value = "<?= $_POST['prodi'] ?>";
                }
            <?php endif; ?>
        }

        // Panggil fungsi updateProdi saat halaman dimuat jika jurusan sudah dipilih sebelumnya
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('jurusan').value) {
                updateProdi();
            }
        });

        // Show success message if registration was successful
        <?php if (!empty($success_message)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Sukses!',
                    text: '<?php echo addslashes($success_message); ?>',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'login.php';
                });
            });
        <?php endif; ?>
    </script>
</body>
</html>