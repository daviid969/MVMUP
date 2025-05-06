<?php
session_start();
require_once "../config.php"; // Incluir el archivo de configuración

// Crear la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

function copyFolder($source, $dest) {
    if (!is_dir($dest)) {
        mkdir($dest, 0755, true);
    }

    foreach (scandir($source) as $item) {
        if ($item === '.' || $item === '..') continue;

        $srcPath = $source . DIRECTORY_SEPARATOR . $item;
        $destPath = $dest . DIRECTORY_SEPARATOR . $item;

        if (is_dir($srcPath)) {
            if (!copyFolder($srcPath, $destPath)) {
                return false; // Si falla en algún punto, devuelve false
            }
        } else {
            if (!copy($srcPath, $destPath)) {
                return false; // Si falla la copia de un archivo, devuelve false
            }
        }
    }
    return true; // Devuelve true si todo se copió correctamente
}

if (isset($data['file'], $data['recipient'])) {
    $recipientEmail = $data['recipient'];

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

    $source = realpath("/mvmup_stor/$id/" . ltrim($data['file'], '/'));
    $destBase = "/mvmup_stor/$recipientId";

    // Verificar que el directorio del destinatario existe
    if (!is_dir($destBase)) {
        mkdir($destBase, 0755, true);
    }

    $dest = $destBase . '/shared_' . basename($data['file']);

    // Verificar que la ruta fuente sea válida
    if (strpos($source, realpath("/mvmup_stor/$id")) !== 0 || !file_exists($source)) {
        echo json_encode(['message' => 'Archivo o carpeta no encontrada o acceso no permitido']);
        exit;
    }

    // Copiar archivo o carpeta
    if (is_dir($source)) {
        if (copyFolder($source, $dest)) {
            echo json_encode(['message' => 'Carpeta compartida con éxito']);
        } else {
            echo json_encode(['message' => 'Error al compartir la carpeta']);
        }
    } else {
        if (copy($source, $dest)) {
            echo json_encode(['message' => 'Archivo compartido con éxito']);
        } else {
            echo json_encode(['message' => 'Error al compartir el archivo']);
        }
    }
}

// Cerrar la conexión
$conn->close();
?>