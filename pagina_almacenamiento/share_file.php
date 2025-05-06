<?php
session_start();
require_once "../conexion.php";

$id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['file'], $data['recipient'])) {
    $recipientEmail = $data['recipient'];
    $file = realpath($data['file']);

    // Verificar si la ruta del archivo es válida
    if (!$file) {
        echo json_encode(['message' => 'El archivo o carpeta especificado no es válido.']);
        exit;
    }

    // Verificar si el archivo pertenece al usuario o está compartido con él
    $stmt = $conn->prepare("SELECT file_path FROM shared_files WHERE (shared_with_id = ? OR owner_id = ?) AND file_path = ?");
    $stmt->bind_param("iis", $id, $id, $file);
    $stmt->execute();
    $result = $stmt->get_result();

    if (strpos($file, "/mvmup_stor/$id/") === 0 || $result->num_rows > 0) {
        // Obtener el ID del destinatario a partir de su correo
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

        // Registrar la compartición en la tabla `shared_files`
        $stmt = $conn->prepare("INSERT INTO shared_files (owner_id, shared_with_id, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id, $recipientId, $file);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Archivo o carpeta compartida con éxito']);
        } else {
            echo json_encode(['message' => 'Error al compartir el archivo o carpeta']);
        }
    } else {
        echo json_encode(['message' => 'No tienes permiso para compartir este archivo o carpeta']);
    }
}

$conn->close();
?>