<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar con la base de datos
    $conn = new mysqli('localhost', 'usuario', 'contraseña', 'base_de_datos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

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
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    
    $conn->close();
}
?>