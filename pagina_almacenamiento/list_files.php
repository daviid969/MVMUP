<?php
session_start();
require_once "../conexion.php"; // Conexión a la base de datos

$id = $_SESSION['id'];
$base_directory = "/mvmup_stor/$id";
$path = isset($_GET['path']) ? $_GET['path'] : '';
$directory = realpath($base_directory . '/' . $path);

if (strpos($directory, realpath($base_directory)) !== 0) {
    echo json_encode(['error' => 'Acceso no permitido']);
    exit;
}

// Verificar que la carpeta del usuario exista
if (!is_dir($base_directory)) {
    echo json_encode(['error' => 'La carpeta del usuario no existe']);
    exit;
}

// Obtener archivos propios del usuario
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

// Obtener archivos compartidos con el usuario desde la tabla `shared_files`
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

// Devolver la lista de archivos y carpetas como JSON
echo json_encode($result);

$conn->close();
?>