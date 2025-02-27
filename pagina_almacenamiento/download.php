<?php
$sql="select * from usuarios where id ='".$_GET["id"]."' ";
$usuario = $_GET["id"];
$nombre_carpeta = "/mvmup_stor/".$usuario."";

if(!is_dir($nombre_carpeta)){
@mkdir($nombre_carpeta, 0700);
}
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filepath = "/mvmup_stor/".$usuario."" . $file;

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