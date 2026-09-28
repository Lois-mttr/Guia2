<?php
class DashboardController {
    public function index() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start([
                'cookie_httponly' => true,
                'cookie_secure' => false,
                'cookie_samesite' => 'Lax',
            ]);
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        include __DIR__ . '/../views/dashboard.php';
    }
}
