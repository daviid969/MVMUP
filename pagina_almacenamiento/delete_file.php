<?php
session_start();
require_once "../conexion.php";

header('Content-Type: application/json');

// Leer los datos enviados por el cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibió el archivo
if (!isset($data['file']) || empty($data['file'])) {
    echo json_encode(['success' => false, 'error' => 'No se especificó el archivo o carpeta a eliminar.']);
    exit;
}

$file = realpath($data['file']);
$id = $_SESSION['id'];

// Verificar si el archivo es válido
if (!$file) {
    echo json_encode(['success' => false, 'error' => 'El archivo especificado no es válido.']);
    exit;
}

// Verificar si el archivo pertenece al usuario o está compartido con él
$stmt = $conn->prepare("SELECT file_path, owner_id FROM shared_files WHERE (shared_with_id = ? OR owner_id = ?) AND file_path = ?");
$stmt->bind_param("iis", $id, $id, $file);
$stmt->execute();
$result = $stmt->get_result();

if (strpos($file, "/mvmup_stor/$id/") === 0 || $result->num_rows > 0) {
    // Función para eliminar archivos/carpetas
    function deleteFolderRecursively($folder) {
        if (!is_dir($folder)) {
            return unlink($folder);
        }

        $items = array_diff(scandir($folder), ['.', '..']);
        foreach ($items as $item) {
            $itemPath = $folder . DIRECTORY_SEPARATOR . $item;
            if (is_dir($itemPath)) {
                deleteFolderRecursively($itemPath);
            } else {
                unlink($itemPath);
            }
        }
        return rmdir($folder);
    }

    if (deleteFolderRecursively($file)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el archivo o carpeta.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No tienes permiso para eliminar este archivo o carpeta.']);
}
?>