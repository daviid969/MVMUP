<?php
session_start();

// Configurar la conexión a la base de datos
require_once "conexion.php";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_username = $_POST['current-username'];
    $new_username = $_POST['new-username'];

    // Obtener el ID del usuario actual
    $user_id = $_SESSION['user_id'];

    // Verificar que el nombre de usuario actual sea correcto
    $sql = "SELECT username FROM usuarios WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_username = $row['username'];

        if ($current_username === $stored_username) {
            // Actualizar el nombre de usuario en la base de datos
            $update_sql = "UPDATE usuarios SET username = '$new_username' WHERE id = $user_id";
            if ($conn->query($update_sql) === TRUE) {
                echo "Nombre de usuario actualizado correctamente.";
            } else {
                echo "Error al actualizar el nombre de usuario: " . $conn->error;
            }
        } else {
            echo "Nombre de usuario actual incorrecto.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $conn->close();
}
?>