<?php
include '../../controllers/proses-formulir.php';
$pageTitle = 'Formulir Pengajuan MBKM';
$activePage = 'pengajuan';
$profileUrl = '../profil/profile.php';
$changePasswordUrl = 'change-password.php?data=' . ($data['nim_nik'] ?? '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<?php include '../partials/page-head.php'; ?>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
<?php include '../partials/sidebar-mhs.php'; ?>
<div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
<?php include '../partials/header.php'; ?>
<main class="flex-1 p-6">
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Formulir Pendaftaran MBKM</h2>
    <p class="text-sm text-gray-500 mt-0.5">Politeknik Negeri Batam &mdash; Tahun <span id="tahunForm"></span></p>
</div>
<form id="merdekaBelajarForm" action="../../controllers/proses-formulir.php?nim_nik=<?= htmlspecialchars($data['nim_nik']) ?>" method="POST" onsubmit="return buildDurasiAndMK()">

<!-- A. DATA PRIBADI -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">
    <div class="bg-blue-50 border-b border-blue-100 px-6 py-3 flex items-center gap-2">
        <span class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center">A</span>
        <h3 class="text-sm font-bold text-gray-800">Data Pribadi</h3>
    </div>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                <input type="text" value="<?= htmlspecialchars($data['nama_lengkap']) ?>" readonly class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-600 cursor-not-allowed">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Induk Mahasiswa</label>
                <input type="text" value="<?= htmlspecialchars($data['nim_nik']) ?>" readonly class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-600 cursor-not-allowed">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Program Studi Asal</label>
            <input type="text" value="<?= htmlspecialchars($data['nama_prodi'] ?? $data['id_prodi']) ?>" readonly class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-600 cursor-not-allowed">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Dosen Pembimbing / Dosen Wali <span class="text-red-500">*</span></label>
            <p class="text-xs text-blue-600 mb-1.5 flex items-center gap-1"><i class="fas fa-info-circle"></i> Isikan nama dosen wali apabila tidak ada dosen pembimbing magang/TA</p>
            <select name="dosenPembimbing" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                <option value="">— Pilih Dosen Pembimbing —</option>
                <?php
                $sqlD = "SELECT nim_nik, nama_lengkap FROM users WHERE role = 'Dosen' ORDER BY nama_lengkap";
                $resD = $conn->query($sqlD);
                while ($d = $resD->fetch_assoc()):
                ?>
                <option value="<?= $d['nim_nik'] ?>"><?= htmlspecialchars($d['nama_lengkap']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>
</div>

<!-- B. DETAIL PROGRAM -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">
    <div class="bg-blue-50 border-b border-blue-100 px-6 py-3 flex items-center gap-2">
        <span class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center">B</span>
        <h3 class="text-sm font-bold text-gray-800">Detail Program</h3>
    </div>
    <div class="p-6 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Program Merdeka Belajar <span class="text-red-500">*</span></label>
            <select name="program" id="program-dropdown" onchange="toggleProgramSpecificFields()" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                <option value="">— Pilih Program —</option>
                <option value="Penelitian/Riset">1. Penelitian / Riset</option>
                <option value="Proyek Kemanusiaan">2. Proyek Kemanusiaan</option>
                <option value="Kegiatan Wirausaha">3. Kegiatan Wirausaha</option>
                <option value="Studi/Proyek Independen">4. Studi / Proyek Independen</option>
                <option value="Membangun Desa / Kuliah Kerja Nyata Tematik">5. Membangun Desa / KKN Tematik</option>
                <option value="Magang Praktik Kerja">6. Magang Praktik Kerja</option>
                <option value="Asistensi Mengajar Di Satuan Pendidikan">7. Asistensi Mengajar di Satuan Pendidikan</option>
                <option value="Pertukaran Pelajar">8. Pertukaran Pelajar</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Alasan Memilih Program <span class="text-red-500">*</span></label>
            <textarea name="alasan" rows="3" required placeholder="Tuliskan alasan Anda memilih program ini" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"></textarea>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul Program / Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="judulProgram" required placeholder="Judul program atau kegiatan" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lembaga Mitra / Perusahaan <span class="text-red-500">*</span></label>
                <input type="text" name="namaLembaga" required placeholder="Nama lembaga/perusahaan (atau nama lomba)" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Durasi Kegiatan <span class="text-red-500">*</span></label>
            <div class="flex items-center gap-3">
                <input type="date" name="tanggalMulai" id="tanggalMulai" required class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <span class="text-sm font-semibold text-gray-500 whitespace-nowrap">s/d</span>
                <input type="date" name="tanggalSelesai" id="tanggalSelesai" required class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <input type="hidden" name="durasi" id="durasiHidden">
        </div>
        <div id="posisiRow" class="hidden">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Posisi di Perusahaan <span class="text-red-500">*</span></label>
            <input type="text" name="posisi" id="posisiInput" placeholder="Contoh: Data Analyst Intern" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            <p class="text-xs text-blue-600 mt-1 flex items-center gap-1"><i class="fas fa-info-circle"></i> Wajib diisi untuk program Magang Praktik Kerja (MSIB)</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Rincian Kegiatan <span class="text-red-500">*</span></label>
            <textarea name="rincian" rows="4" required placeholder="Tuliskan rincian kegiatan (jadwal, deskripsi, bukti lomba/sertifikat jika ada)" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"></textarea>
        </div>
    </div>
</div>

<!-- C. MEMBANGUN DESA -->
<div id="membangunDesaSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5 hidden">
    <div class="bg-orange-50 border-b border-orange-100 px-6 py-3 flex items-center gap-2">
        <span class="w-6 h-6 rounded-full bg-orange-500 text-white text-xs font-bold flex items-center justify-center">C</span>
        <h3 class="text-sm font-bold text-gray-800">Khusus: Membangun Desa / KKN Tematik</h3>
    </div>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Sumber Pendanaan (jika ada)</label>
                <input type="text" name="sumberPendanaan" placeholder="Contoh: Kemendesa, Mandiri" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Anggota</label>
                <input type="number" name="jumlahAnggota" min="1" placeholder="Min. 10 orang" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Anggota</label>
            <textarea name="namaAnggota" rows="3" placeholder="Tuliskan nama anggota, satu per baris" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"></textarea>
        </div>
    </div>
</div>

<!-- D. PERTUKARAN PELAJAR -->
<div id="pertukaranSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5 hidden">
    <div class="bg-purple-50 border-b border-purple-100 px-6 py-3 flex items-center gap-2">
        <span class="w-6 h-6 rounded-full bg-purple-600 text-white text-xs font-bold flex items-center justify-center">D</span>
        <h3 class="text-sm font-bold text-gray-800">Khusus: Pertukaran Pelajar</h3>
    </div>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Pertukaran Pelajar</label>
                <select name="jenisPertukaran" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                    <option value="">— Pilih Jenis —</option>
                    <option value="Antar Prodi di Politeknik Negeri Batam">A. Antar Prodi di Polibatam (maks. 20 SKS)</option>
                    <option value="Prodi sama pada Perguruan Tinggi yang berbeda">B. Prodi Sama di PT Berbeda (maks. 20 SKS)</option>
                    <option value="Antar Prodi pada Perguruan Tinggi yang berbeda">C. Antar Prodi di PT Berbeda (maks. 20 SKS)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Program Studi Tujuan</label>
                <input type="text" name="prodiTujuan" placeholder="Nama prodi tujuan" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Daftar Mata Kuliah yang Diambil di Prodi Tujuan</label>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50"><tr>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 w-28">Kode MK</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500">Nama Mata Kuliah</th>
                        <th class="px-3 py-2 text-center text-xs font-semibold text-gray-500 w-16">SKS</th>
                        <th class="px-3 py-2 w-10"></th>
                    </tr></thead>
                    <tbody id="pertukaranMKBody" class="divide-y divide-gray-100">
                        <tr>
                            <td class="px-2 py-1.5"><input type="text" name="pertukaranKodeMK[]" placeholder="MK001" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500"></td>
                            <td class="px-2 py-1.5"><input type="text" name="pertukaranNamaMK[]" placeholder="Nama Mata Kuliah" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500"></td>
                            <td class="px-2 py-1.5"><input type="number" name="pertukaranSKS[]" min="1" max="6" placeholder="3" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 text-center"></td>
                            <td class="px-2 py-1.5 text-center"><button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-times"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" onclick="addPertukaranMKRow()" class="mt-2 inline-flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-800 font-medium"><i class="fas fa-plus-circle"></i> Tambah Mata Kuliah</button>
            <input type="hidden" name="mataKuliahPertukaranString" id="mataKuliahPertukaranString">
        </div>
    </div>
</div>

<!-- E. KLAIM MATA KULIAH -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">
    <div class="bg-teal-50 border-b border-teal-100 px-6 py-3 flex items-center gap-2">
        <span class="w-6 h-6 rounded-full bg-teal-600 text-white text-xs font-bold flex items-center justify-center">E</span>
        <h3 class="text-sm font-bold text-gray-800">Klaim / Konversi Mata Kuliah</h3>
    </div>
    <div class="p-6 space-y-3">
        <p class="text-xs text-gray-500">Daftar mata kuliah dari kurikulum asal yang ingin dikonversi/disetarakan. Diisi sesuai rekomendasi Tim Reviewer MBKM.</p>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50"><tr>
                    <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 w-28">Kode MK</th>
                    <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500">Nama Mata Kuliah</th>
                    <th class="px-3 py-2 text-center text-xs font-semibold text-gray-500 w-16">SKS</th>
                    <th class="px-3 py-2 w-10"></th>
                </tr></thead>
                <tbody id="klaimMKBody" class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-2 py-1.5"><input type="text" name="klaimKodeMK[]" placeholder="MK001" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500"></td>
                        <td class="px-2 py-1.5"><input type="text" name="klaimNamaMK[]" placeholder="Nama Mata Kuliah" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500"></td>
                        <td class="px-2 py-1.5"><input type="number" name="klaimSKS[]" min="1" max="6" placeholder="3" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 text-center"></td>
                        <td class="px-2 py-1.5 text-center"><button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-times"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="button" onclick="addKlaimMKRow()" class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-800 font-medium"><i class="fas fa-plus-circle"></i> Tambah Mata Kuliah</button>
        <input type="hidden" name="klaimMataKuliahString" id="klaimMataKuliahString">
    </div>
</div>

<!-- Submit -->
<div class="flex gap-3 pb-6">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl text-sm transition shadow-sm flex items-center gap-2">
        <i class="fas fa-paper-plane"></i> Kirim Pengajuan
    </button>
    <a href="dashboard-mahasiswa.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-8 py-3 rounded-xl text-sm transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Batal
    </a>
</div>

</form>
</main>
</div>
</div>

<script>
document.getElementById('tahunForm').textContent = new Date().getFullYear();

function toggleProgramSpecificFields() {
    const p = document.getElementById('program-dropdown').value;
    document.getElementById('membangunDesaSection').classList.toggle('hidden', p !== 'Membangun Desa / Kuliah Kerja Nyata Tematik');
    document.getElementById('pertukaranSection').classList.toggle('hidden', p !== 'Pertukaran Pelajar');
    document.getElementById('posisiRow').classList.toggle('hidden', p !== 'Magang Praktik Kerja');
}

function removeRow(btn) {
    const tbody = btn.closest('tr').parentElement;
    if (tbody.rows.length > 1) btn.closest('tr').remove();
    else Swal.fire({ title: 'Perhatian', text: 'Minimal harus ada satu baris.', icon: 'info', confirmButtonColor: '#3b82f6' });
}

function mkRowHtml(prefix) {
    return `<tr>
        <td class="px-2 py-1.5"><input type="text" name="${prefix}KodeMK[]" placeholder="MK001" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500"></td>
        <td class="px-2 py-1.5"><input type="text" name="${prefix}NamaMK[]" placeholder="Nama Mata Kuliah" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500"></td>
        <td class="px-2 py-1.5"><input type="number" name="${prefix}SKS[]" min="1" max="6" placeholder="3" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 text-center"></td>
        <td class="px-2 py-1.5 text-center"><button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-times"></i></button></td>
    </tr>`;
}
function addPertukaranMKRow() { document.getElementById('pertukaranMKBody').insertAdjacentHTML('beforeend', mkRowHtml('pertukaran')); }
function addKlaimMKRow()      { document.getElementById('klaimMKBody').insertAdjacentHTML('beforeend', mkRowHtml('klaim')); }

function buildMKString(kodeN, namaN, sksN) {
    const k = document.getElementsByName(kodeN), n = document.getElementsByName(namaN), s = document.getElementsByName(sksN);
    const arr = [];
    for (let i = 0; i < k.length; i++) {
        const kv = k[i].value.trim(), nv = n[i].value.trim(), sv = s[i].value.trim();
        if (kv || nv || sv) arr.push(`${kv}|${nv}|${sv}`);
    }
    return arr.join(',');
}

function buildDurasiAndMK() {
    const mulai = document.getElementById('tanggalMulai').value;
    const selesai = document.getElementById('tanggalSelesai').value;
    if (!mulai || !selesai) {
        Swal.fire({ title: 'Durasi Belum Diisi', text: 'Tanggal mulai dan selesai harus diisi.', icon: 'warning', confirmButtonColor: '#3b82f6' });
        return false;
    }
    if (new Date(selesai) < new Date(mulai)) {
        Swal.fire({ title: 'Tanggal Tidak Valid', text: 'Tanggal selesai tidak boleh sebelum tanggal mulai.', icon: 'error', confirmButtonColor: '#3b82f6' });
        return false;
    }
    const fmt = d => { const p = d.split('-'); return `${p[2]}/${p[1]}/${p[0]}`; };
    document.getElementById('durasiHidden').value = `${fmt(mulai)} s/d ${fmt(selesai)}`;
    document.getElementById('mataKuliahPertukaranString').value = buildMKString('pertukaranKodeMK[]','pertukaranNamaMK[]','pertukaranSKS[]');
    document.getElementById('klaimMataKuliahString').value = buildMKString('klaimKodeMK[]','klaimNamaMK[]','klaimSKS[]');
    return true;
}
</script>
</body>
</html>
