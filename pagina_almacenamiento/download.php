<?php
session_start();


$email = $_SESSION['email'];
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    
    if (strpos($file, 'shared/') === 0) {
        $filepath = "/mvmup_stor/" . $file;
    } else {
        $filepath = "/mvmup_stor/$email/" . $file;
    }

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
