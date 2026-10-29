<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void { $this->add('GET', $path, $handler); }
    public function post(string $path, array $handler): void { $this->add('POST', $path, $handler); }
    public function put(string $path, array $handler): void { $this->add('PUT', $path, $handler); }
    public function patch(string $path, array $handler): void { $this->add('PATCH', $path, $handler); }
    public function delete(string $path, array $handler): void { $this->add('DELETE', $path, $handler); }

    private function add(string $method, string $path, array $handler): void {
        $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function dispatch(string $method, string $uri): void {
        $path = parse_url($uri, PHP_URL_PATH);
        $allowedMethods = [];

        foreach ($this->routes as $route) {
            if (preg_match($route['pattern'], $path, $matches)) {
                $allowedMethods[] = $route['method'];
                
                if ($route['method'] === $method) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    [$controllerClass, $action] = $route['handler'];
                    
                                        // ВРЕМЕННАЯ ОТЛАДКА
                    if (!class_exists($controllerClass)) {
                        echo "ОШИБКА: Класс $controllerClass не найден!\n";
                    }
                    
                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass();
                        if (method_exists($controller, $action)) {
                            call_user_func_array([$controller, $action], $params);
                            return;
                        } else {
                            echo "ОШИБКА: Метод $action не найден в классе $controllerClass!\n";
                        }
                    }{
                        $controller = new $controllerClass();
                        if (method_exists($controller, $action)) {
                            call_user_func_array([$controller, $action], $params);
                            return;
                        }
                    }
                }
            }
        }

        if (!empty($allowedMethods)) {
            header('Allow: ' . implode(', ', array_unique($allowedMethods)));
            if (str_starts_with($path, '/api/')) {
                \json_error('Метод не поддерживается', 405);
            }
            http_response_code(405);
            echo "405 Method Not Allowed";
            exit;
        }

        if (str_starts_with($path, '/api/')) {
            \json_error('Ресурс не найден', 404);
        }
        notFound();
    }
}