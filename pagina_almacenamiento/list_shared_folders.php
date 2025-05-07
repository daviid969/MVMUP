<?php
session_start();
require_once "../conexion.php";

if (!isset($_SESSION['id'])) {
    die(json_encode(["error" => "Usuario no autenticado."]));
}

$user_id = $_SESSION['id'];
$base_directory = "/mvmup_stor_shared";
$path = isset($_GET['path']) ? $_GET['path'] : '';
$directory = realpath($base_directory . '/' . $path);

if (!$directory || strpos($directory, realpath($base_directory)) !== 0) {
    echo json_encode(['error' => 'Acceso no permitido']);
    exit;
}

if (!is_dir($directory)) {
    echo json_encode(['error' => 'La carpeta compartida no existe']);
    exit;
}

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

header('Content-Type: application/json');
echo json_encode($result);
?>