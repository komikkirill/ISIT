<?php
// Автозагрузка классов
require __DIR__ . '/../app/autoload.php';

// Объявляем функции В ГЛОБАЛЬНОМ ПРОСТРАНСТВЕ (без namespace)
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function view($template, $data = []) {
    extract($data);
    // Путь к странице
    $contentPath = __DIR__ . '/../app/Views/' . $template . '.php';
    
    if (file_exists($contentPath)) {
        ob_start();
        require $contentPath;
        $content = ob_get_clean();
        
        // Путь к макету (main.php)
        $layoutPath = __DIR__ . '/../app/Views/layout/main.php';
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            die("Ошибка: Файл main.php не найден по пути: $layoutPath");
        }
    } else {
        die("Ошибка: Шаблон $template не найден по пути: $contentPath");
    }
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function notFound() {
    http_response_code(404);
    view('errors/404');
    exit;
}

function config($key, $default = null) {
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../config/app.php';
    }
    return $config[$key] ?? $default;
}

// --- ЗАПУСК ПРИЛОЖЕНИЯ ---
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router = new App\Core\Router();
require __DIR__ . '/../routes/web.php';

try {
    $router->dispatch($method, $uri);
} catch (Throwable $e) {
    http_response_code(500);
    view('errors/500', ['error' => $e]);
}