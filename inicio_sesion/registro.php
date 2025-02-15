<?php
// Configurar la conexión a la base de datos
$servername = "192.168.1.149";
$username = "mvmup_root";  // Cambiar si usas otro usuario
$password = "mvmup@KC_IP_DE";      // Cambiar si tienes contraseña en tu base de datos
$dbname = "mvmup";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recoger los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['new-username'];
    $nombre = $_POST['name'];
    $apellidos = $_POST['surname'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $password = $_POST['password'];

    // Preparar la consulta SQL para insertar los datos
    $stmt = $conn->prepare("INSERT INTO usuarios (username, nombre, apellidos, email, curso, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $nombre, $apellidos, $email, $curso, $password);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Registro exitoso!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>