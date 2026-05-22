<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBKM — Merdeka Belajar Kampus Merdeka</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
                        },
                        accent: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#10b981',
                            600: '#059669',
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
            background-color: #f8fafc;
            overflow-x: hidden;
        }
        .hero-gradient {
            background: radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.15) 0%, rgba(168, 85, 247, 0.05) 90.2%);
        }
        .card-glow:hover {
            box-shadow: 0 20px 40px -15px rgba(99, 102, 241, 0.12), 0 15px 25px -10px rgba(168, 85, 247, 0.08);
            transform: translateY(-6px);
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="text-slate-800 selection:bg-brand-500 selection:text-white">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center shadow-lg shadow-brand-500/20">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-brand-600 to-indigo-600 bg-clip-text text-transparent">MBKM Polibatam</span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#home" class="text-slate-600 hover:text-brand-600 font-semibold transition text-sm">Beranda</a>
                <a href="#about" class="text-slate-600 hover:text-brand-600 font-semibold transition text-sm">Tentang</a>
                <a href="#programs" class="text-slate-600 hover:text-brand-600 font-semibold transition text-sm">Program</a>
                <a href="#testimoni" class="text-slate-600 hover:text-brand-600 font-semibold transition text-sm">Testimoni</a>
                <a href="#faq" class="text-slate-600 hover:text-brand-600 font-semibold transition text-sm">FAQ</a>
                <a href="./views/auth/login.php" class="bg-brand-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-brand-700 shadow-lg shadow-brand-500/20 transition-all duration-300 transform hover:-translate-y-0.5 text-sm">
                    <i class="fas fa-right-to-bracket mr-2"></i>Login
                </a>
            </div>
            <button class="md:hidden text-slate-600 hover:text-brand-600 transition focus:outline-none" onclick="toggleMobileMenu()">
                <i class="fas fa-bars text-2xl" id="menuBtnIcon"></i>
            </button>
        </div>
        
        <!-- Mobile Dropdown Menu -->
        <div class="hidden md:hidden border-t border-slate-100 bg-white" id="mobileMenu">
            <div class="flex flex-col px-6 py-4 space-y-4">
                <a href="#home" class="text-slate-600 hover:text-brand-600 font-semibold text-sm transition" onclick="toggleMobileMenu()">Beranda</a>
                <a href="#about" class="text-slate-600 hover:text-brand-600 font-semibold text-sm transition" onclick="toggleMobileMenu()">Tentang</a>
                <a href="#programs" class="text-slate-600 hover:text-brand-600 font-semibold text-sm transition" onclick="toggleMobileMenu()">Program</a>
                <a href="#testimoni" class="text-slate-600 hover:text-brand-600 font-semibold text-sm transition" onclick="toggleMobileMenu()">Testimoni</a>
                <a href="#faq" class="text-slate-600 hover:text-brand-600 font-semibold text-sm transition" onclick="toggleMobileMenu()">FAQ</a>
                <a href="./views/auth/login.php" class="bg-brand-600 text-white px-5 py-3 rounded-xl font-bold hover:bg-brand-700 transition w-full text-center text-sm shadow-md">
                    <i class="fas fa-right-to-bracket mr-2"></i>Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-gradient relative pt-10 pb-20 overflow-hidden">
        <!-- Glowing background blobs -->
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-brand-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-6 relative z-10 flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2 mb-8 lg:mb-0 animate__animated animate__fadeInLeft">
                <div class="inline-flex items-center gap-2 bg-brand-50 border border-brand-200 text-brand-700 px-3.5 py-1.5 rounded-full text-xs font-bold mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-ping"></span>
                    Program MBKM 2026 Aktif
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 leading-tight mb-6">
                    Merdeka Belajar <br>
                    <span class="bg-gradient-to-r from-brand-600 to-indigo-600 bg-clip-text text-transparent">Kampus Merdeka</span>
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed mb-8 max-w-xl">
                    Kembangkan potensimu secara optimal dengan belajar langsung di dunia nyata. Ikuti berbagai program pilihan di luar perkuliahan formal bersama ratusan mitra industri terkemuka.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#programs" class="bg-brand-600 text-white px-8 py-4 rounded-2xl font-bold text-center hover:bg-brand-700 shadow-xl shadow-brand-500/25 transition-all duration-300 transform hover:-translate-y-0.5">
                        Eksplorasi Program <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                    <a href="#about" class="bg-white/80 border border-slate-200 text-slate-700 px-8 py-4 rounded-2xl font-bold text-center hover:bg-slate-50 transition-all duration-300">
                        Pelajari Selengkapnya
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2 animate__animated animate__fadeInRight flex justify-center">
                <div class="relative w-full max-w-lg">
                    <!-- Elegant visual element wrapper -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-brand-500 to-indigo-600 rounded-3xl blur-lg opacity-30"></div>
                    <div class="relative bg-white border border-slate-100 rounded-3xl p-6 shadow-2xl">
                        <img src="https://illustrations.popsy.co/amber/digital-nomad.svg" alt="Ilustrasi MBKM" class="w-full h-auto drop-shadow-md">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About MBKM -->
    <section id="about" class="py-24 bg-white relative">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-20">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Apa Itu MBKM?</h2>
                <div class="w-16 h-1.5 bg-gradient-to-r from-brand-500 to-indigo-600 rounded-full mx-auto"></div>
                <p class="text-slate-500 mt-4 text-base">Kebijakan inovatif untuk mengantarkan mahasiswa menuju masa depan yang gemilang.</p>
            </div>
            
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 animate__animated animate__fadeInLeft">
                    <div class="relative p-2 bg-gradient-to-tr from-brand-50 to-indigo-50 border border-slate-100 rounded-3xl shadow-lg">
                        <img src="assets/img/ilustrasi.jpeg" alt="Ilustrasi MBKM" class="w-full rounded-2xl object-cover shadow-inner" onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop'">
                    </div>
                </div>
                <div class="lg:w-1/2 animate__animated animate__fadeInRight space-y-6">
                    <p class="text-lg text-slate-600 leading-relaxed">
                        <span class="font-bold text-brand-600">Merdeka Belajar Kampus Merdeka (MBKM)</span> adalah kebijakan revolusioner Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi yang didesain khusus agar mahasiswa menguasai berbagai keilmuan yang berguna untuk memasuki dunia kerja.
                    </p>
                    <p class="text-base text-slate-500 leading-relaxed">
                        Program ini memberikan hak penuh bagi mahasiswa untuk mengambil mata kuliah di luar program studi sebanyak <span class="font-bold text-slate-700">3 semester (setara 60 SKS)</span>, baik di dalam maupun di luar Politeknik Negeri Batam.
                    </p>
                    
                    <div class="bg-slate-50 p-6 rounded-2xl border-l-4 border-brand-500 space-y-3">
                        <h3 class="font-extrabold text-slate-800 text-base">Tujuan Utama Program:</h3>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-slate-600 text-sm font-medium">
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-brand-500"></i> Kompetensi Lulusan Tinggi</li>
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-brand-500"></i> Pengalaman Kerja Nyata</li>
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-brand-500"></i> Inovasi & Kolaborasi</li>
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-brand-500"></i> Kemitraan Dunia Industri</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program MBKM -->
    <section id="programs" class="py-24 bg-slate-50 relative">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-20">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Program Pilihan MBKM</h2>
                <div class="w-16 h-1.5 bg-gradient-to-r from-brand-500 to-indigo-600 rounded-full mx-auto"></div>
                <p class="text-slate-500 mt-4 text-base">Berbagai kategori kegiatan yang siap mengakomodasi minat bakat dan masa depan karirmu.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Program 1 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm transition-all duration-300 card-glow flex flex-col justify-between">
                    <div>
                        <div class="bg-brand-50 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <i class="fas fa-briefcase text-brand-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Magang / Praktik Kerja</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Rasakan pengalaman kerja profesional langsung di perusahaan terkemuka untuk mengasah hard & soft skill.</p>
                    </div>
                    <a href="./views/auth/login.php" class="text-brand-600 font-bold flex items-center hover:text-brand-800 text-sm group transition">
                        Daftar Program <i class="fas fa-chevron-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                <!-- Program 2 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm transition-all duration-300 card-glow flex flex-col justify-between">
                    <div>
                        <div class="bg-indigo-50 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <i class="fas fa-earth-americas text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Pertukaran Mahasiswa</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Rasakan atmosfer akademik berbeda dengan berkuliah di perguruan tinggi mitra terbaik nasional maupun internasional.</p>
                    </div>
                    <a href="./views/auth/login.php" class="text-brand-600 font-bold flex items-center hover:text-brand-800 text-sm group transition">
                        Daftar Program <i class="fas fa-chevron-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                <!-- Program 3 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm transition-all duration-300 card-glow flex flex-col justify-between">
                    <div>
                        <div class="bg-emerald-50 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <i class="fas fa-hand-holding-hand text-emerald-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Proyek Kemanusiaan</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Salurkan kepedulian sosialmu dengan berkontribusi langsung pada penanganan isu-isu kemanusiaan global.</p>
                    </div>
                    <a href="./views/auth/login.php" class="text-brand-600 font-bold flex items-center hover:text-brand-800 text-sm group transition">
                        Daftar Program <i class="fas fa-chevron-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                <!-- Program 4 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm transition-all duration-300 card-glow flex flex-col justify-between">
                    <div>
                        <div class="bg-amber-50 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <i class="fas fa-magnifying-glass text-amber-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Riset / Penelitian</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Lakukan kajian ilmiah mendalam bersama para pakar di bidang riset untuk menjawab tantangan masa kini.</p>
                    </div>
                    <a href="./views/auth/login.php" class="text-brand-600 font-bold flex items-center hover:text-brand-800 text-sm group transition">
                        Daftar Program <i class="fas fa-chevron-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                <!-- Program 5 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm transition-all duration-300 card-glow flex flex-col justify-between">
                    <div>
                        <div class="bg-red-50 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <i class="fas fa-chalkboard-user text-red-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Kampus Mengajar</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Abadikan dirimu dalam peningkatan mutu literasi dan numerasi siswa sekolah dasar hingga menengah.</p>
                    </div>
                    <a href="./views/auth/login.php" class="text-brand-600 font-bold flex items-center hover:text-brand-800 text-sm group transition">
                        Daftar Program <i class="fas fa-chevron-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                <!-- Program 6 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm transition-all duration-300 card-glow flex flex-col justify-between">
                    <div>
                        <div class="bg-cyan-50 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <i class="fas fa-chart-line text-cyan-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Wirausaha Mandiri</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Rancang model bisnismu sendiri di bawah asuhan mentor kompeten untuk menjadi wirausahawan masa depan.</p>
                    </div>
                    <a href="./views/auth/login.php" class="text-brand-600 font-bold flex items-center hover:text-brand-800 text-sm group transition">
                        Daftar Program <i class="fas fa-chevron-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section id="testimoni" class="py-24 bg-white relative">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-20">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Kisah Sukses Mahasiswa</h2>
                <div class="w-16 h-1.5 bg-gradient-to-r from-brand-500 to-indigo-600 rounded-full mx-auto"></div>
                <p class="text-slate-500 mt-4 text-base">Inspirasi nyata dari mahasiswa Politeknik Negeri Batam yang telah mengubah masa depan mereka.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimoni 1 -->
                <div class="bg-slate-50 rounded-3xl p-8 shadow-sm flex flex-col justify-between border border-slate-100 hover:shadow-md transition">
                    <div>
                        <div class="flex text-amber-400 gap-1 mb-5">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-slate-600 italic text-sm leading-relaxed mb-6">
                            "Melalui Magang MBKM di PT. Telkom Indonesia, saya berkesempatan menangani sistem berskala industri. Ini jembatan karir terbaik bagi mahasiswa."
                        </p>
                    </div>
                    <div class="flex items-center gap-4 border-t border-slate-200/60 pt-4">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Testimoni" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h4 class="font-extrabold text-slate-800 text-sm">Dewi Anggraeni</h4>
                            <p class="text-slate-500 text-xs font-semibold">Magang Industri — PT. Telkom</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimoni 2 -->
                <div class="bg-slate-50 rounded-3xl p-8 shadow-sm flex flex-col justify-between border border-slate-100 hover:shadow-md transition">
                    <div>
                        <div class="flex text-amber-400 gap-1 mb-5">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-slate-600 italic text-sm leading-relaxed mb-6">
                            "Pertukaran pelajar ke Malaysia membuat saya memahami keragaman kultur dunia luar dan melatih cara berkomunikasi secara internasional."
                        </p>
                    </div>
                    <div class="flex items-center gap-4 border-t border-slate-200/60 pt-4">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Testimoni" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h4 class="font-extrabold text-slate-800 text-sm">Rizky Pratama</h4>
                            <p class="text-slate-500 text-xs font-semibold">IISMA Exchange — Malaysia</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimoni 3 -->
                <div class="bg-slate-50 rounded-3xl p-8 shadow-sm flex flex-col justify-between border border-slate-100 hover:shadow-md transition">
                    <div>
                        <div class="flex text-amber-400 gap-1 mb-5">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-slate-600 italic text-sm leading-relaxed mb-6">
                            "Kampus Mengajar membekali saya jiwa kepemimpinan serta empati sosial tinggi. Berbakti mencerdaskan generasi penerus bangsa."
                        </p>
                    </div>
                    <div class="flex items-center gap-4 border-t border-slate-200/60 pt-4">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Testimoni" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h4 class="font-extrabold text-slate-800 text-sm">Siti Aisyah</h4>
                            <p class="text-slate-500 text-xs font-semibold">Kampus Mengajar Angkatan 5</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-24 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-20">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Pertanyaan Umum (FAQ)</h2>
                <div class="w-16 h-1.5 bg-gradient-to-r from-brand-500 to-indigo-600 rounded-full mx-auto"></div>
                <p class="text-slate-500 mt-4 text-base">Informasi mendasar yang penting untuk kamu ketahui.</p>
            </div>
            
            <div class="max-w-3xl mx-auto space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm transition">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none" onclick="toggleFaq(this)">
                        <h3 class="font-extrabold text-slate-800 text-sm md:text-base">Siapa saja yang memenuhi syarat mengikuti MBKM?</h3>
                        <i class="fas fa-chevron-down text-brand-600 transition-transform duration-300"></i>
                    </button>
                    <div class="px-6 pb-6 hidden transition duration-300">
                        <p class="text-slate-500 text-sm leading-relaxed">Seluruh mahasiswa aktif Politeknik Negeri Batam yang minimal menduduki semester 4 untuk Diploma 3 (D3) maupun Diploma 4 (D4)/Sarjana Terapan, serta lolos kualifikasi akademik internal.</p>
                    </div>
                </div>
                
                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm transition">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none" onclick="toggleFaq(this)">
                        <h3 class="font-extrabold text-slate-800 text-sm md:text-base">Berapa jumlah maksimal SKS yang dapat dikonversi?</h3>
                        <i class="fas fa-chevron-down text-brand-600 transition-transform duration-300"></i>
                    </button>
                    <div class="px-6 pb-6 hidden transition duration-300">
                        <p class="text-slate-500 text-sm leading-relaxed">Maksimal 60 SKS (ekuivalen 3 semester). Penyetaraan beban mata kuliah dikonsultasikan serta diverifikasi langsung oleh Program Studi masing-masing.</p>
                    </div>
                </div>
                
                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm transition">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none" onclick="toggleFaq(this)">
                        <h3 class="font-extrabold text-slate-800 text-sm md:text-base">Apakah program MBKM ini dikenakan biaya?</h3>
                        <i class="fas fa-chevron-down text-brand-600 transition-transform duration-300"></i>
                    </button>
                    <div class="px-6 pb-6 hidden transition duration-300">
                        <p class="text-slate-500 text-sm leading-relaxed">Sama sekali tidak berbayar. Bahkan program unggulan Kemendikbud seperti Magang MSIB, IISMA, maupun Kampus Mengajar memberikan subsidi biaya hidup per bulan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-tr from-brand-900 to-slate-950 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(99,102,241,0.25),transparent_50%)]"></div>
        <div class="container mx-auto px-6 relative z-10 text-center max-w-3xl">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6 leading-tight">Mulai Perjalanan MBKM Anda Sekarang!</h2>
            <p class="text-slate-300 text-base md:text-lg mb-10 max-w-xl mx-auto">Tingkatkan value diri, raih pengalaman, dan persiapkan masa depan gemilang di luar kampus.</p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="./views/auth/registrasi.php" class="bg-white text-slate-950 px-8 py-4 rounded-2xl font-bold hover:bg-slate-100 transition shadow-lg w-full sm:w-auto text-center">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </a>
                <a href="mailto:mbkm@polibatam.ac.id" class="border border-white/20 hover:border-white text-white px-8 py-4 rounded-2xl font-bold transition w-full sm:w-auto text-center">
                    Kontak Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 py-16 border-t border-slate-900">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-base"></i>
                        </div>
                        <span class="text-lg font-bold text-white tracking-tight">MBKM Polibatam</span>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Program Merdeka Belajar Kampus Merdeka Politeknik Negeri Batam untuk mendorong inovasi dan kompetensi praktis mahasiswa.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-slate-500 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-slate-500 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-slate-500 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-slate-500 hover:text-white transition"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-white font-bold text-sm tracking-widest uppercase mb-6">Program</h3>
                    <ul class="space-y-3.5 text-sm">
                        <li><a href="#programs" class="hover:text-white transition">Magang / Praktik Kerja</a></li>
                        <li><a href="#programs" class="hover:text-white transition">Pertukaran Mahasiswa</a></li>
                        <li><a href="#programs" class="hover:text-white transition">Proyek Kemanusiaan</a></li>
                        <li><a href="#programs" class="hover:text-white transition">Riset / Penelitian</a></li>
                        <li><a href="#programs" class="hover:text-white transition">Kampus Mengajar</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-white font-bold text-sm tracking-widest uppercase mb-6">Tautan Langsung</h3>
                    <ul class="space-y-3.5 text-sm">
                        <li><a href="#home" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="#about" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#programs" class="hover:text-white transition">Program</a></li>
                        <li><a href="#testimoni" class="hover:text-white transition">Kisah Sukses</a></li>
                        <li><a href="#faq" class="hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-white font-bold text-sm tracking-widest uppercase mb-6">Kontak Kampus</h3>
                    <ul class="space-y-3.5 text-sm text-slate-500">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt mt-1 text-slate-400"></i>
                            <span>Jl. Ahmad Yani, Batam Kota, Kepulauan Riau</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone-alt text-slate-400"></i>
                            <span>(0778) 469858</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-slate-400"></i>
                            <span>mbkm@polibatam.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-900 mt-16 pt-8 text-center text-slate-600 text-xs">
                <p>&copy; <?= date('Y') ?> MBKM Politeknik Negeri Batam. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 bg-brand-600 text-white w-12 h-12 rounded-full shadow-lg hidden hover:bg-brand-700 transition duration-300 items-center justify-center z-50">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const m = document.getElementById('mobileMenu');
            const icon = document.getElementById('menuBtnIcon');
            m.classList.toggle('hidden');
            if (m.classList.contains('hidden')) {
                icon.classList.replace('fa-times', 'fa-bars');
            } else {
                icon.classList.replace('fa-bars', 'fa-times');
            }
        }

        // FAQ Toggle accordion
        function toggleFaq(btn) {
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('i');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
                backToTopButton.classList.add('flex');
            } else {
                backToTopButton.classList.add('hidden');
                backToTopButton.classList.remove('flex');
            }
        });
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>

</html>