<?php
include '../../controllers/auth/proses-login.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login — MBKM Polibatam</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#e0e7ff',
                            200: '#ddd6fe',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex flex-col justify-between p-6 relative overflow-hidden">
    <!-- Glowing background blurs -->
    <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md mx-auto my-auto relative z-10">
        <!-- Card container -->
        <div class="glass-panel rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            <!-- Accent indicator line at the top -->
            <div class="h-1.5 bg-gradient-to-r from-brand-500 to-indigo-600"></div>

            <div class="p-8 sm:p-10">
                <!-- Branding logo + subtitle -->
                <div class="flex flex-col items-center mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center shadow-lg shadow-brand-500/25 mb-4">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Selamat Datang</h1>
                    <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wider">Sistem Informasi MBKM Polibatam</p>
                </div>

                <!-- Form block -->
                <form method="POST" action="" id="loginForm" autocomplete="off" class="space-y-5">
                    <!-- Username Input -->
                    <div>
                        <label for="username" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fas fa-user text-sm"></i>
                            </span>
                            <input type="text" id="username" name="username"
                                placeholder="Masukkan username Anda"
                                value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                                required
                                class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Password</label>
                            <a href="lupa-password.php" class="text-xs font-bold text-brand-600 hover:text-brand-700 hover:underline">
                                Lupa Password?
                            </a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input type="password" id="password" name="password"
                                placeholder="Masukkan password Anda"
                                required
                                class="w-full pl-11 pr-11 py-3 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200">
                            <button type="button" onclick="togglePwd()" tabindex="-1"
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition">
                                <i class="fas fa-eye text-sm" id="pwdIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="login"
                        class="w-full bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-bold py-3 px-4 rounded-2xl text-sm shadow-lg shadow-brand-500/20 hover:shadow-brand-500/25 transition duration-200 flex items-center justify-center gap-2 transform hover:-translate-y-0.5 mt-2">
                        <i class="fas fa-right-to-bracket text-sm"></i> Masuk Sekarang
                    </button>
                </form>

                <!-- Registration footer link -->
                <div class="text-center mt-8 pt-6 border-t border-slate-200/50">
                    <p class="text-sm text-slate-400 font-semibold">
                        Belum terdaftar?
                        <a href="registrasi.php" class="text-brand-600 font-bold hover:underline ml-1">Buat Akun Baru</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Small copyleft banner at the very bottom -->
    <div class="text-center relative z-10 mt-6">
        <p class="text-xs font-semibold text-slate-400">
            &copy; <?= date('Y') ?> Politeknik Negeri Batam. All Rights Reserved.
        </p>
    </div>

    <script>
        function togglePwd() {
            const f = document.getElementById('password');
            const i = document.getElementById('pwdIcon');
            if (f.type === 'password') {
                f.type = 'text';
                i.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                f.type = 'password';
                i.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const u = document.getElementById('username').value.trim();
            const p = document.getElementById('password').value.trim();
            if (!u || !p) {
                e.preventDefault();
                Swal.fire({ 
                    title: 'Perhatian!', 
                    text: 'Silakan isi username dan password Anda.', 
                    icon: 'warning', 
                    confirmButtonColor: '#4f46e5',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });
            }
        });

        <?php if (!empty($error_message) && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        Swal.fire({
            title: 'Masuk Gagal',
            text: '<?= addslashes(htmlspecialchars($error_message)) ?>',
            icon: 'error',
            confirmButtonColor: '#4f46e5',
            customClass: {
                popup: 'rounded-3xl'
            }
        });
        <?php endif; ?>

        <?php if ($login_success ?? false): ?>
        Swal.fire({
            title: 'Sesi Berhasil!',
            text: 'Mengalihkan Anda ke halaman dashboard...',
            icon: 'success',
            showConfirmButton: false,
            timer: 1200,
            timerProgressBar: true,
            customClass: {
                popup: 'rounded-3xl'
            }
        }).then(() => { window.location.href = '<?= $redirect_url ?>'; });
        <?php endif; ?>
    </script>
</body>
</html>
