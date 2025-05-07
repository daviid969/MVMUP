<?php
session_start();

$id = $_SESSION['id'];

if (isset($_GET['file'])) {
    $file = realpath($_GET['file']);
    $base_directory = realpath("/mvmup_stor/$id");

    // Validar si el archivo está dentro del directorio base del usuario
    if (strpos($file, $base_directory) === 0 && file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        http_response_code(403);
        echo "No tienes permiso para descargar este archivo.";
        exit;
    }
}
?>
