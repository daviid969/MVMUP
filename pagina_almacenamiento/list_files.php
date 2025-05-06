<?php
session_start();
require_once "../conexion_comparticion.php"; // Conexión a la base de datos de compartición

$id = $_SESSION['id'];
$base_directory = "/mvmup_stor/$id";
$path = isset($_GET['path']) ? $_GET['path'] : '';
$directory = realpath($base_directory . '/' . $path);

if (strpos($directory, realpath($base_directory)) !== 0) {
    echo json_encode(['error' => 'Acceso no permitido']);
    exit;
}

// Obtener archivos propios
$ownFiles = array_diff(scandir($directory), array('.', '..'));
$result = [];

foreach ($ownFiles as $file) {
    $file_path = $directory . '/' . $file;
    $result[] = [
        'name' => $file,
        'is_dir' => is_dir($file_path),
        'path' => $path . '/' . $file,
        'shared' => false
    ];
}

// Obtener archivos compartidos
$stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE shared_with_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$sharedFiles = $stmt->get_result();

while ($row = $sharedFiles->fetch_assoc()) {
    $sharedPath = $row['file_path'];
    $result[] = [
        'name' => basename($sharedPath),
        'is_dir' => is_dir($sharedPath),
        'path' => $sharedPath,
        'shared' => true
    ];
}

echo json_encode($result);

$conn->close();
?>