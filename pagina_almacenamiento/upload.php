<?php
session_start();

$id = $_SESSION['id'];

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $base_directory = "/mvmup_stor/$id";
    $path = isset($_POST['path']) ? $_POST['path'] : '';
    $target_dir = realpath($base_directory) . '/' . trim($path, '/');
    
    // Verificar que la ruta sea válida
    if (strpos($target_dir, realpath($base_directory)) !== 0) {
        echo json_encode(["success" => false, "message" => "Acceso no permitido"]);
        exit;
    }

    // Crear el archivo de destino
    $target_file = $target_dir . '/' . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        echo json_encode(["success" => false, "message" => "El archivo ya existe"]);
        exit;
    }

    // Verificar el tamaño del archivo (límite: 50MB)
    if ($_FILES["fileToUpload"]["size"] > 50 * 1024 * 1024) {
        echo json_encode(["success" => false, "message" => "Tu archivo supera el límite de 50MB."]);
        exit;
    }

    // Subir el archivo
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo json_encode(["success" => true, "message" => "El archivo " . basename($_FILES["fileToUpload"]["name"]) . " ha sido subido con éxito."]);
    } else {
        echo json_encode(["success" => false, "message" => "Hubo un error al subir tu archivo."]);
    }
}
?>