<?php
session_start();
require_once "../conexion.php"; // Conexión a la base de datos

$id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['file'], $data['recipient'])) {
    $recipientEmail = $data['recipient'];

    // Obtener el ID del destinatario a partir de su correo en la tabla `usuarios`
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $recipientEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['message' => 'El destinatario no existe']);
        exit;
    }

    $recipientRow = $result->fetch_assoc();
    $recipientId = $recipientRow['id'];

    $filePath = "/mvmup_stor/$id/" . ltrim($data['file'], '/');

    // Verificar que el archivo o carpeta existe
    if (!file_exists($filePath)) {
        echo json_encode(['message' => 'Archivo o carpeta no encontrada']);
        exit;
    }

    // Registrar la compartición en la tabla `shared_files`
    $stmt = $conn->prepare("INSERT INTO shared_files (owner_id, shared_with_id, file_path) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $id, $recipientId, $filePath);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Archivo o carpeta compartida con éxito']);
    } else {
        echo json_encode(['message' => 'Error al compartir el archivo o carpeta']);
    }
}

$conn->close();
?>