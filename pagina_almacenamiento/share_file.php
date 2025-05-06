<?php
session_start();
$id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

function copyFolder($source, $dest) {
    if (!is_dir($dest)) {
        mkdir($dest, 0755, true);
    }

    foreach (scandir($source) as $item) {
        if ($item === '.' || $item === '..') continue;

        $srcPath = $source . DIRECTORY_SEPARATOR . $item;
        $destPath = $dest . DIRECTORY_SEPARATOR . $item;

        if (is_dir($srcPath)) {
            copyFolder($srcPath, $destPath);
        } else {
            copy($srcPath, $destPath);
        }
    }
}

if (isset($data['file'], $data['recipient'])) {
    $recipient = $data['recipient'];
    $source = realpath("/mvmup_stor/$id/" . ltrim($data['file'], '/'));
    $destBase = "/mvmup_stor/$recipient";

    // Verificar que el directorio del destinatario existe
    if (!is_dir($destBase)) {
        mkdir($destBase, 0755, true);
    }

    $dest = $destBase . '/shared_' . basename($data['file']);

    // Verificar que la ruta fuente sea válida
    if (strpos($source, realpath("/mvmup_stor/$id")) !== 0 || !file_exists($source)) {
        echo json_encode(['message' => 'Archivo o carpeta no encontrada o acceso no permitido']);
        exit;
    }

    // Copiar archivo o carpeta
    if (is_dir($source)) {
        if (copyFolder($source, $dest)) {
            echo json_encode(['message' => 'Carpeta compartida con éxito']);
        } else {
            echo json_encode(['message' => 'Error al compartir la carpeta']);
        }
    } else {
        if (copy($source, $dest)) {
            echo json_encode(['message' => 'Archivo compartido con éxito']);
        } else {
            echo json_encode(['message' => 'Error al compartir el archivo']);
        }
    }
}
?>