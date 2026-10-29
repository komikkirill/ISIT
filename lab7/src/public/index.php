<?php
// Автозагрузка классов
require __DIR__ . '/../app/autoload.php';

// Объявляем функции В ГЛОБАЛЬНОМ ПРОСТРАНСТВЕ (без namespace)
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function view($template, $data = []) {
    extract($data);
    $contentPath = __DIR__ . '/../app/Views/' . $template . '.php';
    
    if (file_exists($contentPath)) {
        ob_start();
        require $contentPath;
        $content = ob_get_clean();
        
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

// === НОВЫЕ ФУНКЦИИ ДЛЯ API ===
function json_response($data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function json_error(string $message, int $status = 400, array $errors = []): void {
    $response = ['error' => $message];
    if (!empty($errors)) {
        $response['errors'] = $errors;
    }
    json_response($response, $status);
}

function no_content(): void {
    http_response_code(204);
    exit;
}

function json_input(): array {
    $raw = file_get_contents('php://input');
    if (empty($raw)) return [];
    $data = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        json_error('Некорректный JSON', 400);
    }
    return $data ?? [];
}
// ==============================

// --- ЗАПУСК ПРИЛОЖЕНИЯ ---
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router = new App\Core\Router();
require __DIR__ . '/../routes/web.php';

try {
    $router->dispatch($method, $uri);
} catch (Throwable $e) {
    http_response_code(500);
    // Чтобы ошибки API возвращались в JSON, а не в HTML
    if (str_starts_with($uri, '/api/')) {
        json_error($e->getMessage(), 500);
    } else {
        view('errors/500', ['error' => $e]);
    }
}