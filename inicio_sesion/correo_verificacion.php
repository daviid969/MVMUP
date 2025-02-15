<?php
session_start();

// Conexión a la base de datos
$servername = "192.168.1.149";
$username = "mvmup_root";
$password = "mvmup@KC_IP_DE";
$dbname = "mvmup";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "SELECT id FROM usuarios WHERE token_verificacion = ? AND cuenta_verificada = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Verificar la cuenta y eliminar el token
        $update_sql = "UPDATE usuarios SET cuenta_verificada = 1, token_verificacion = NULL WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $user_id);

        if ($update_stmt->execute()) {
            echo "Cuenta verificada correctamente. <a href='login.html'>Inicia sesión</a>.";
        } else {
            echo "Error al verificar la cuenta.";
        }

        $update_stmt->close();
    } else {
        echo "Token inválido o cuenta ya verificada.";
    }

    $stmt->close();
} else {
    echo "Token no proporcionado.";
}

$conn->close();
?>
