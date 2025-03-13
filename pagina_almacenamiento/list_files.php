<?php
session_start();
if(!isset($_SESSION['email'])) {
    http_response_code(403);
    exit('Acceso no autorizado');
}

$email = $_SESSION['email'];

$directory = "/mvmup_stor/$email";
$files = array_diff(scandir($directory), array('.', '..'));

// Incluir archivos compartidos
$shared_directory = "/mvmup_stor/shared";
$shared_files = glob("$shared_directory/{$email}_*");
$shared_files = array_map(function($file) {
    return "shared/" . basename($file);
}, $shared_files);

$all_files = array_merge(array_values($files), $shared_files);

echo json_encode($all_files);
?>
