<?php
$directory = new RecursiveDirectoryIterator('.');
$iterator = new RecursiveIteratorIterator($directory);
$regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$errors = 0;
foreach ($regex as $file) {
    $output = shell_exec('php -l "' . $file[0] . '" 2>&1');
    if (strpos($output, 'Errors parsing') !== false || strpos($output, 'Parse error') !== false) {
        echo $output . "\n";
        $errors++;
    }
}
if ($errors == 0) {
    echo "No syntax errors found.\n";
}
?>
