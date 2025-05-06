<?php
session_start();
require_once "../conexion.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$file = realpath($data['file']);
$id = $_SESSION['id'];

if (!$file) {
    echo json_encode(['success' => false, 'error' => 'No se especificó el archivo o carpeta a eliminar.']);
    exit;
}

// Verificar si el archivo pertenece al usuario o está compartido con él
$stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE shared_with_id = ? AND file_path = ?");
$stmt->bind_param("is", $id, $file);
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