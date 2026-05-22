<?php
// Script to fix all broken profile and change-password links in all views
$directory = new RecursiveDirectoryIterator(__DIR__ . '/views');
$iterator = new RecursiveIteratorIterator($directory);
$files = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
foreach ($files as $file) {
    $filePath = $file[0];
    
    // We only want to replace in depth-2 files (e.g. views/mhs/dashboard.php)
    // because depth-1 files (like views/rekap.php) might have different relative paths
    $relativePath = str_replace(__DIR__ . '\\views\\', '', $filePath);
    $parts = explode('\\', $relativePath);
    
    if (count($parts) >= 2) {
        $content = file_get_contents($filePath);
        $newContent = $content;
        
        // Fix profile.php links
        $newContent = str_replace('"profile.php"', '"../profil/profile.php"', $newContent);
        $newContent = str_replace("'profile.php'", "'../profil/profile.php'", $newContent);
        
        // Fix change-password.php links
        $newContent = str_replace('"change-password.php?', '"../profil/change-password.php?', $newContent);
        $newContent = str_replace("'change-password.php?", "'../profil/change-password.php?", $newContent);

        if ($content !== $newContent) {
            file_put_contents($filePath, $newContent);
            $count++;
            echo "Updated: " . $relativePath . "<br>";
        }
    }
}

// Move change-password.php from admin to profil if it exists
$adminCP = __DIR__ . '/views/admin/change-password.php';
$profilCP = __DIR__ . '/views/profil/change-password.php';

if (file_exists($adminCP)) {
    rename($adminCP, $profilCP);
    echo "Moved change-password.php from admin to profil.<br>";
}

echo "Done! Total files updated: $count";
?>
