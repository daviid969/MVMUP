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
        if (is_dir($file)) {
            // Eliminar carpeta y su contenido de forma recursiva
            deleteFolderRecursively($file);
            echo json_encode(['success' => true]);
        } else {
            // Eliminar archivo
            if (unlink($file)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'No se pudo eliminar el archivo.']);
            }
        }
    } else {
        echo json_encode(['error' => 'Archivo o carpeta no encontrado.']);
    }
}

function deleteFolderRecursively($folder) {
    $files = array_diff(scandir($folder), array('.', '..'));
    foreach ($files as $file) {
        $filePath = $folder . '/' . $file;
        if (is_dir($filePath)) {
            deleteFolderRecursively($filePath); // Llamada recursiva para subcarpetas
        } else {
            unlink($filePath); // Eliminar archivo
        }
    }
    rmdir($folder); // Eliminar la carpeta vacía
}
?>