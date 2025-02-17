<?php
session_start();
require 'vendor/autoload.php'; // Incluir PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Configuración de la base de datos
$servername = "192.168.1.210";
$username = "mvmup_root";
$password = "mvmup@KC_IP_DE";
$dbname = "mvmup";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['new-username'];
    $nombre = $_POST['name'];
    $apellidos = $_POST['surname'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Generar un token único
    $token_verificacion = bin2hex(random_bytes(32));

    // Insertar usuario en la base de datos
    $sql = "INSERT INTO usuarios (username, nombre, apellidos, email, curso, password, token_verificacion, cuenta_verificada)
            VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $username, $nombre, $apellidos, $email, $curso, $password, $token_verificacion);

    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>
