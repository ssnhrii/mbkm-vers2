<?php
// views/partials/header.php
// Requires: $data['nama_lengkap'], $data['nim_nik'], $pageTitle
// Optional: $profileUrl, $changePasswordUrl
$user = $currentUser ?? $data ?? [];
$profileUrl        = $profileUrl        ?? '../profil/profile.php';
$changePasswordUrl = $changePasswordUrl ?? 'change-password.php?data=' . ($user['nim_nik'] ?? '');
$pageTitle         = $pageTitle         ?? 'Sistem Informasi MBKM';
?>
<header class="bg-white/80 backdrop-blur-md border-b border-slate-200/80 h-16 flex items-center justify-between px-6 sticky top-0 z-30">
    <!-- Left: Hamburger + Title -->
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-slate-800 hover:bg-slate-100 p-2 rounded-xl focus:outline-none transition">
            <i class="fas fa-bars text-lg"></i>
        </button>
        <h1 class="text-sm font-semibold text-slate-800 hidden sm:block tracking-wide"><?= htmlspecialchars($pageTitle) ?></h1>
    </div>

    <!-- Right: User dropdown -->
    <div class="relative">
        <button onclick="toggleUserMenu()" id="userMenuBtn"
            class="flex items-center gap-2.5 text-sm text-slate-700 hover:text-slate-900 focus:outline-none bg-slate-50 hover:bg-slate-100/80 px-3 py-1.5 rounded-xl border border-slate-200/60 transition duration-200">
            <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center text-white text-xs font-bold border border-white shadow-sm">
                <?= strtoupper(substr($user['nama_lengkap'] ?? 'U', 0, 1)) ?>
            </div>
            <span class="hidden sm:block font-semibold text-slate-700 text-xs"><?= htmlspecialchars($user['nama_lengkap'] ?? 'User') ?></span>
            <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
        </button>

        <!-- Dropdown -->
        <div id="userMenu"
            class="hidden absolute right-0 mt-2.5 w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-slate-100/90 py-1.5 z-50 transform origin-top-right transition-all animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="px-4 py-3 border-b border-slate-100">
                <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Login sebagai</p>
                <p class="text-xs font-bold text-slate-800 truncate mt-0.5"><?= htmlspecialchars($user['nama_lengkap'] ?? '') ?></p>
            </div>
            <div class="p-1">
                <a href="<?= htmlspecialchars($profileUrl) ?>"
                    class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-600 rounded-xl transition">
                    <i class="fas fa-user-circle text-base text-slate-400"></i> Profil Saya
                </a>
                <a href="<?= htmlspecialchars($changePasswordUrl) ?>"
                    class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-600 rounded-xl transition">
                    <i class="fas fa-shield-halved text-base text-slate-400"></i> Ganti Password
                </a>
            </div>
            <div class="border-t border-slate-100 my-1"></div>
            <div class="p-1">
                <a href="../../controllers/logout.php"
                    class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 rounded-xl transition"
                    onclick="return confirmLogout(event, this.href)">
                    <i class="fas fa-right-from-bracket text-base"></i> Keluar
                </a>
            </div>
        </div>
    </div>
</header>

<script>
function toggleUserMenu() {
    document.getElementById('userMenu').classList.toggle('hidden');
}
document.addEventListener('click', function(e) {
    const btn = document.getElementById('userMenuBtn');
    const menu = document.getElementById('userMenu');
    if (menu && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
function confirmLogout(e, href) {
    e.preventDefault();
    Swal.fire({
        title: 'Keluar?',
        text: 'Anda akan keluar dari sesi ini.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (result.isConfirmed) window.location.href = href;
    });
    return false;
}
</script>
