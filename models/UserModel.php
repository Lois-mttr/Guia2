<?php
require_once __DIR__ . '/../config/Database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create($nombre, $correo, $password, $rol = 'estudiante') {
        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nombre, $correo, $password, $rol]);
    }

    public function registerFailedAttempt($id) {
        $stmt = $this->db->prepare(
            "UPDATE usuarios
             SET login_intentos_fallidos = login_intentos_fallidos + 1,
                 login_bloqueado = CASE WHEN login_intentos_fallidos + 1 >= 3 THEN 1 ELSE login_bloqueado END
             WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }

    public function resetFailedAttempts($id) {
        $stmt = $this->db->prepare(
            "UPDATE usuarios SET login_intentos_fallidos = 0, login_bloqueado = 0 WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }
}
