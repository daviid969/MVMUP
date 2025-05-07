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

    // Excluir archivos que están en la tabla `shared_files`
    $stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE file_path = ? AND owner_id = ?");
    $stmt->bind_param("si", $file_path, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) { // Solo incluir si no está compartido
        $result[] = [
            'name' => $file,
            'is_dir' => is_dir($file_path),
            'path' => $path . '/' . $file,
            'shared' => false
        ];
    }

    $stmt->close();
}

// Devolver la lista de archivos y carpetas como JSON
echo json_encode($result);

$conn->close();
?>