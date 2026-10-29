<?php
spl_autoload_register(function ($class) {
    // Пространство имен проекта
    $prefix = 'App\\';
    
    // Базовая папка (это папка app)
    $base_dir = __DIR__ . '/';
    
    // Проверяем, начинается ли класс с App\
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    // Получаем имя класса без префикса (например, Controllers\HomeController)
    $relative_class = substr($class, $len);
    
    // Формируем путь к файлу (app/Controllers/HomeController.php)
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // Если файл существует — подключаем
    if (file_exists($file)) {
        require $file;
    }
});