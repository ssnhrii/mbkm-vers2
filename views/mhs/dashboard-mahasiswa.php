<?php
// Ensure user is logged in and has student role
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Mahasiswa') {
    header('Location: ../../auth/login.php');
    exit();
}

// Database connection
require_once '../../controllers/koneksi.php';

// Get student data
$username = $_SESSION['username'];
$query = "SELECT u.*, p.nama_prodi, j.nama_jurusan
          FROM users u 
          LEFT JOIN prodi p ON u.id_prodi = p.id_prodi 
          LEFT JOIN jurusan j ON u.id_jurusan = j.id_jurusan
          WHERE u.username = ? AND u.role = 'Mahasiswa'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: ../../auth/login.php');
    exit();
}

$data = $result->fetch_assoc();
$prodi = $data['nama_prodi'] ?? "Belum ditentukan";
$jurusan = $data['nama_jurusan'] ?? "Belum ditentukan";


// Get academic data
$academic_query = "SELECT status_akademik, semester, ipk FROM akademik WHERE nim_nik = ?";
$academic_stmt = $conn->prepare($academic_query);
$academic_stmt->bind_param("s", $data['nim_nik']);
$academic_stmt->execute();
$academic_result = $academic_stmt->get_result();
$academic_data = $academic_result->fetch_assoc() ?? [];

$status_akademik = $academic_data['status_akademik'] ?? 'Aktif';
$semester = $academic_data['semester'] ?? 'Belum ada data';
$gpa = $academic_data['ipk'] ?? '0.00';

// Get pending submissions count
$pending_query = "SELECT COUNT(*) as count FROM pengajuan 
                 WHERE nim_nik = ? AND status = 'Menunggu'";
$pending_stmt = $conn->prepare($pending_query);
$pending_stmt->bind_param("s", $data['nim_nik']);
$pending_stmt->execute();
$pending_result = $pending_stmt->get_result();
$pending_count = $pending_result->fetch_assoc()['count'] ?? 0;

// Get current courses count
$courses_query = "SELECT COUNT(*) as count FROM krs 
                 WHERE nim_nik = ? AND semester = ?";
$courses_stmt = $conn->prepare($courses_query);
$courses_stmt->bind_param("ss", $data['nim_nik'], $semester);
$courses_stmt->execute();
$courses_result = $courses_stmt->get_result();
$courses_count = $courses_result->fetch_assoc()['count'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Dashboard Mahasiswa - SIS Polibatam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }

        .gpa-circle {
            background: conic-gradient(#4f46e5 0% <?= ($gpa / 4) * 100 ?>%, #e5e7eb <?= ($gpa / 4) * 100 ?>% 100%)}

        [data-tooltip]:hover::after {
            opacity: 1;
            visibility: visible;
            bottom: calc(100% + 5px);
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="sidebar w-64 bg-blue-800 text-white flex flex-col flex-shrink-0">
        <div class="p-4 flex items-center justify-center border-b border-blue-700">
            <img src="../assets/img/Logo_MBKM.png" alt="Logo" class="h-12" />
        </div>
        <nav class="flex-1 overflow-y-auto py-4">
            <a href="dashboard-mahasiswa.php" class="flex items-center px-6 py-3 text-sm font-medium hover:bg-blue-700 <?= $active_page === 'dashboard' ? 'bg-blue-700' : '' ?>">
                <i class="fas fa-home-alt w-6 text-center mr-3"></i>
                <span>DASHBOARD</span>
            </a>
            <a href="formulir.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>" class="flex items-center px-6 py-3 text-sm font-medium hover:bg-blue-700 <?= $active_page === 'pengajuan' ? 'bg-blue-700' : '' ?>">
                <i class="fas fa-file-alt w-6 text-center mr-3"></i>
                <span>PENGAJUAN</span>
            </a>
            <a href="rekap-pengajuan.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>" class="flex items-center px-6 py-3 text-sm font-medium hover:bg-blue-700 <?= $active_page === 'rekap' ? 'bg-blue-700' : '' ?>">
                <i class="fas fa-history w-6 text-center mr-3"></i>
                <span>REKAP PENGAJUAN</span>
            </a>
            <a href="jadwal-kuliah.php" class="flex items-center px-6 py-3 text-sm font-medium hover:bg-blue-700 <?= $active_page === 'jadwal' ? 'bg-blue-700' : '' ?>">
                <i class="fas fa-calendar-alt w-6 text-center mr-3"></i>
                <span>JADWAL KULIAH</span>
            </a>
            <a href="nilai.php" class="flex items-center px-6 py-3 text-sm font-medium hover:bg-blue-700 <?= $active_page === 'nilai' ? 'bg-blue-700' : '' ?>">
                <i class="fas fa-chart-bar w-6 text-center mr-3"></i>
                <span>NILAI AKADEMIK</span>
            </a>
        </nav>
        <div class="p-4 border-t border-blue-700">
            <div class="text-xs text-blue-200">
                © <?= date('Y') ?> Polibatam<br>
                Student Information System
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between px-6 py-4">
                <h1 class="text-xl font-semibold text-gray-800">
                    <?= $page_title ?? 'Selamat Datang di Sistem Informasi dan Layanan Mahasiswa Polibatam' ?>
                </h1>
                <div class="flex items-center space-x-4">
                    <!-- Notification -->
                    <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                    </button>

                    <!-- User Profile -->
                    <!-- Di bagian header (ganti bagian user profile) -->
                    <div class="relative">
                        <button id="userDropdownButton" class="flex items-center space-x-2 focus:outline-none">
                            <div class="relative">
                                <img src="../assets/img/icon.jpg" alt="Profile" class="h-8 w-8 rounded-full object-cover">
                                <span class="absolute bottom-0 right-0 h-2 w-2 rounded-full bg-green-500 border border-white"></span>
                            </div>
                            <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($data['nama_lengkap']) ?></span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                            <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <a href="change-password.php?data=<?= htmlspecialchars($data['nim_nik']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-key mr-2"></i> Change Password
                            </a>
                            <div class="border-t border-gray-200"></div>
                            <a href="../function/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            <!-- Welcome Section -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Halo, <?= htmlspecialchars($data['nama_lengkap']) ?>!</h2>
                <p class="text-gray-600">Anda dapat menikmati berbagai layanan akademik secara online</p>
            </div>

            <!-- Profile Completion Alert -->
            <?php if (empty($data['alamat']) || empty($data['phone'])): ?>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-md flex justify-between items-start">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm text-yellow-700">
                                <strong>Lengkapi Profil Anda!</strong> Silahkan update data diri di menu
                                <a href="profile.php" class="text-yellow-600 font-medium hover:underline">PROFILE</a>
                                sebelum melakukan pengajuan.
                            </p>
                        </div>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-yellow-500 hover:text-yellow-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Academic Status -->
                <div class="bg-white rounded-lg shadow p-6 flex items-center hover:shadow-md transition">
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                        <i class="fas fa-user-graduate text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status Akademik</p>
                        <p class="text-lg font-semibold <?= $status_akademik === 'Aktif' ? 'text-green-600' : 'text-red-600' ?>">
                            <?= htmlspecialchars($status_akademik) ?>
                        </p>
                    </div>
                </div>

                <!-- Semester -->
                <div class="bg-white rounded-lg shadow p-6 flex items-center hover:shadow-md transition">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-calendar-alt text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Semester</p>
                        <p class="text-lg font-semibold"><?= htmlspecialchars($semester) ?></p>
                    </div>
                </div>

                <!-- Pending Submissions -->
                <div class="bg-white rounded-lg shadow p-6 flex items-center hover:shadow-md transition">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-clock text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pengajuan Pending</p>
                        <p class="text-lg font-semibold"><?= $pending_count ?></p>
                    </div>
                </div>

                <!-- Current Courses -->
                <div class="bg-white rounded-lg shadow p-6 flex items-center hover:shadow-md transition">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <i class="fas fa-book text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Mata Kuliah</p>
                        <p class="text-lg font-semibold"><?= $courses_count ?></p>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Student Profile Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden lg:col-span-1 hover:shadow-md transition">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Profil Mahasiswa</h3>
                        <a href="profile.php" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col items-center mb-6">
                            <div class="relative mb-4">
                                <img src="<?= !empty($data['foto']) ? htmlspecialchars($data['foto']) : '../assets/img/default-avatar.jpg' ?>"
                                    alt="Foto Profil"
                                    class="h-24 w-24 rounded-full object-cover border-4 border-white shadow">
                                <button onclick="document.getElementById('upload-photo').click()"
                                    class="absolute bottom-0 right-0 bg-indigo-600 text-white p-1 rounded-full hover:bg-indigo-700"
                                    data-tooltip="Ubah Foto">
                                    <i class="fas fa-camera text-xs"></i>
                                </button>
                                <input type="file" id="upload-photo" class="hidden" accept="image/*">
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 text-center"><?= htmlspecialchars($data['nama_lengkap']) ?></h4>
                            <p class="text-sm text-gray-500"><?= htmlspecialchars($data['nim_nik']) ?></p>
                            <!-- Tambahan badge status akademik -->
                            <span class="mt-2 px-2 py-1 text-xs font-semibold rounded-full <?= $status_akademik === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= htmlspecialchars($status_akademik) ?>
                            </span>
                        </div>

                        <div class="space-y-4">
                            <!-- Tambahan informasi NIM dengan icon -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-gray-400 mr-3">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</p>
                                    <p class="text-sm"><?= htmlspecialchars($data['nim_nik']) ?></p>
                                </div>
                            </div>

                            <!-- Tambahan informasi Kelas dengan icon -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-gray-400 mr-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</p>
                                    <p class="text-sm"><?= !empty($data['kelas']) ? htmlspecialchars($data['kelas']) : 'Belum ditentukan' ?></p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-gray-400 mr-3">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</p>
                                    <p class="text-sm"><?= htmlspecialchars($jurusan) ?></p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-gray-400 mr-3">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</p>
                                    <p class="text-sm"><?= htmlspecialchars($prodi) ?></p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-gray-400 mr-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</p>
                                    <p class="text-sm"><?= htmlspecialchars($data['email']) ?></p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-gray-400 mr-3">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP</p>
                                    <p class="text-sm"><?= !empty($data['phone']) ? htmlspecialchars($data['phone']) : '<span class="text-red-500">Belum diisi</span>' ?></p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-gray-400 mr-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</p>
                                    <p class="text-sm"><?= !empty($data['alamat']) ? htmlspecialchars($data['alamat']) : '<span class="text-red-500">Belum diisi</span>' ?></p>
                                </div>
                            </div>

                            <!-- Tambahan informasi Dosen Wali -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-gray-400 mr-3">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Dosen Wali</p>
                                    <p class="text-sm"><?= !empty($data['dosen_wali']) ? htmlspecialchars($data['dosen_wali']) : 'Belum ditentukan' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Performance -->
                <div class="bg-white rounded-lg shadow overflow-hidden lg:col-span-2 hover:shadow-md transition">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Prestasi Akademik</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <!-- GPA Visualization -->
                            <div class="flex flex-col items-center">
                                <div class="relative w-32 h-32 mb-4">
                                    <svg class="w-full h-full" viewBox="0 0 36 36">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                            fill="none" stroke="#e5e7eb" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                            fill="none" stroke="#4f46e5" stroke-width="3"
                                            stroke-dasharray="<?= ($gpa / 4) * 100 ?> 100" />
                                        <text x="18" y="20.5" text-anchor="middle" font-size="10" fill="#4f46e5" font-weight="bold"><?= $gpa ?></text>
                                        <text x="18" y="25" text-anchor="middle" font-size="6" fill="#6b7280">IPK</text>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-700">Indeks Prestasi Kumulatif</p>
                            </div>

                            <!-- Semester Details -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Detail Semester</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-xs text-gray-500">Semester Aktif</p>
                                        <p class="text-sm font-medium"><?= htmlspecialchars($semester) ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">SKS Diambil</p>
                                        <p class="text-sm font-medium">18 SKS</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Status</p>
                                        <p class="text-sm font-medium <?= $status_akademik === 'Aktif' ? 'text-green-600' : 'text-red-600' ?>">
                                            <?= htmlspecialchars($status_akademik) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Achievement -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Pencapaian</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-xs text-gray-500">Mata Kuliah Lulus</p>
                                        <p class="text-sm font-medium">42</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">SKS Total</p>
                                        <p class="text-sm font-medium">120 SKS</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Predikat</p>
                                        <p class="text-sm font-medium">Sangat Memuaskan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- GPA Progress Chart -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Perkembangan IPK per Semester</h4>
                            <canvas id="academicChart" height="150"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-lg shadow overflow-hidden lg:col-span-1 hover:shadow-md transition">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Aktivitas Terkini</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Activity 1 -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full text-blue-600 mr-3">
                                    <i class="fas fa-file-alt text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Pengajuan surat keterangan aktif diproses</p>
                                    <p class="text-xs text-gray-500">2 hari yang lalu</p>
                                </div>
                            </div>

                            <!-- Activity 2 -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-green-100 p-2 rounded-full text-green-600 mr-3">
                                    <i class="fas fa-check-circle text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Pengajuan surat permohonan cuti disetujui</p>
                                    <p class="text-xs text-gray-500">5 hari yang lalu</p>
                                </div>
                            </div>

                            <!-- Activity 3 -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-purple-100 p-2 rounded-full text-purple-600 mr-3">
                                    <i class="fas fa-book text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Anda terdaftar dalam mata kuliah Basis Data</p>
                                    <p class="text-xs text-gray-500">1 minggu yang lalu</p>
                                </div>
                            </div>

                            <!-- Activity 4 -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-yellow-100 p-2 rounded-full text-yellow-600 mr-3">
                                    <i class="fas fa-exclamation-circle text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Pembayaran UKT semester ini belum lunas</p>
                                    <p class="text-xs text-gray-500">2 minggu yang lalu</p>
                                </div>
                            </div>
                        </div>

                        <a href="rekap-pengajuan.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>"
                            class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Lihat semua aktivitas
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Actions & Courses -->
                <div class="bg-white rounded-lg shadow overflow-hidden lg:col-span-2 hover:shadow-md transition">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Aksi Cepat & Mata Kuliah</h3>
                    </div>
                    <div class="p-6">
                        <!-- Quick Actions -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <a href="formulir.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>"
                                class="bg-gray-50 hover:bg-gray-100 rounded-lg p-4 flex flex-col items-center text-center transition">
                                <div class="bg-indigo-100 p-3 rounded-full text-indigo-600 mb-2">
                                    <i class="fas fa-file-upload"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Ajukan Surat</span>
                            </a>

                            <a href="jadwal-kuliah.php"
                                class="bg-gray-50 hover:bg-gray-100 rounded-lg p-4 flex flex-col items-center text-center transition">
                                <div class="bg-blue-100 p-3 rounded-full text-blue-600 mb-2">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Jadwal Kuliah</span>
                            </a>

                            <a href="nilai.php"
                                class="bg-gray-50 hover:bg-gray-100 rounded-lg p-4 flex flex-col items-center text-center transition">
                                <div class="bg-green-100 p-3 rounded-full text-green-600 mb-2">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Lihat Nilai</span>
                            </a>

                            <a href="rekap-pengajuan.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>"
                                class="bg-gray-50 hover:bg-gray-100 rounded-lg p-4 flex flex-col items-center text-center transition">
                                <div class="bg-purple-100 p-3 rounded-full text-purple-600 mb-2">
                                    <i class="fas fa-history"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Riwayat Pengajuan</span>
                            </a>
                        </div>

                        <!-- Current Courses -->
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Mata Kuliah Semester Ini</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Kuliah</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKS</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosen</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MK001</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Basis Data</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">A</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dr. Ahmad S.T., M.Kom.</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MK002</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Pemrograman Web</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">B</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dr. Budi S.Kom., M.T.</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MK003</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sistem Operasi</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">A</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dr. Citra M.Kom.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        <!-- Di bagian script (tambahkan sebelum penutup </body>) --
        // Dropdown functionality
        const userDropdownButton = document.getElementById('userDropdownButton');
        const userDropdown = document.getElementById('userDropdown');

        userDropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target) && e.target !== userDropdownButton) {
                userDropdown.classList.add('hidden');
            }
        });

        // Prevent dropdown from closing when clicking inside it
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Academic chart
        const academicCtx = document.getElementById('academicChart').getContext('2d');
        const academicChart = new Chart(academicCtx, {
            type: 'line',
            data: {
                labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4', 'Sem 5', 'Sem 6'],
                datasets: [{
                    label: 'IPK',
                    data: [3.2, 3.4, 3.5, 3.6, 3.7, <?= $gpa ?>],
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.05)',
                    tension: 0.3,
                    fill: true,
                    borderWidth: 2,
                    pointBackgroundColor: '#4f46e5',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        min: 2.0,
                        max: 4.0,
                        ticks: {
                            stepSize: 0.5
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'nearest'
                }
            }
        });

        // Handle photo upload
        document.getElementById('upload-photo').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (!file.type.match('image.*')) {
                    alert('Hanya file gambar yang diperbolehkan');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.relative.mb-4 img').src = e.target.result;
                    // Here you would typically send the image to the server via AJAX
                    alert('Foto berhasil diubah! Jangan lupa simpan perubahan.');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>