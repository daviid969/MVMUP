<?php
session_start();
$email = $_SESSION['email'];
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['file'])) {
    $file = "/mvmup_stor/$email/" . basename($data['file']);
    
    if(file_exists($file)) {
        is_dir($file) ? rmdir($file) : unlink($file);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Archivo no encontrado']);
    }
}
?>