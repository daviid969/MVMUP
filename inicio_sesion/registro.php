<?php
session_start();


require_once "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $username = $_POST['new-username'];
   $nombre = $_POST['name'];
   $apellidos = $_POST['surname'];
   $email = $_POST['email'];
   $curso = $_POST['curso'];
   $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

   // Insertar usuario en la base de datos
   $sql = "INSERT INTO usuarios (username, nombre, apellidos, email, curso, password)
           VALUES ('$username', '$nombre', '$apellidos', '$email', '$curso', '$password' )";
   $stmt = $conn->prepare($sql);
   if ($stmt === false) {
       echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]);
       exit;
   }

   if ($stmt->execute()) {
       echo json_encode(["success" => true, "message" => "Usuario registrado correctamente."]);
       mkdir("/mvmup_stor/$email", 0777); 
       header('Location: ./index.html');
   } else {
       echo json_encode(["success" => false, "message" => "Error al registrar el usuario: " . $stmt->error]);
   }


   $stmt->close();
   $conn->close();
   
}

?>


