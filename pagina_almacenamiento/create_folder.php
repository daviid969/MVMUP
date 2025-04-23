<?php
session_start();

$id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['folder'])) {
    $folder = "/mvmup_stor/$id/" . basename($data['folder']);
    
    if(!file_exists($folder)) {
        if(mkdir($folder, 0777, true)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'No se pudo crear la carpeta']);
        }
    } else {
        echo json_encode(['error' => 'La carpeta ya existe']);
    }
}
?>
