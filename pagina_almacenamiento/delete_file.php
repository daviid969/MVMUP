<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$file = $data['file'];
$id = $_SESSION['id'];

if (!$file) {
    echo json_encode(['success' => false, 'error' => 'No se especificó el archivo o carpeta a eliminar.']);
    exit;
}

$base_directory = "/mvmup_stor/$id";
$fullPath = realpath($base_directory . '/' . ltrim($file, '/'));

// Depuración: Verificar rutas y permisos
if (!file_exists($fullPath)) {
    echo json_encode(['success' => false, 'error' => 'Ruta no encontrada: ' . $fullPath]);
    exit;
}
if (!is_writable($fullPath)) {
    echo json_encode(['success' => false, 'error' => 'No se puede escribir en la ruta: ' . $fullPath]);
    exit;
}

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

if (deleteFolderRecursively($fullPath)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el archivo o carpeta.']);
}
?>