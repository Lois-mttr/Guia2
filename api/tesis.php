<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../models/TesisModel.php';

$model = new TesisModel();
$method = $_SERVER['REQUEST_METHOD'];

function jsonBody() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function respond($status, $payload = null) {
    http_response_code($status);
    if ($payload !== null) {
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    }
    exit();
}

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                $tesis = $model->getById((int)$_GET['id']);
                if (!$tesis) {
                    respond(404, ['message' => 'Tesis no encontrada']);
                }
                respond(200, $tesis);
            }
            respond(200, $model->getAll());

        case 'POST':
            $data = jsonBody();
            if (empty($data['titulo']) || empty($data['estudiante_id'])) {
                respond(400, ['message' => 'titulo y estudiante_id son obligatorios']);
            }
            $model->create($data);
            respond(201, ['message' => 'Tesis creada']);

        case 'PUT':
            $data = jsonBody();
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $estados = ['propuesta', 'aprobado', 'rechazado', 'finalizado'];
            if ($id <= 0 || empty($data['estado']) || !in_array($data['estado'], $estados, true)) {
                respond(400, ['message' => 'id y estado válido son obligatorios']);
            }
            if (!$model->getById($id)) {
                respond(404, ['message' => 'Tesis no encontrada']);
            }
            $model->update($id, $data['estado']);
            respond(200, ['message' => 'Tesis actualizada']);

        case 'DELETE':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id <= 0) {
                respond(400, ['message' => 'id es obligatorio']);
            }
            if (!$model->getById($id)) {
                respond(404, ['message' => 'Tesis no encontrada']);
            }
            $model->delete($id);
            respond(204);

        default:
            header('Allow: GET, POST, PUT, DELETE');
            respond(405, ['message' => 'Método no permitido']);
    }
} catch (PDOException $e) {
    respond(500, ['message' => 'Error interno del servidor']);
}
