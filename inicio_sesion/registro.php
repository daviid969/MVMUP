<?php
// Parámetros de conexión a la base de datos
$servername = "192.168.1.149"; // Cambia a tu servidor si es necesario
$username = "mvmup_user";        // Cambia a tu usuario de la base de datos
$password = "mvmup@KC_IP_DE";            // Cambia a tu contraseña de la base de datos
$dbname = "mvmup";      // Cambia al nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se han recibido los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $new_username = mysqli_real_escape_string($conn, $_POST['new-username']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $curso = mysqli_real_escape_string($conn, $_POST['curso']);
    
    // Insertar datos en la base de datos
    $sql = "INSERT INTO usuarios (username, name, surname, email, curso)
            VALUES ('$new_username', '$name', '$surname', '$email', '$curso')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>