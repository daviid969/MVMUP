<?php
session_start();
require 'vendor/autoload.php'; // Cargar PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conexión a la base de datos
$servername = "192.168.1.149";
$username = "mvmup_root";
$password = "mvmup@KC_IP_DE";
$dbname = "mvmup";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['new-username'];
    $nombre = $_POST['name'];
    $apellidos = $_POST['surname'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token_verificacion = bin2hex(random_bytes(32));

    $sql = "INSERT INTO usuarios (username, nombre, apellidos, email, curso, password, token_verificacion, cuenta_verificada)
            VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $username, $nombre, $apellidos, $email, $curso, $password, $token_verificacion);

    if ($stmt->execute()) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'tuemail@gmail.com'; // Tu correo
            $mail->Password = 'tu_contraseña_de_aplicación'; // Contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('no-reply@tudominio.com', 'MVMUP');
            $mail->addAddress($email);
            $mail->Subject = 'Verifica tu cuenta en MVMUP';
            $mail->Body = "Hola $nombre,\n\nPor favor verifica tu cuenta en el siguiente enlace:\nhttp://192.168.1.149/verificar.php?token=$token_verificacion\n\nGracias.";

            $mail->send();
            echo "Registro exitoso. Revisa tu correo para verificar tu cuenta.";
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
