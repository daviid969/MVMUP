<?php
session_start();

$id = $_SESSION['id'];

if (isset($_GET['file'])) {
    $base_directory = realpath("/mvmup_stor/$id");
    $file = realpath($base_directory . '/' . ltrim($_GET['file'], '/'));

    header('Content-Type: application/json');
    
    if ($file && strpos($file, $base_directory) === 0 && file_exists($file)) {
       
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
        echo json_encode(['success' => false, 'message' => 'No tienes permiso para descargar este archivo.']);
        exit;
    }
} else {
    http_response_code(400);
    echo "Archivo no especificado.";
    exit;
}
?>
