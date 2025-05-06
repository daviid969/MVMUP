
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
    $source = realpath("/mvmup_stor/$id/" . ltrim($data['file'], '/'));
    $dest = "/mvmup_stor/{$data['recipient']}/shared_" . basename($data['file']);

    if (strpos($source, realpath("/mvmup_stor/$id")) !== 0 || !file_exists($source)) {
        echo json_encode(['message' => 'Archivo o carpeta no encontrada o acceso no permitido']);
        exit;
    }

    if (is_dir($source)) {
        copyFolder($source, $dest);
    } else {
        if (!copy($source, $dest)) {
            echo json_encode(['message' => 'Error al compartir el archivo']);
            exit;
        }
    }

    echo json_encode(['message' => 'Archivo o carpeta compartida con éxito']);
}
?>
