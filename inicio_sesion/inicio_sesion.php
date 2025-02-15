<?php
// Configurar la conexión a la base de datos
$servername = "192.168.1.149";
$username = "mvmup_root";  // Cambiar si usas otro usuario
$password = "mvmup@KC_IP_DE"; // Cambiar si tienes contraseña en tu base de datos
$dbname = "mvmup";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recoger los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar la consulta SQL para buscar el correo electrónico en la base de datos
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encuentra el usuario
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Inicio de sesión exitoso, redirigir a la página principal
            session_start();
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nombre'] = $user['nombre'];  // Guarda también el nombre
            $_SESSION['apellidos'] = $user['apellidos'];  // Guarda también los apellidos
            header("Location: /pagina_principal/pagina_principal.html");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró un usuario con ese correo electrónico.";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
