<?php
session_start();

// Incluir PHPMailer manualmente
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        // Configurar PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurar el servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'tucorreo@gmail.com'; // Tu correo de Gmail
            $mail->Password = 'tucontraseña'; // Tu contraseña de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar encriptación TLS
            $mail->Port = 587; // Puerto SMTP de Gmail

            // Configurar el remitente y el destinatario
            $mail->setFrom('no-reply@tudominio.com', 'MVMUP');
            $mail->addAddress($email, $nombre);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Verifica tu cuenta en MVMUP';
            $mail->Body = "Hola $nombre,<br><br>
                           Por favor, verifica tu cuenta haciendo clic en el siguiente enlace:<br>
                           <a href='http://192.168.1.149/correo_verificacion.php?token=$token_verificacion'>
                           Verificar cuenta</a><br><br>
                           Gracias por registrarte en MVMUP.";

            // Enviar el correo
            $mail->send();
            echo "Registro exitoso. Por favor, revisa tu correo ($email) para verificar tu cuenta.";
        } catch (Exception $e) {
            echo "Error al enviar el correo de verificación: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>