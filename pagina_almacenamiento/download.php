<?php
session_start();
require_once "../conexion.php";

$id = $_SESSION['id'];

if (isset($_GET['file'])) {
    $file = realpath($_GET['file']);
    $base_directory = realpath("/mvmup_stor/$id");

    // Verificar si el archivo pertenece al usuario o está compartido con él
    $stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE (shared_with_id = ? OR owner_id = ?) AND file_path = ?");
    $stmt->bind_param("iis", $id, $id, $file);
    $stmt->execute();
    $result = $stmt->get_result();

    // Validar si el archivo está dentro del directorio base del usuario o está compartido
    if ((strpos($file, $base_directory) === 0 && file_exists($file)) || $result->num_rows > 0) {
        if (file_exists($file)) {
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
            http_response_code(404);
            echo "Archivo no encontrado.";
            exit;
        }
    } else {
        http_response_code(403);
        echo "No tienes permiso para descargar este archivo.";
        exit;
    }
}
?>