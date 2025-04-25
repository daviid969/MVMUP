<?php
session_start();
$id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['file'])) {
    $base_directory = "/mvmup_stor/$id";
    $file = realpath($base_directory . '/' . $data['file']);

    if (strpos($file, realpath($base_directory)) !== 0) {
        echo json_encode(['error' => 'Acceso no permitido']);
        exit;
    }

    if (file_exists($file)) {
        is_dir($file) ? rmdir($file) : unlink($file);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Archivo no encontrado']);
    }
}
?>