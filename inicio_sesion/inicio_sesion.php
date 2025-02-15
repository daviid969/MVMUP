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
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Depuración: Verificar datos del formulario
    error_log("Datos del formulario - Email: $email, Contraseña: $password");

    // Consultar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Depuración: Verificar datos del usuario
        error_log("Usuario encontrado: " . print_r($row, true));

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            error_log("Contraseña correcta. Redirigiendo...");
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header('Location: /pagina_principal/pagina_principal.html');
            exit();
        } else {
            error_log("Contraseña incorrecta.");
            echo "Contraseña incorrecta.";
        }
    } else {
        error_log("Usuario no encontrado.");
        echo "Usuario no encontrado.";
    }
    
    $conn->close();
}
?>