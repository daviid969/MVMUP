<?php
session_start();
require_once "../conexion.php";

if (!isset($_SESSION['id'])) {
    die(json_encode(["error" => "Usuario no autenticado."]));
}

$user_id = $_SESSION['id'];
$base_directory = '/path/to/base/directory';

// Obtener las rutas de archivos y carpetas compartidos con el usuario
$stmt = $conn->prepare("
    SELECT file_path 
    FROM shared_files 
    WHERE shared_with_id = ? 
    AND (? = file_path OR ? LIKE CONCAT(file_path, '/%'))
");
$stmt->bind_param("iss", $user_id, $base_directory, $base_directory);
$stmt->execute();
$result = $stmt->get_result();

$shared_items = [];
while ($row = $result->fetch_assoc()) {
    $item_path = $row['file_path'];
    $shared_items[] = [
        "name" => basename($item_path),
        "path" => $item_path,
        "is_dir" => is_dir($item_path)
    ];
}

header('Content-Type: application/json');
if (empty($shared_items)) {
    echo json_encode(["error" => "No se encontraron archivos o carpetas compartidos."]);
} else {
    echo json_encode($shared_items);
}

$conn->close();
?>