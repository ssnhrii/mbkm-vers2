<?php $this->layout('layouts/app', ['title' => $title ?? 'Student Dashboard']) ?>

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php include('partials/sidebar.php') ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <?php include('partials/header.php') ?>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            <?= $this->section('student_content') ?>
        </main>
    </div>
</div>

<?php $this->start('scripts') ?>
<script>
    // Toggle dropdown
    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    // Close dropdowns when clicking outside
    window.onclick = function(event) {
        if (!event.target.matches('button')) {
            const dropdowns = document.getElementsByClassName('dropdown');
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (!openDropdown.classList.contains('hidden')) {
                    openDropdown.classList.add('hidden');
                }
            }
        }
    }
</script>
<?= $this->section('student_scripts') ?>
<?php $this->end() ?>