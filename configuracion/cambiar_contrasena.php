<?php
session_start();

// Configurar la conexión a la base de datos
$servername = "192.168.1.149";
$username = "mvmup_root";
$password = "mvmup@KC_IP_DE";
$dbname = "mvmup";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_new_password = $_POST['confirm-new-password'];

    // Verificar que las nuevas contraseñas coincidan
    if ($new_password !== $confirm_new_password) {
        echo "Las nuevas contraseñas no coinciden.";
        exit();
    }

    // Obtener el ID del usuario actual
    $user_id = $_SESSION['user_id'];

    // Obtener la contraseña actual del usuario
    $sql = "SELECT password FROM usuarios WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        // Verificar la contraseña actual
        if (password_verify($current_password, $stored_password)) {
            // Encriptar la nueva contraseña
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $update_sql = "UPDATE usuarios SET password = '$hashed_new_password' WHERE id = $user_id";
            if ($conn->query($update_sql) === TRUE) {
                echo "Contraseña actualizada correctamente.";
            } else {
                echo "Error al actualizar la contraseña: " . $conn->error;
            }
        } else {
            echo "Contraseña actual incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $conn->close();
}
?>