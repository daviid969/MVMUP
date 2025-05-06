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
    // Verificar que el directorio fuente existe
    if (!is_dir($source)) {
        error_log("El directorio fuente no existe: $source");
        return false;
    }

    // Crear el directorio de destino si no existe
    if (!is_dir($dest)) {
        if (!mkdir($dest, 0755, true)) {
            error_log("Error al crear el directorio de destino: $dest");
            return false;
        }
    }

    // Escanear el contenido del directorio fuente
    $items = scandir($source);
    if ($items === false) {
        error_log("Error al leer el directorio fuente: $source");
        return false;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $srcPath = $source . DIRECTORY_SEPARATOR . $item;
        $destPath = $dest . DIRECTORY_SEPARATOR . $item;

        // Si es un directorio, copiar recursivamente
        if (is_dir($srcPath)) {
            if (!copyFolder($srcPath, $destPath)) {
                error_log("Error al copiar la carpeta: $srcPath a $destPath");
                return false;
            }
        } else {
            // Si es un archivo, copiarlo
            if (!copy($srcPath, $destPath)) {
                error_log("Error al copiar el archivo: $srcPath a $destPath");
                return false;
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
        if (!mkdir($destBase, 0755, true)) {
            echo json_encode(['message' => 'Error al crear el directorio del destinatario']);
            exit;
        }
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