<?php
session_start();

require_once "../conexion.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $email = $_POST['email'];
   $password = $_POST['password'];


   // Buscar usuario en la base de datos
   $sql = "SELECT id, username, password FROM usuarios WHERE email = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param('s',$email);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();


       // Verificar contraseña
       if (password_verify($password, $row['password'])) {
           // Iniciar sesion
       $_SESSION['user_id'] = $row['id'];
       $_SESSION['username'] = $row['username'];
       $_SESSION['email'] = $email;
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
