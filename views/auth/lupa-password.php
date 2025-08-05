<?php
include '../../controllers/auth/proses-lupa.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Informasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="w-full max-w-md mx-4">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img src="../../assets/img/logo-mbkm.png" alt="Logo MBKM" class="h-16">
            </div>

            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Reset Password</h1>

            <!-- Status Message -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="mb-4 p-4 rounded-lg <?php echo $_SESSION['message_type'] === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?>">
                    <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Email Form -->
            <?php if (!isset($_SESSION['step']) || $_SESSION['step'] === 'email'): ?>
            <form method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Terdaftar</label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="Masukkan email Anda" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                        <i class="fas fa-envelope absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200"
                >
                    Kirim Kode OTP
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>
            <?php endif; ?>

            <!-- OTP Form -->
            <?php if (isset($_SESSION['step']) && $_SESSION['step'] === 'otp'): ?>
            <form method="POST" class="space-y-6">
                <div>
                    <p class="text-sm text-gray-600 mb-4">
                        Kami telah mengirim kode OTP ke email <span class="font-semibold"><?php echo $_SESSION['email']; ?></span>.
                        Silakan periksa inbox atau folder spam Anda.
                    </p>
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">Kode OTP</label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="otp" 
                            name="otp" 
                            maxlength="6" 
                            placeholder="Masukkan 6 digit kode" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-center tracking-widest"
                        >
                        <i class="fas fa-key absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <button 
                        type="submit" 
                        name="resend_otp" 
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                    >
                        Kirim Ulang OTP
                    </button>
                    <span class="text-sm text-gray-500" id="countdown">(60 detik)</span>
                </div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200"
                >
                    Verifikasi OTP
                    <i class="fas fa-check ml-2"></i>
                </button>
            </form>
            <?php endif; ?>

            <!-- New Password Form -->
            <?php if (isset($_SESSION['step']) && $_SESSION['step'] === 'password'): ?>
            <form method="POST" class="space-y-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <div class="password-container relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password baru" 
                            required
                            minlength="8"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition pr-10"
                        >
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Password minimal 8 karakter, mengandung huruf besar, kecil, dan angka
                    </p>
                </div>
                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <div class="password-container relative">
                        <input 
                            type="password" 
                            id="confirm-password" 
                            name="confirm-password" 
                            placeholder="Ulangi password baru" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition pr-10"
                        >
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('confirm-password')"></i>
                    </div>
                </div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200"
                >
                    Simpan Password Baru
                    <i class="fas fa-save ml-2"></i>
                </button>
            </form>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <a href="login.php" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke halaman login
                </a>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling;
            
            if (field.type === "password") {
                field.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        // OTP Countdown timer
        <?php if (isset($_SESSION['step']) && $_SESSION['step'] === 'otp'): ?>
        let timeLeft = 60;
        const countdownEl = document.getElementById('countdown');
        const countdown = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = `(${timeLeft} detik)`;
            
            if (timeLeft <= 0) {
                clearInterval(countdown);
                countdownEl.textContent = "";
            }
        }, 1000);
        <?php endif; ?>

        // Validate password match on form submission
        document.querySelectorAll('form').forEach(form => {
            if (form.querySelector('[name="confirm-password"]')) {
                form.addEventListener('submit', function(e) {
                    const password = this.querySelector('[name="password"]').value;
                    const confirmPassword = this.querySelector('[name="confirm-password"]').value;
                    
                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('Password dan konfirmasi password tidak sama!');
                    }
                });
            }
        });
    </script>
</body>

</html>