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
    $username = $_POST['new-username'];
    $nombre = $_POST['name'];
    $apellidos = $_POST['surname'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Generar un token único
    $token_verificacion = bin2hex(random_bytes(32)); // Token de 64 caracteres

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO usuarios (username, nombre, apellidos, email, curso, password, token_verificacion, cuenta_verificada)
            VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $username, $nombre, $apellidos, $email, $curso, $password, $token_verificacion);

    if ($stmt->execute()) {
        // Enviar correo de verificación usando Postfix
        $asunto = "Verifica tu cuenta en MVMUP";
        $mensaje = "Hola $nombre,\n\n";
        $mensaje .= "Por favor, verifica tu cuenta haciendo clic en el siguiente enlace:\n";
        $mensaje .= "http://192.168.1.149/correo_verificacion.php?token=$token_verificacion\n\n";
        $mensaje .= "Gracias por registrarte en MVMUP.";

        $headers = "From: no-reply@tudominio.com\r\n";
        $headers .= "Reply-To: no-reply@tudominio.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($email, $asunto, $mensaje, $headers)) {
            echo "Registro exitoso. Por favor, revisa tu correo ($email) para verificar tu cuenta.";
        } else {
            echo "Error al enviar el correo de verificación.";
        }
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>