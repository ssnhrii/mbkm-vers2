<?php
include '../function/proses-formulir.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Formulir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/style-formulir.css" />
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="../assets/img/Logo MBKM.png" alt="Logo" />
        </div>
        <nav>
            <a href="dashboard-mahasiswa.php" class="dashboard" onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-home-alt"></i></span>
                <span class="text">DASHBOARD</span>
            </a>
            <nav>
                <a href="formulir.php?nim_nik=<?php echo $data['nim_nik']; ?>" class="pengajuan active"
                    onclick="activateMenu(this)">
                    <span class="icon"><i class="fas fa-file-alt"></i></span>
                    <span class="text">PENGAJUAN</span>
                </a>
            </nav>
            <a href="rekap-pengajuan.php?nim_nik=<?php echo $data['nim_nik']; ?>" class="pengajuan"
                onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-file-alt"></i></span>
                <span class="text">REKAP PENGAJUAN</span>
            </a>

        </nav>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <div class="header">
            <h1>
                Selamat Datang Di Sistem Informasi Dan Layanan Mahasiswa Polibatam
            </h1>
            <div class="user-menu">
                <!-- Profile Icon -->
                <div class="profile-icon" onclick="toggleDropdown()">
                    <img src="../assets/img/icon.jpg" alt="Profile Icon" />
                </div>
                <!-- Dropdown Menu -->
                <div class="dropdown" id="dropdownMenu">
                    <span><br />Nama: <?php echo $data['nama_lengkap']; ?></span>
                    <a href="profile.php"><button><i class="fas fa-user"></i> Profile</button></a>
                    <a href="change-password.php?data=<?php echo $data['nim_nik'] ?>">
                        <button><i class="fas fa-key"></i> Change Password</button>
                    </a>
                    <a href="../function/logout.php"><button><i class="fas fa-sign-out-alt"></i> Logout</button></a>
                </div>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="welcome">Formulir Pendaftaran Merdeka Belajar Kampus Merdeka</div>


        <!-- Formulir -->
        <form id="merdekaBelajarForm" action="../function/proses-formulir.php?nim_nik=<?php echo $data['nim_nik'] ?>"
            method="POST">
            <h1>FORMULIR PENDAFTARAN MERDEKA BELAJAR<br>POLITEKNIK NEGERI BATAM<br>
                <p>Tahun: <span id="tahun"></span></p>
                <script>
                    var dt = new Date();
                    document.getElementById("tahun").innerHTML = (dt.getFullYear());
                </script>
            </h1>
            <table>
                <tr>
                    <td>Nama:</td>
                    <td><input type="text" placeholder="<?php echo $data['nama_lengkap']; ?>" readonly></td>
                </tr>
                <tr>
                    <td>Nomor Induk Mahasiswa:</td>
                    <td><input type="text" placeholder="<?php echo $data['nim_nik']; ?>" readonly></td>
                </tr>
                <tr>
                    <td>Program Studi Asal:</td>
                    <td><input type="text" placeholder="<?php echo $data['id_prodi']; ?>" readonly></td>
                </tr>

                <tr>
                    <td>Dosen Pembimbing/Dosen Wali:</td>
                    <td>
                        <select name="dosenPembimbing" id="dosen-pembimbing-dropdown">
                            <option value="">Pilih Dosen Pembimbing</option>
                            <?php
                            $sql = "SELECT u.nim_nik, u.nama_lengkap 
                          FROM users u
                          WHERE u.role = 'Dosen'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["nim_nik"] . "'>" . htmlspecialchars($row['nama_lengkap']) . "</option>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Tidak ada data dosen</td></tr>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Program Merdeka Belajar:</td>
                    <td>
                        <select name="program" id="program-dropdown" onchange="toggleProgramSpecificFields()">
                            <option value="">Pilih Program</option>
                            <option value="Penelitian/Riset">Penelitian/Riset</option>
                            <option value="Proyek Kemanusiaan">Proyek Kemanusiaan</option>
                            <option value="Kegiatan Wirausaha">Kegiatan Wirausaha</option>
                            <option value="Studi/Proyek Independen">Studi/Proyek Independen</option>
                            <option value="Membangun Desa / Kuliah Kerja Nyata Tematik">Membangun Desa / Kuliah Kerja
                                Nyata Tematik</option>
                            <option value="Magang Praktik Kerja">Magang Praktik Kerja</option>
                            <option value="Asistensi Mengajar Di Satuan Pendidikan">Asistensi Mengajar Di Satuan
                                Pendidikan</option>
                            <option value="Pertukaran Pelajar">Pertukaran Pelajar</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Alasan Memilih Program:</td>
                    <td><textarea name="alasan" rows="3"
                            placeholder="Tuliskan alasan Anda memilih program ini"></textarea></td>
                </tr>
                <tr>
                    <td>Judul Program/Kegiatan:</td>
                    <td><input type="text" name="judulProgram" placeholder="Tuliskan judul program/kegiatan"></td>
                </tr>
                <tr>
                    <td>Nama Lembaga Mitra/Perusahaan:</td>
                    <td><input type="text" name="namaLembaga"
                            placeholder="Untuk lembaga, isikan dengan nama lembaga / perusahaan"></td>
                </tr>
                <tr>
                    <td>Durasi Kegiatan:</td>
                    <td><input type="text" name="durasi" placeholder="cantumkan tanggal mulai dan selesai kegiatan">
                    </td>
                </tr>
                <tr>
                    <td>Posisi di Perusahaan:</td>
                    <td><input type="text" name="posisi" placeholder="Wajib diisi untuk kegiatan MSIB"></td>
                </tr>
                <tr>
                    <td>Rincian Kegiatan:</td>
                    <td><textarea name="rincian" rows="3" placeholder="Tuliskan rincian kegiatan"></textarea></td>
                </tr>

                <tbody id="membangunDesaFields" style="display: none;">
                    <tr>
                        <td colspan="2" style="background-color: #ffffff; font-weight: bold;">Untuk Program Membangun
                            Desa/Kuliah Kerja Nyata Tematik:</td>
                    </tr>
                    <tr>
                        <td>Sumber Pendanaan (jika ada):</td>
                        <td><input type="text" name="sumberPendanaan"></td>
                    </tr>
                    <tr>
                        <td>Jumlah Anggota:</td>
                        <td><input type="text" name="jumlahAnggota"></td>
                    </tr>
                    <tr>
                        <td>Nama Anggota:</td>
                        <td><textarea name="namaAnggota" rows="3" placeholder="Tuliskan nama-nama anggota"></textarea>
                        </td>
                    </tr>
                </tbody>

                <tbody id="pertukaranPelajarFields" style="display: none;">
                    <tr>
                        <td colspan="2" style="background-color: #ffffff; font-weight: bold;">Untuk Program Pertukaran
                            Pelajar:</td>
                    </tr>
                    <tr>
                        <td>Jenis Pertukaran Pelajar:</td>
                        <td>
                            <select name="jenisPertukaran">
                                <option value="" disabled>Pilih Jenis Pertukaran</option>
                                <option value="Antar Prodi di Politeknik Negeri Batam">Antar Prodi di Politeknik Negeri
                                    Batam</option>
                                <option value="Antar Prodi pada Perguruan Tinggi yang berbeda">Antar Prodi pada
                                    Perguruan Tinggi yang berbeda</option>
                                <option value="Prodi sama pada Perguruan Tinggi yang berbeda">Prodi sama pada Perguruan
                                    Tinggi yang berbeda</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Program Studi Tujuan:</td>
                        <td><input type="text" name="prodiTujuan"></td>
                    </tr>
                    <tr>
                        <td>Mata Kuliah yang Diklaim:</td>
                        <td>
                            <ol id="mataKuliahList">
                                <li><input type="text" name="mataKuliah[]" placeholder="Kode/Nama/SKS"></li>
                            </ol>
                            <button type="button" onclick="addMataKuliah()">Tambah Mata Kuliah</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit">Kirim</button>
        </form>

        <script>
            function addMataKuliah() {
                const list = document.getElementById('mataKuliahList');
                const newItem = document.createElement('li');
                newItem.innerHTML = '<input type="text" name="mataKuliah[]" placeholder="Kode/Nama/SKS">';
                list.appendChild(newItem);
            }

            function toggleProgramSpecificFields() {
                const program = document.getElementById('program-dropdown').value;
                const membangunDesaFields = document.getElementById('membangunDesaFields');
                const pertukaranPelajarFields = document.getElementById('pertukaranPelajarFields');

                membangunDesaFields.style.display = (program === 'Membangun Desa / Kuliah Kerja Nyata Tematik') ? '' : 'none';
                pertukaranPelajarFields.style.display = (program === 'Pertukaran Pelajar') ? '' : 'none';
            }
        </script>

        <script>
            function toggleDropdown() {
                const dropdown = document.getElementById("dropdownMenu");
                dropdown.classList.toggle("show");
            }

            window.onclick = function (event) {
                if (!event.target.matches(".profile-icon img")) {
                    const dropdown = document.getElementById("dropdownMenu");
                    if (dropdown.classList.contains("show")) {
                        dropdown.classList.remove("show");
                    }
                }
            };

            function activateMenu(element) {
                document.querySelectorAll(".sidebar nav a").forEach((menu) => {
                    menu.classList.remove("active");
                });
                element.classList.add("active");
            }
        </script>
</body>

</html>