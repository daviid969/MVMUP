<?php
session_start();
require_once "../conexion.php";

if (!isset($_SESSION['id'])) {
    die(json_encode(["error" => "Usuario no autenticado."]));
}

$user_id = $_SESSION['id'];

// Obtener las carpetas o archivos compartidos con el usuario desde la base de datos
$stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE shared_with_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$folder_list = [];
while ($row = $result->fetch_assoc()) {
    $folder_path = $row['file_path'];
    if (is_dir($folder_path)) {
        $folder_list[] = [
            "name" => basename($folder_path),
            "path" => $folder_path
        ];
    }
}

header('Content-Type: application/json');
if (empty($folder_list)) {
    echo json_encode(["error" => "No se encontraron carpetas compartidas."]);
} else {
    echo json_encode($folder_list);
}

$conn->close();
?>