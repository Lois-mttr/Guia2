<?php
require_once __DIR__ . '/../models/TesisModel.php';

class TesisController {
    private function requireLogin() {
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
    }

    public function index() {
        $this->requireLogin();
        $model = new TesisModel();
        $tesis = $model->getByStudent($_SESSION['user_id']);
        include __DIR__ . '/../views/tesis.php';
    }
}
