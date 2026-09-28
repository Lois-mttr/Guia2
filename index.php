<?php
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/TesisController.php';

$router = new Router();
$auth = new AuthController();
$dashboard = new DashboardController();
$tesis = new TesisController();

$router->add('GET', '/', function () {
    header('Location: /login');
    exit();
});
$router->add('GET', '/login', [$auth, 'login']);
$router->add('POST', '/login', [$auth, 'login']);
$router->add('GET', '/register', [$auth, 'register']);
$router->add('POST', '/register', [$auth, 'register']);
$router->add('GET', '/logout', [$auth, 'logout']);
$router->add('GET', '/dashboard', [$dashboard, 'index']);
$router->add('GET', '/tesis', [$tesis, 'index']);

$router->handle($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
