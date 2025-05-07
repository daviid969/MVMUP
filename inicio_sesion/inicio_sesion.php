<?php
session_start();

require_once "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, directory, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['directory'] = $row['directory'];
            $directory = $row['directory'];
            $id = $row['id'];

            $user_folder = "/mvmup_stor/$id";

            if ($directory == 1) {
                header('Location: /index.html');
            } else {
                // Crear carpeta del usuario si no existe
                if (!file_exists($user_folder)) {
                    if (mkdir($user_folder, 0777, true)) {
                        $update_sql = "UPDATE usuarios SET directory = 1 WHERE id = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->bind_param('i', $id);
                        $update_stmt->execute();
                        $update_stmt->close();
                    } else {
                        echo "Error al crear la carpeta del usuario.";
                        exit;
                    }
                }
                header('Location: /index.html');
            }
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    $stmt->close();
}
$conn->close();
?>
