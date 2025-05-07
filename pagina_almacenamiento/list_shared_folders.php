<?php
session_start();
require_once "../conexion.php";

if (!isset($_SESSION['id'])) {
    die(json_encode(["error" => "Usuario no autenticado."]));
}

$user_id = $_SESSION['id'];

// Obtener las rutas de archivos y carpetas compartidos con el usuario
$stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE shared_with_id = ?");
$stmt->bind_param("i", $user_id);
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

if (isset($_GET['folder_path'])) {
    $folder_path = realpath($_GET['folder_path']);
    if (strpos($folder_path, realpath("/mvmup_stor")) === 0 && is_dir($folder_path)) {
        $items = array_diff(scandir($folder_path), ['.', '..']);
        $result = [];
        foreach ($items as $item) {
            $item_path = $folder_path . DIRECTORY_SEPARATOR . $item;
            $result[] = [
                "name" => $item,
                "path" => $item_path,
                "is_dir" => is_dir($item_path)
            ];
        }
        echo json_encode($result);
        exit;
    }
    echo json_encode(["error" => "Acceso no permitido o carpeta no válida."]);
    exit;
}

header('Content-Type: application/json');
if (empty($shared_items)) {
    echo json_encode(["error" => "No se encontraron archivos o carpetas compartidos."]);
} else {
    echo json_encode($shared_items);
}

$conn->close();
?>