<?php
// views/partials/sidebar-admin.php
// Requires: $activePage (dashboard|manajemen)
$active = $activePage ?? '';
?>
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-100 flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0 border-r border-slate-800/60 shadow-2xl">
    <!-- Logo -->
    <div class="flex items-center justify-center h-20 border-b border-slate-800/80 px-6 bg-slate-950/40">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-accent-600 to-emerald-400 flex items-center justify-center shadow-lg shadow-accent-500/20">
                <i class="fas fa-shield-halved text-white text-sm"></i>
            </div>
            <span class="text-lg font-bold tracking-tight bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent">MBKM Admin</span>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="dashboard-admin.php"
            class="group flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 relative
            <?= $active === 'dashboard' ? 'bg-accent-600 text-white shadow-lg shadow-accent-600/25' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' ?>">
            <i class="fas fa-grid-2 w-5 text-center text-base transition-transform group-hover:scale-110 <?= $active === 'dashboard' ? 'text-white' : 'text-slate-400 group-hover:text-accent-400' ?>"></i>
            <span>Dashboard</span>
            <?php if ($active === 'dashboard'): ?>
                <span class="absolute left-0 top-1/3 bottom-1/3 w-1 bg-white rounded-r-md"></span>
            <?php endif; ?>
        </a>
        
        <a href="data-dosen.php"
            class="group flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 relative
            <?= $active === 'manajemen' ? 'bg-accent-600 text-white shadow-lg shadow-accent-600/25' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' ?>">
            <i class="fas fa-users-gear w-5 text-center text-base transition-transform group-hover:scale-110 <?= $active === 'manajemen' ? 'text-white' : 'text-slate-400 group-hover:text-accent-400' ?>"></i>
            <span>Manajemen User</span>
            <?php if ($active === 'manajemen'): ?>
                <span class="absolute left-0 top-1/3 bottom-1/3 w-1 bg-white rounded-r-md"></span>
            <?php endif; ?>
        </a>
    </nav>

    <!-- Footer -->
    <div class="px-6 py-4 border-t border-slate-800/80 text-xs text-slate-500 font-medium text-center bg-slate-950/20">
        MBKM &copy; Polibatam <?= date('Y') ?>
    </div>
</aside>

<div id="sidebarOverlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden lg:hidden transition-all duration-300" onclick="toggleSidebar()"></div>
