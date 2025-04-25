<?php
session_start();
$id = $_SESSION['id'];
$base_directory = "/mvmup_stor/$id";
$path = isset($_GET['path']) ? $_GET['path'] : '';
$directory = realpath($base_directory . '/' . $path);

if (strpos($directory, realpath($base_directory)) !== 0) {
    echo json_encode(['error' => 'Acceso no permitido']);
    exit;
}

$files = array_diff(scandir($directory), array('.', '..'));
$result = [];

foreach ($files as $file) {
    $file_path = $directory . '/' . $file;
    $result[] = [
        'name' => $file,
        'is_dir' => is_dir($file_path),
        'path' => $path . '/' . $file
    ];
}

echo json_encode($result);
?>