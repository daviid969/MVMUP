<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$file = $data['file'];
$id = $_SESSION['id']; // Obtener el ID del usuario actual

if (!$file) {
    echo json_encode(['success' => false, 'error' => 'No se especificó el archivo o carpeta a eliminar.']);
    exit;
}

// Construir la ruta completa basada en el ID del usuario
$base_directory = "/mvmup/$id";
$fullPath = realpath($base_directory . '/' . ltrim($file, '/'));

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

// Verificar que la ruta sea válida y esté dentro del directorio del usuario
if (strpos($fullPath, realpath($base_directory)) !== 0 || !file_exists($fullPath)) {
    echo json_encode(['success' => false, 'error' => 'El archivo o carpeta no existe o acceso no permitido.']);
    exit;
}

if (deleteFolderRecursively($fullPath)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el archivo o carpeta.']);
}
?>