<?php
// Parámetros de conexión a la base de datos
$servername = "192.168.1.149"; // Cambia a tu servidor si es necesario
$username = "mvmup_user";        // Cambia a tu usuario de la base de datos
$password = "mvmup@KC_IP_DE";            // Cambia a tu contraseña de la base de datos
$dbname = "mvmup";      // Cambia al nombre de tu base de datos

try {
    // Crear conexión PDO para MariaDB
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configurar el modo de error de PDO para excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si se han recibido los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_username = $_POST['new-username'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $curso = $_POST['curso'];

        // Preparar la consulta SQL para insertar los datos en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (username, name, surname, email, curso)
                                VALUES (:username, :name, :surname, :email, :curso)");

        // Vincular los parámetros con los valores del formulario
        $stmt->bindParam(':username', $new_username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':curso', $curso);

        // Ejecutar la consulta
        $stmt->execute();

        echo "Registro exitoso.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>