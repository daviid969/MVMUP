
<?php
session_start();
$id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['file'], $data['recipient'])) {
    $source = "/mvmup_stor/$id/" . basename($data['file']);
    $dest = "/mvmup_stor/{$data['recipient']}/shared_" . basename($data['file']);
    
    if(!file_exists($source)) {
        echo json_encode(['message' => 'Archivo no encontrado']);
        exit;
    }
    
    if(!copy($source, $dest)) {
        echo json_encode(['message' => 'Error al compartir']);
    } else {
        echo json_encode(['message' => 'Archivo compartido con exito']);
    }
}
?>
