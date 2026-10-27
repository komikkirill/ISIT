<?php

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function view(string $template, array $data = []): void {
    extract($data);
    
    // Путь к шаблону страницы (например, home.php)
    $contentPath = __DIR__ . '/Views/' . $template . '.php';
    
    // Проверяем, существует ли шаблон
    if (!file_exists($contentPath)) {
        die("Ошибка: Шаблон '$template' не найден по пути: $contentPath");
    }
    
    // Включаем буферизацию (чтобы сохранить HTML страницы в переменную)
    ob_start();
    require $contentPath;
    $content = ob_get_clean();
    
    // Подключаем общий каркас (main.php)
    require __DIR__ . '/Views/layout/main.php';
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function notFound(): void {
    http_response_code(404);
    view('errors/404');
    exit;
}

function config(string $key, $default = null) {
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../config/app.php';
    }
    return $config[$key] ?? $default;
}