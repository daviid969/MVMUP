
<?php
session_start();
$email = $_SESSION['email'];
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['file'], $data['recipient'])) {
    $source = "/mvmup_stor/$email/" . basename($data['file']);
    $dest = "/mvmup_stor/{$data['recipient']}/shared_" . basename($data['file']);
    
    if(!file_exists($source)) {
        echo json_encode(['message' => 'Archivo no encontrado']);
        exit;
    }
    
    if(!copy($source, $dest)) {
        echo json_encode(['message' => 'Error al compartir']);
    } else {
        echo json_encode(['message' => 'Archivo compartido con éxito']);
    }
}
?>
