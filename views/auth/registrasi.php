<?php
include '../../controllers/auth/proses-registrasi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrasi — MBKM Polibatam</title>
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
    <!-- Background blurs -->
    <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-2xl mx-auto my-auto relative z-10 py-8">
        <!-- Container card -->
        <div class="glass-panel rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            <!-- Accent indicator line -->
            <div class="h-1.5 bg-gradient-to-r from-brand-500 to-indigo-600"></div>

            <div class="p-8 sm:p-10">
                <!-- Branding logo + title -->
                <div class="flex flex-col items-center mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center shadow-lg shadow-brand-500/25 mb-4">
                        <i class="fas fa-user-plus text-white text-lg"></i>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Daftar Akun Baru</h1>
                    <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wider">Silakan lengkapi formulir pendaftaran Anda</p>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="" id="regForm" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- NIM/NIK -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NIM / NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nim_nik" placeholder="Masukkan NIM atau NIK" required
                                value="<?= isset($_POST['nim_nik']) ? htmlspecialchars($_POST['nim_nik']) : '' ?>"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200">
                        </div>
                        <!-- Username -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username <span class="text-red-500">*</span></label>
                            <input type="text" name="username" placeholder="Buat username unik" required
                                value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200">
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="namaLengkap" placeholder="Masukkan nama lengkap sesuai identitas" required
                            value="<?= isset($_POST['namaLengkap']) ? htmlspecialchars($_POST['namaLengkap']) : '' ?>"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- No HP -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Handphone <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400"><i class="fas fa-phone text-sm"></i></span>
                                <input type="tel" name="phone" placeholder="08xxxxxxxxxx" required
                                    value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>"
                                    class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200">
                            </div>
                        </div>
                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400"><i class="fas fa-envelope text-sm"></i></span>
                                <input type="email" name="email" placeholder="email@example.com" required
                                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                                    class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200">
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="2" placeholder="Masukkan alamat lengkap tinggal saat ini" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200 resize-none"><?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '' ?></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Jurusan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jurusan <span class="text-red-500">*</span></label>
                            <select name="jurusan" id="jurusan" required onchange="updateProdi()"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200 bg-[image:none] cursor-pointer">
                                <option value="" disabled selected>Pilih Jurusan Anda</option>
                                <?php while ($j = mysqli_fetch_assoc($result_all_jurusan)): ?>
                                    <option value="<?= $j['id_jurusan'] ?>"
                                        <?= (isset($_POST['jurusan']) && $_POST['jurusan'] == $j['id_jurusan']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($j['nama_jurusan']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <!-- Prodi -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Program Studi <span class="text-red-500">*</span></label>
                            <select name="prodi" id="prodi" required disabled
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200 disabled:bg-slate-100 disabled:text-slate-400 cursor-pointer">
                                <option value="" disabled selected>Pilih Jurusan Terlebih Dahulu</option>
                                <?php if (isset($_POST['jurusan']) && !empty($_POST['jurusan'])): ?>
                                    <?php foreach ($prodi_options[$_POST['jurusan']] as $p): ?>
                                        <option value="<?= $p['id_prodi'] ?>"
                                            <?= (isset($_POST['prodi']) && $_POST['prodi'] == $p['id_prodi']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['nama_prodi']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required
                                    class="w-full pl-4 pr-11 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200">
                                <button type="button" onclick="togglePwd('password','icon1')" tabindex="-1"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition">
                                    <i class="fas fa-eye text-sm" id="icon1"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="confirm-password" id="confirm-password" placeholder="Ulangi password Anda" required
                                    class="w-full pl-4 pr-11 py-2.5 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 bg-white/70 transition-all duration-200">
                                <button type="button" onclick="togglePwd('confirm-password','icon2')" tabindex="-1"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition">
                                    <i class="fas fa-eye text-sm" id="icon2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="submit"
                        class="w-full bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-bold py-3 px-4 rounded-2xl text-sm shadow-lg shadow-brand-500/20 hover:shadow-brand-500/25 transition duration-200 flex items-center justify-center gap-2 transform hover:-translate-y-0.5 mt-2">
                        <i class="fas fa-user-plus text-sm"></i> Daftar Akun Baru
                    </button>
                </form>

                <!-- Existing Account Footer -->
                <div class="text-center mt-6 pt-5 border-t border-slate-200/50">
                    <p class="text-sm text-slate-400 font-semibold">
                        Sudah terdaftar?
                        <a href="login.php" class="text-brand-600 font-bold hover:underline ml-1">Masuk Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Small copyleft banner at bottom -->
    <div class="text-center relative z-10 mt-4">
        <p class="text-xs font-semibold text-slate-400">
            &copy; <?= date('Y') ?> Politeknik Negeri Batam. All Rights Reserved.
        </p>
    </div>

    <script>
        const prodiData = <?= $prodi_options_json ?? '{}' ?>;

        function togglePwd(fieldId, iconId) {
            const f = document.getElementById(fieldId);
            const i = document.getElementById(iconId);
            if (f.type === 'password') { 
                f.type = 'text'; 
                i.classList.replace('fa-eye','fa-eye-slash'); 
            } else { 
                f.type = 'password'; 
                i.classList.replace('fa-eye-slash','fa-eye'); 
            }
        }

        function updateProdi() {
            const jId = document.getElementById('jurusan').value;
            const pSel = document.getElementById('prodi');
            pSel.innerHTML = '<option value="" disabled selected>Pilih Program Studi</option>';
            pSel.disabled = !jId;
            if (jId && prodiData[jId]) {
                prodiData[jId].forEach(p => {
                    const o = document.createElement('option');
                    o.value = p.id_prodi; o.textContent = p.nama_prodi;
                    pSel.appendChild(o);
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('jurusan').value) updateProdi();
        });

        document.getElementById('regForm').addEventListener('submit', function(e) {
            const pwd = document.getElementById('password').value;
            const cpwd = document.getElementById('confirm-password').value;
            if (pwd !== cpwd) {
                e.preventDefault();
                Swal.fire({ 
                    title: 'Password Tidak Cocok', 
                    text: 'Password dan konfirmasi password harus sama.', 
                    icon: 'error', 
                    confirmButtonColor: '#4f46e5',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });
                return;
            }
            if (pwd.length < 8) {
                e.preventDefault();
                Swal.fire({ 
                    title: 'Password Terlalu Pendek', 
                    text: 'Password minimal harus 8 karakter.', 
                    icon: 'warning', 
                    confirmButtonColor: '#4f46e5',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });
            }
        });

        <?php if (!empty($error_messages)): ?>
        Swal.fire({
            title: 'Registrasi Gagal',
            html: '<ul class="text-left text-xs space-y-1"><?php foreach ($error_messages as $e): ?><li>• <?= addslashes(htmlspecialchars($e)) ?></li><?php endforeach; ?></ul>',
            icon: 'error',
            confirmButtonColor: '#4f46e5',
            customClass: {
                popup: 'rounded-3xl'
            }
        });
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
        Swal.fire({
            title: 'Registrasi Berhasil!',
            text: '<?= addslashes(htmlspecialchars($success_message)) ?>',
            icon: 'success',
            confirmButtonColor: '#4f46e5',
            customClass: {
                popup: 'rounded-3xl'
            }
        }).then(() => { window.location.href = 'login.php'; });
        <?php endif; ?>
    </script>
</body>
</html>
