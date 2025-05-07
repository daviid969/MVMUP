<?php
session_start();
require_once "../conexion.php";

if (!isset($_SESSION['id'])) {
    die(json_encode(["error" => "Usuario no autenticado."]));
}

$user_id = $_SESSION['id'];
$base_directory = "/mvmup_stor"; // Directorio base para usuarios
$path = isset($_GET['path']) ? $_GET['path'] : '';
$directory = realpath($base_directory . '/' . $path);

// Obtener las rutas de archivos y carpetas compartidos con el usuario
$stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE shared_with_id = ? AND file_path LIKE CONCAT(?, '%')");
$stmt->bind_param("is", $user_id, $directory);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "No se encontraron archivos o carpetas compartidos."]);
    exit;
}

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
echo json_encode($shared_items);

$conn->close();
?>