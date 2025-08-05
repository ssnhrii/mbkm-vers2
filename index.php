<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBKM - Merdeka Belajar Kampus Merdeka</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="assets/img/logo.png" alt="Logo Kampus" class="h-12">
                <span class="text-xl font-bold text-blue-800">MBKM</span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#home" class="text-blue-800 hover:text-blue-600 font-medium">Beranda</a>
                <a href="#about" class="text-gray-600 hover:text-blue-600 font-medium">Tentang</a>
                <a href="#programs" class="text-gray-600 hover:text-blue-600 font-medium">Program</a>
                <a href="#testimoni" class="text-gray-600 hover:text-blue-600 font-medium">Testimoni</a>
                <a href="#faq" class="text-gray-600 hover:text-blue-600 font-medium">FAQ</a>
                <a href="./views/auth/login.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Login</a>
            </div>
            <button class="md:hidden text-gray-600 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-gradient text-white py-20">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0 animate__animated animate__fadeInLeft">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Merdeka Belajar Kampus Merdeka</h1>
                <p class="text-xl mb-8">Wujudkan pengalaman belajar di luar kampus dengan program MBKM yang memberikan kesempatan untuk mengembangkan potensi diri secara maksimal.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#programs" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-medium text-center hover:bg-gray-100 transition duration-300">Lihat Program</a>
                    <a href="#about" class="border-2 border-white text-white px-6 py-3 rounded-lg font-medium text-center hover:bg-white hover:text-blue-600 transition duration-300">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="md:w-1/2 animate__animated animate__fadeInRight">
                <img src="https://illustrations.popsy.co/amber/digital-nomad.svg" alt="Ilustrasi MBKM" class="w-full">
            </div>
        </div>
    </section>

    <!-- About MBKM -->
    <section id="about" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Apa Itu MBKM?</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
            </div>
            
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0 animate__animated animate__fadeInLeft">
                    <img src="assets/img/ilustrasi.jpeg" alt="Ilustrasi MBKM" class="w-full">
                </div>
                <div class="md:w-1/2 md:pl-12 animate__animated animate__fadeInRight">
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        <span class="font-bold text-blue-600">Merdeka Belajar Kampus Merdeka (MBKM)</span> adalah kebijakan dari Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi yang memberikan kesempatan kepada mahasiswa untuk mengembangkan potensi diri melalui pembelajaran di luar program studi.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Program ini memungkinkan mahasiswa mengambil <span class="font-bold">3 semester (60 SKS)</span> di luar program studi asal, baik di dalam maupun di luar perguruan tinggi.
                    </p>
                    <div class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-600">
                        <h3 class="font-bold text-blue-800 mb-2">Tujuan MBKM:</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            <li>Meningkatkan kompetensi lulusan</li>
                            <li>Mempersiapkan mahasiswa menghadapi dunia kerja</li>
                            <li>Mendorong inovasi pembelajaran</li>
                            <li>Memperkuat kolaborasi dengan industri</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program MBKM -->
    <section id="programs" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Program MBKM</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Berbagai pilihan program yang dapat diikuti mahasiswa untuk pengembangan diri</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Program 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition duration-300 card-hover animate__animated animate__fadeInUp">
                    <div class="p-6">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-building text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Magang/Praktik Kerja</h3>
                        <p class="text-gray-600 mb-4">Pengalaman kerja langsung di industri mitra untuk mengembangkan kompetensi profesional.</p>
                        <a href="#" class="text-blue-600 font-medium flex items-center hover:text-blue-800">
                            Selengkapnya <i class="fas fa-chevron-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Program 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition duration-300 card-hover animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="p-6">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-book-reader text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Pertukaran Pelajar</h3>
                        <p class="text-gray-600 mb-4">Belajar di perguruan tinggi lain baik dalam maupun luar negeri untuk memperluas wawasan.</p>
                        <a href="#" class="text-blue-600 font-medium flex items-center hover:text-blue-800">
                            Selengkapnya <i class="fas fa-chevron-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Program 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition duration-300 card-hover animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="p-6">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-users text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Proyek Kemanusiaan</h3>
                        <p class="text-gray-600 mb-4">Kontribusi langsung dalam proyek-proyek kemanusiaan untuk pengembangan karakter.</p>
                        <a href="#" class="text-blue-600 font-medium flex items-center hover:text-blue-800">
                            Selengkapnya <i class="fas fa-chevron-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Program 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition duration-300 card-hover animate__animated animate__fadeInUp">
                    <div class="p-6">
                        <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-lightbulb text-yellow-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Riset/Kajian</h3>
                        <p class="text-gray-600 mb-4">Pengalaman penelitian bersama dosen atau lembaga riset untuk pengembangan keilmuan.</p>
                        <a href="#" class="text-blue-600 font-medium flex items-center hover:text-blue-800">
                            Selengkapnya <i class="fas fa-chevron-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Program 5 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition duration-300 card-hover animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="p-6">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-hands-helping text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Kampus Mengajar</h3>
                        <p class="text-gray-600 mb-4">Mengajar di sekolah untuk mengembangkan kompetensi pedagogis dan kepemimpinan.</p>
                        <a href="#" class="text-blue-600 font-medium flex items-center hover:text-blue-800">
                            Selengkapnya <i class="fas fa-chevron-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Program 6 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition duration-300 card-hover animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="p-6">
                        <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-business-time text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Wirausaha</h3>
                        <p class="text-gray-600 mb-4">Pengembangan usaha mandiri dengan bimbingan dari mentor berpengalaman.</p>
                        <a href="#" class="text-blue-600 font-medium flex items-center hover:text-blue-800">
                            Selengkapnya <i class="fas fa-chevron-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section id="testimoni" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Apa Kata Mereka?</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Pengalaman mahasiswa yang telah mengikuti program MBKM</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimoni 1 -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-sm animate__animated animate__fadeIn">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Testimoni" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Dewi Anggraeni</h4>
                            <p class="text-gray-500 text-sm">Magang di PT. Telkom Indonesia</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Pengalaman magang melalui MBKM sangat berharga. Saya mendapatkan pengetahuan praktis yang tidak diajarkan di kelas dan jaringan profesional yang luas."</p>
                    <div class="flex mt-4 text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <!-- Testimoni 2 -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-sm animate__animated animate__fadeIn animate__delay-1s">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Testimoni" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Rizky Pratama</h4>
                            <p class="text-gray-500 text-sm">Pertukaran Pelajar ke Malaysia</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"MBKM membuka kesempatan saya untuk belajar di luar negeri. Pengalaman ini memperluas wawasan internasional dan meningkatkan kemampuan bahasa Inggris saya."</p>
                    <div class="flex mt-4 text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
                
                <!-- Testimoni 3 -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-sm animate__animated animate__fadeIn animate__delay-2s">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Testimoni" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Siti Aisyah</h4>
                            <p class="text-gray-500 text-sm">Kampus Mengajar Angkatan 3</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Mengajar di sekolah dasar melalui Kampus Mengajar mengajarkan saya banyak tentang kesabaran, kreativitas, dan tanggung jawab. Pengalaman yang sangat berharga!"</p>
                    <div class="flex mt-4 text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Pertanyaan Umum</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
            </div>
            
            <div class="max-w-3xl mx-auto">
                <!-- FAQ 1 -->
                <div class="mb-6 bg-white rounded-lg shadow-md overflow-hidden animate__animated animate__fadeIn">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="font-bold text-gray-800">Siapa yang bisa mengikuti program MBKM?</h3>
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                    </button>
                    <div class="px-6 pb-6 hidden">
                        <p class="text-gray-600">Program MBKM terbuka untuk semua mahasiswa aktif yang memenuhi persyaratan dari perguruan tinggi masing-masing. Biasanya mahasiswa semester 4 ke atas yang boleh mengikuti program ini.</p>
                    </div>
                </div>
                
                <!-- FAQ 2 -->
                <div class="mb-6 bg-white rounded-lg shadow-md overflow-hidden animate__animated animate__fadeIn">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="font-bold text-gray-800">Berapa SKS yang bisa dikonversi dari program MBKM?</h3>
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                    </button>
                    <div class="px-6 pb-6 hidden">
                        <p class="text-gray-600">Mahasiswa dapat mengambil maksimal 60 SKS (3 semester) di luar program studi asal. Konversi SKS disesuaikan dengan kebijakan perguruan tinggi dan kesetaraan mata kuliah.</p>
                    </div>
                </div>
                
                <!-- FAQ 3 -->
                <div class="mb-6 bg-white rounded-lg shadow-md overflow-hidden animate__animated animate__fadeIn">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="font-bold text-gray-800">Apakah program MBKM berbayar?</h3>
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                    </button>
                    <div class="px-6 pb-6 hidden">
                        <p class="text-gray-600">Sebagian besar program MBKM tidak berbayar dan bahkan beberapa memberikan insentif atau beasiswa. Namun untuk program tertentu seperti pertukaran pelajar internasional mungkin ada biaya tambahan.</p>
                    </div>
                </div>
                
                <!-- FAQ 4 -->
                <div class="mb-6 bg-white rounded-lg shadow-md overflow-hidden animate__animated animate__fadeIn">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="font-bold text-gray-800">Bagaimana mekanisme pendaftaran program MBKM?</h3>
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                    </button>
                    <div class="px-6 pb-6 hidden">
                        <p class="text-gray-600">Pendaftaran dilakukan melalui platform MBKM masing-masing perguruan tinggi. Mahasiswa perlu mempersiapkan dokumen seperti transkrip nilai, proposal kegiatan, dan surat rekomendasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 hero-gradient text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6 animate__animated animate__fadeIn">Siap Memulai Pengalaman MBKM Anda?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto animate__animated animate__fadeIn">Daftarkan diri Anda sekarang dan dapatkan pengalaman belajar yang berbeda!</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 animate__animated animate__fadeIn">
                <a href="./views/auth/registrasi.php" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition duration-300">Daftar Sekarang</a>
                <a href="#" class="border-2 border-white text-white px-8 py-3 rounded-lg font-medium hover:bg-white hover:text-blue-600 transition duration-300">Kontak Kami</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="assets/img/logo.png" alt="Logo Kampus" class="h-10">
                        <span class="text-lg font-bold">MBKM</span>
                    </div>
                    <p class="text-gray-400">Program Merdeka Belajar Kampus Merdeka untuk pengembangan kompetensi mahasiswa.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Program</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Magang/Praktik Kerja</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Pertukaran Pelajar</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Proyek Kemanusiaan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Riset/Kajian</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kampus Mengajar</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Link Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white">Beranda</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white">Tentang MBKM</a></li>
                        <li><a href="#programs" class="text-gray-400 hover:text-white">Program</a></li>
                        <li><a href="#testimoni" class="text-gray-400 hover:text-white">Testimoni</a></li>
                        <li><a href="#faq" class="text-gray-400 hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>Jl. Ahmad Yani, Batam Kota, Kepulauan Riau</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3"></i>
                            <span>(0778) 469858</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <span>mbkm@polibatam.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2024 MBKM Politeknik Negeri Batam. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 bg-blue-600 text-white w-12 h-12 rounded-full shadow-lg hidden hover:bg-blue-700 transition duration-300">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // FAQ Accordion
        document.querySelectorAll('#faq button').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('i');
                
                // Toggle content
                content.classList.toggle('hidden');
                
                // Rotate icon
                icon.classList.toggle('transform');
                icon.classList.toggle('rotate-180');
            });
        });
        
        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        // Mobile Menu Toggle (you can implement this as needed)
    </script>
</body>

</html>