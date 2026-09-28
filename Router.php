<?php
class Router {
    protected $routes = [];

    public function add($method, $uri, $controller) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'uri' => $uri,
            'action' => $controller,
        ];
    }

    public function handle($method, $uri) {
        $path = parse_url($uri, PHP_URL_PATH);
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['uri'] === $path) {
                return call_user_func($route['action']);
            }
        }
        http_response_code(404);
        echo '404 - Recurso no encontrado';
    }
}
