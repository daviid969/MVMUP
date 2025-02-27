<?php
session_start();


// Configuración de la base de datos
$servername = "192.168.1.210";
$username = "mvmup_root";
$password = "mvmup@KC_IP_DE";
$dbname = "mvmup";


// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
   die("Conexión fallida: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $email = $_POST['email'];
   $password = $_POST['password'];


   // Buscar usuario en la base de datos
   $sql = "SELECT id, username, password FROM usuarios WHERE email = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $result = $stmt->get_result();


   if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();


       // Verificar la contraseña
       if (password_verify($password, $row['password'])) {
           // Iniciar sesión
       $_SESSION['user_id'] = $row['id'];
       $_SESSION['username'] = $row['username'];
       header('Location: /index.html');
       } else {
           echo "Contraseña incorrecta.";
       }
   } else {
       echo "Usuario no encontrado.";
   }


   $stmt->close();
}


$conn->close();
?>
