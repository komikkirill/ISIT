<?php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/'; // Это папка app
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // ВРЕМЕННАЯ ОТЛАДКА: выведем, какой файл мы ищем
    if (str_contains($class, 'Api')) {
        echo "<!-- Ищу файл: " . $file . " -->\n";
    }
    
    if (file_exists($file)) {
        require $file;
    }
});