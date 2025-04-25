<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$file = $data['file'];

if (!$file) {
    echo json_encode(['success' => false, 'error' => 'No se especificó el archivo o carpeta a eliminar.']);
    exit;
}

$fullPath = __DIR__ . '/uploads/' . $file; // Ajusta la ruta según tu estructura

function deleteFolderRecursively($folder) {
    if (!is_dir($folder)) {
        return unlink($folder); // Eliminar archivo
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
    return rmdir($folder); // Eliminar la carpeta
}

if (deleteFolderRecursively($fullPath)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el archivo o carpeta.']);
}
?>