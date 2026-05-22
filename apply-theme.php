<?php
// Script to apply style-global.css to all dashboard pages
$directory = new RecursiveDirectoryIterator(__DIR__ . '/views');
$iterator = new RecursiveIteratorIterator($directory);
$files = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
$excludedFiles = ['login.php', 'registrasi.php', 'lupa-password.php', 'style-awal.css'];

foreach ($files as $file) {
    $filePath = $file[0];
    $fileName = basename($filePath);
    
    // Don't touch auth pages, let them keep their own styles for now
    if (in_array($fileName, $excludedFiles)) continue;
    
    $content = file_get_contents($filePath);
    $newContent = $content;
    
    // Replace specific dashboard css links
    $cssToReplace = [
        'style-dashboard-mahasiswa.css',
        'style-dashboard-dosen.css',
        'style-dashboard-admin.css',
        'style-data-dosen.css',
        'style-rekap-pengajuan.css',
        'style-edit.css',
        'style-edit-dosen.css',
        'style-profile.css',
        'style-formulir.css',
        'style-pengajuan.css',
        'style-rekap.css',
        'style-daftar-dosen.css',
        'style-edit-profile.css'
    ];
    
    foreach ($cssToReplace as $css) {
        $newContent = str_replace($css, 'style-global.css', $newContent);
    }
    
    // Also inject font-awesome from CDN if it's missing (it's required for the sidebar)
    if (strpos($newContent, 'font-awesome') === false && strpos($newContent, 'fontawesome') === false) {
        $fontAwesome = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />';
        $newContent = str_replace('</head>', "    $fontAwesome\n</head>", $newContent);
    }

    if ($content !== $newContent) {
        file_put_contents($filePath, $newContent);
        $count++;
        echo "Applied global theme to: " . str_replace(__DIR__, '', $filePath) . "\n";
    }
}

echo "Done! Total files themed: $count\n";
?>
