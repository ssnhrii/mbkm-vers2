<?php
include '../function/proses-formulir.php';

$sqlDetail = "SELECT * FROM pengajuan_usulan WHERE id_pengajuan = ?";
$stmtDetail = $conn->prepare($sqlDetail);
$stmtDetail->bind_param("i", $_GET['data']);
$stmtDetail->execute();
$resultDetail = $stmtDetail->get_result();
$rowDetail = $resultDetail->fetch_assoc();
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
            <a href="dashboard-mahasiswa.php" class="dashboard active" onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-home-alt"></i></span>
                <span class="text">DASHBOARD</span>
            </a>
            <nav>
                <a href="formulir.php?nim_nik=<?php echo $data['nim_nik']; ?>" class="pengajuan"
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
            <h1>Selamat Datang Di Sistem Informasi Dan Layanan Mahasiswa Polibatam</h1>
            <div class="user-menu">
                <!-- Profile Icon -->
                <div class="profile-icon" onclick="toggleDropdown()">
                    <img src="../assets/img/icon.jpg" alt="Profile Icon" />
                </div>
                <!-- Dropdown Menu -->
                <div class="dropdown" id="dropdownMenu">
                    <span><br />Nama: <?php echo $data['nama_lengkap']; ?></span>
                    <a href="profile.php"><button><i class="fas fa-user"></i> Profile</button></a>
                    <a href="change-password.php?data=<?php echo $data['nim_nik'] ?>"><button><i class="fas fa-key"></i>
                            Change Password</button></a>
                    <a href="../function/logout.php"><button><i class="fas fa-sign-out-alt"></i> Logout</button></a>
                </div>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="welcome">Formulir Pendaftaran Merdeka Belajar Kampus Merdeka</div>

        <!-- Formulir -->
        <form id="merdekaBelajarForm"
            action="../function/proses-edit-pengajuan.php?data=<?php echo $rowDetail['id_pengajuan']; ?>&nim_nik=<?php echo $data['nim_nik'] ?>"
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
                    <td><input type="text" name="nama" value="<?php echo $data['nama_lengkap']; ?>" required></td>
                </tr>
                <tr>
                    <td>Nomor Induk Mahasiswa:</td>
                    <td><input type="text" name="nim_nik" value="<?php echo $data['nim_nik']; ?>" readonly></td>
                </tr>
                <tr>
                    <td>Program Studi Asal:</td>
                    <td><input type="text" name="id_prodi" value="<?php echo $data['id_prodi']; ?>" required></td>
                </tr>
                <tr>
                    <td>Dosen Pembimbing/Dosen Wali:</td>
                    <td>
                        <select name="dosenPembimbing" id="dosen-pembimbing-dropdown">
                            <option value="">Pilih Dosen Pembimbing</option>
                            <?php
                            $sql = "SELECT u.nim_nik, u.nama_lengkap FROM users u WHERE u.role = 'Dosen'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $selected = $row['nim_nik'] == $rowDetail['dosen_pembimbing'] ? 'selected' : '';
                                    echo "<option value='" . $row["nim_nik"] . "' $selected>" . htmlspecialchars($row['nama_lengkap']) . "</option>";
                                }
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
                            <?php
                            $programOptions = [
                                'Penelitian/Riset',
                                'Proyek Kemanusiaan',
                                'Kegiatan Wirausaha',
                                'Studi/Proyek Independen',
                                'Membangun Desa / Kuliah Kerja Nyata Tematik',
                                'Magang Praktik Kerja',
                                'Asistensi Mengajar Di Satuan Pendidikan',
                                'Pertukaran Pelajar'
                            ];

                            foreach ($programOptions as $program) {
                                $selected = ($program == $rowDetail['jenis_program']) ? 'selected' : '';
                                echo "<option value='$program' $selected>$program</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Alasan Memilih Program:</td>
                    <td><textarea name="alasan" rows="3"
                            required><?php echo $rowDetail['alasan_memilih_program']; ?></textarea></td>
                </tr>
                <tr>
                    <td>Judul Program/Kegiatan:</td>
                    <td><input type="text" name="judulProgram" value="<?php echo $rowDetail['judul_program']; ?>"
                            required></td>
                </tr>
                <tr>
                    <td>Nama Lembaga Mitra/Perusahaan:</td>
                    <td><input type="text" name="namaLembaga" value="<?php echo $rowDetail['nama_mitra']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Durasi Kegiatan:</td>
                    <td><input type="text" name="durasi" value="<?php echo $rowDetail['durasi_kegiatan']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Posisi di Perusahaan:</td>
                    <td><input type="text" name="posisi" value="<?php echo $rowDetail['posisi_di_perusahaan']; ?>"
                            required></td>
                </tr>
                <tr>
                    <td>Rincian Kegiatan:</td>
                    <td><textarea name="rincian" rows="3"
                            required><?php echo $rowDetail['rincian_kegiatan']; ?></textarea></td>
                </tr>
                <tbody id="membangunDesaFields"
                    style="display: <?php echo $rowDetail['jenis_program'] === 'Membangun Desa / Kuliah Kerja Nyata Tematik' ? 'block' : 'none'; ?>;">
                    <tr>
                        <td colspan="2" style="background-color: #ffffff; font-weight: bold;">Untuk Program Membangun
                            Desa/Kuliah Kerja Nyata Tematik:</td>
                    </tr>
                    <tr>
                        <td>Sumber Pendanaan (jika ada):</td>
                        <td><input type="text" name="sumberPendanaan"
                                value="<?php echo $rowDetail['sumber_pendanaan']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Jumlah Anggota:</td>
                        <td><input type="text" name="jumlahAnggota" value="<?php echo $rowDetail['jumlah_anggota']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Anggota:</td>
                        <td><textarea name="namaAnggota" rows="3"><?php echo $rowDetail['nama_anggota']; ?></textarea>
                        </td>
                    </tr>
                </tbody>
                <tbody id="pertukaranPelajarFields"
                    style="display: <?php echo $rowDetail['jenis_program'] === 'Pertukaran Pelajar' ? 'block' : 'none'; ?>;">
                    <tr>
                        <td colspan="2" style="background-color: #ffffff; font-weight: bold;">Untuk Program Pertukaran
                            Pelajar:</td>
                    </tr>
                    <tr>
                        <td>Jenis Pertukaran Pelajar:</td>
                        <td>
                            <select name="jenisPertukaran">
                                <?php
                                $jenisPertukaranOptions = [
                                    'Antar Prodi di Politeknik Negeri Batam',
                                    'Antar Prodi pada Perguruan Tinggi yang berbeda',
                                    'Prodi sama pada Perguruan Tinggi yang berbeda'
                                ];

                                $selectedJenisPertukaran = isset($rowDetail['jenis_pertukaran_pelajar']) ? $rowDetail['jenis_pertukaran_pelajar'] : '';
                                echo "<option value=''>Pilih Jenis Pertukaran</option>";
                                foreach ($jenisPertukaranOptions as $jenisPertukaran) {
                                    $selected = ($jenisPertukaran == $selectedJenisPertukaran) ? 'selected' : '';
                                    echo "<option value='$jenisPertukaran' $selected>$jenisPertukaran</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Program Studi Tujuan:</td>
                        <td><input type="text" name="prodiTujuan"
                                value="<?php echo $rowDetail['nama_program_studi']; ?>"></td>
                    </tr>
                    <?php
                    $mataKuliahString = $rowDetail['nama_mata_kuliah_jumlah_sks'];
                    $mataKuliahArray = explode(',', $mataKuliahString);
                    ?>

                    <tr>
                        <td>Mata Kuliah yang Diklaim:</td>
                        <td>
                            <ol id="mataKuliahList">
                                <?php foreach ($mataKuliahArray as $mataKuliah): ?>
                                    <li><input type="text" name="mataKuliah[]" placeholder="Kode/Nama/SKS"
                                            value="<?php echo htmlspecialchars($mataKuliah); ?>"></li>
                                <?php endforeach; ?>
                            </ol>
                            <button type="button" onclick="addMataKuliah()">Tambah Mata Kuliah</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Submit Button -->
            <div class="form-actions">
                <button type="submit" name="submit" class="submit">Submit</button>
                <button type="reset" class="reset">Reset</button>
            </div>
        </form>
    </div>

    <script>
        function toggleProgramSpecificFields() {
            var programDropdown = document.getElementById("program-dropdown");
            var selectedProgram = programDropdown.value;

            document.getElementById("membangunDesaFields").style.display = selectedProgram == "Membangun Desa / Kuliah Kerja Nyata Tematik" ? "block" : "none";
            document.getElementById("pertukaranPelajarFields").style.display = selectedProgram == "Pertukaran Pelajar" ? "block" : "none";
        }

        function addMataKuliah() {
            const list = document.getElementById('mataKuliahList');
            const newItem = document.createElement('li');
            newItem.innerHTML = '<input type="text" name="mataKuliah[]" placeholder="Kode/Nama/SKS">';
            list.appendChild(newItem);
        }
    </script>
</body>

</html>