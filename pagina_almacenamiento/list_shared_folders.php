<?php
session_start();
require_once "../conexion.php";

if (!isset($_SESSION['id'])) {
    die(json_encode(["error" => "Usuario no autenticado."]));
}

$user_id = $_SESSION['id'];
$base_directory = "/mvmup_stor"; // Directorio base para usuarios
$path = isset($_GET['path']) ? $_GET['path'] : '';
$directory = realpath($base_directory . '/' . ltrim($path, '/'));

// Validar que la ruta sea válida y esté compartida con el usuario
$stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE shared_with_id = ? AND file_path = ?");
$stmt->bind_param("is", $user_id, $directory);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0 || !$directory || strpos($directory, realpath($base_directory)) !== 0) {
    echo json_encode(['error' => 'Acceso no permitido o carpeta no compartida.']);
    exit;
}

// Listar el contenido de la carpeta
if (is_dir($directory)) {
    $items = array_diff(scandir($directory), ['.', '..']);
    $shared_items = [];

    foreach ($items as $item) {
        $item_path = $directory . '/' . $item;
        $shared_items[] = [
            "name" => $item,
            "path" => $path . '/' . $item,
            "is_dir" => is_dir($item_path)
        ];
    }

    echo json_encode($shared_items);
} else {
    echo json_encode(['error' => 'La carpeta no existe o no es válida.']);
}

$conn->close();
?>