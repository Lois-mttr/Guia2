<?php
require_once __DIR__ . '/../config/Database.php';

class TesisModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM tesis ORDER BY id DESC")->fetchAll();
    }

    public function getByStudent($studentId) {
        $stmt = $this->db->prepare("SELECT * FROM tesis WHERE estudiante_id = ? ORDER BY id DESC");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tesis WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO tesis (titulo, descripcion, estudiante_id) VALUES (?, ?, ?)"
        );
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'] ?? null,
            $data['estudiante_id'],
        ]);
    }

    public function update($id, $estado) {
        $stmt = $this->db->prepare("UPDATE tesis SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tesis WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
