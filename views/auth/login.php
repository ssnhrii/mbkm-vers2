<?php
// Koneksi ke database
include '../../controllers/auth/proses-login.php'; // Pastikan file koneksi.php ada di direktori yang sesuai';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sistem Login MBKM">
    <title>Login - Sistem MBKM</title>

    <!-- Favicon -->
    <link href="../assets/img/favicon.ico" rel="icon" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        }

        .login-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            transition: all 0.3s ease;
        }

        .login-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .logo {
            max-width: 180px;
            margin: 0 auto 1.5rem;
            display: block;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-control:focus {
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

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
        }

        .toggle-password:hover {
            color: var(--dark-color);
        }

        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .forgot-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .register-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .input-group {
            position: relative;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1.5rem;
                margin: 0 15px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="../../assets/img/logo-mbkm.png" alt="Logo MBKM" class="logo">
        <h3 class="text-center mb-4">Login Sistem MBKM</h3>

        <?php if (!empty($error_message) && $_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" id="username" name="username" class="form-control"
                        placeholder="Masukkan username" required
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Masukkan password" required>
                    <span class="toggle-password" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="lupa-password.php" class="forgot-link">Lupa Password?</a>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100 mb-3">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>

            <a href="registrasi.php" class="register-link">
                <i class="fas fa-user-plus me-2"></i>Belum punya akun? Daftar sekarang
            </a>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (!username || !password) {
                e.preventDefault();
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Username dan password harus diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>

    <?php if ($login_success): ?>
        <script>
            Swal.fire({
                title: "Login Berhasil!",
                text: "Anda akan diarahkan ke dashboard",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = '<?php echo $redirect_url; ?>';
            });
        </script>
    <?php endif; ?>
</body>

</html>