<?php
session_start();

$id = $_SESSION['id'];

if (isset($_GET['file'])) {
    $file = realpath($_GET['file']);
    $base_directory = realpath("/mvmup_stor/$id");

    // Validar si el archivo está dentro del directorio base del usuario
    if ($file && strpos($file, $base_directory) === 0 && file_exists($file)) {
        // Configurar cabeceras para la descarga
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));

        // Leer y enviar el archivo
        readfile($file);
        exit;
    } else {
        http_response_code(403);
        echo "No tienes permiso para descargar este archivo.";
        exit;
    }
} else {
    http_response_code(400);
    echo "Archivo no especificado.";
    exit;
}
?>
