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

// Validar acceso
$stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE shared_with_id = ? AND file_path LIKE CONCAT(?, '%')");
$stmt->bind_param("is", $user_id, $directory);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0 || !$directory || strpos($directory, realpath($base_directory)) !== 0) {
    echo json_encode(['error' => 'Acceso no permitido']);
    exit;
}

// Obtener contenido de la carpeta compartida
if (is_dir($directory)) {
    $items = array_diff(scandir($directory), ['.', '..']);
    $result = [];

    foreach ($items as $item) {
        $item_path = $directory . '/' . $item;
        $result[] = [
            'name' => $item,
            'is_dir' => is_dir($item_path),
            'path' => $path . '/' . $item
        ];
    }

    echo json_encode($result);
} else {
    echo json_encode(['error' => 'La carpeta no existe o no es válida.']);
}

$conn->close();
?>