<?php
session_start();
// Configurar la conexión a la base de datos
$servername = "192.168.1.149";
$username = "mvmup_root";  // Cambiar si usas otro usuario
$password = "mvmup@KC_IP_DE";      // Cambiar si tienes contraseña en tu base de datos
$dbname = "mvmup";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    // Consultar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username']; // Almacenar el nombre de usuario en la sesión
            header('Location: /pagina_principal/pagina_principal.html'); // Redirigir a la página principal
            exit(); // Asegúrate de salir después de redirigir
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    
    $conn->close();
}
?>