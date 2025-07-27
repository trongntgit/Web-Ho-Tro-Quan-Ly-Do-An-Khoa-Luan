<?php
spl_autoload_register(function ($class) {
    // Namespace prefix
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';

    // Base directory for the namespace prefix
    $base_dir = __DIR__ . '/phpoffice/PhpSpreadsheet/src/';

    // Check if the class uses the namespace prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Get the relative class name
    $relative_class = substr($class, $len);

    // Replace namespace separators with directory separators in the relative class name
    // Append with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
