<?php
require_once "../inicio_sesion/inicio_sesion.php";
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filepath = "/mvmup_stor/$sesion_email" . $file;

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        http_response_code(404);
        echo "Archivo no encontrado.";
    }
}
?>