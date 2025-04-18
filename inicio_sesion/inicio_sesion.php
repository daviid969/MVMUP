<?php
session_start();

require_once "../conexion.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];


    // Buscar usuario en la base de datos
    $sql = "SELECT id, username, directory, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $result = $stmt->get_result();
    

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar contraseña
        if (password_verify($password, $row['password'])) {
            // Iniciar sesion
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['directory'] = $row['directory'];
            $directory = $row['directory'];
            $id = $row['id'];
        
            if ($directory == 1){
                header('Location: /index.html');
            } else {
                
                mkdir("/mvmup_stor/$id", 0777);
                
                $update_sql = "UPDATE usuarios SET directory = 1 WHERE id = $id";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->execute();
                $update_stmt->close();
                
                echo json_encode(["success" => true, "message" => "Sesion iniciada correctamente"]);
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
