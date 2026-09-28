<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private function startSecureSession() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start([
                'cookie_httponly' => true,
                'cookie_secure' => false, // Cambiar a true en producción con HTTPS.
                'cookie_samesite' => 'Lax',
            ]);
        }
    }

    public function login() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $userModel = new UserModel();
            $user = $userModel->getByEmail($email);

            if ($user && (int)$user['login_bloqueado'] === 1) {
                $error = 'Cuenta bloqueada después de 3 intentos fallidos.';
            } elseif ($user && password_verify($password, $user['password'])) {
                $userModel->resetFailedAttempts($user['id']);
                $this->startSecureSession();
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_role'] = $user['rol'];
                header('Location: /dashboard');
                exit();
            } else {
                if ($user) {
                    $userModel->registerFailedAttempt($user['id']);
                }
                $error = 'Credenciales inválidas';
            }
        }

        include __DIR__ . '/../views/login.php';
    }

    public function register() {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $correo = filter_var($_POST['correo'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if ($nombre === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $error = 'Nombre y correo válido son obligatorios.';
            } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
                $error = 'La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.';
            } else {
                try {
                    $model = new UserModel();
                    $model->create($nombre, $correo, password_hash($password, PASSWORD_DEFAULT));
                    $success = 'Usuario registrado correctamente.';
                } catch (PDOException $e) {
                    $error = 'No fue posible registrar el usuario. Verifique que el correo no esté registrado.';
                }
            }
        }

        include __DIR__ . '/../views/register.php';
    }

    public function logout() {
        $this->startSecureSession();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: /login');
        exit();
    }
}
