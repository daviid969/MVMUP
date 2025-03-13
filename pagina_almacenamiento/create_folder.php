<?php
session_start();
if(!isset($_SESSION['email'])) {
    http_response_code(403);
    exit(json_encode(['error' => 'Acceso no autorizado']));
}

$email = $_SESSION['email'];
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['folder'])) {
    $folder = "/mvmup_stor/$email/" . basename($data['folder']);
    
    if(!file_exists($folder)) {
        if(mkdir($folder, 0755, true)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'No se pudo crear la carpeta']);
        }
    } else {
        echo json_encode(['error' => 'La carpeta ya existe']);
    }
} else {
    echo json_encode(['error' => 'Nombre de carpeta no proporcionado']);
}
?>
