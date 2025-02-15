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
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar el usuario en la base de datos
    $sql = "SELECT id, username, password, cuenta_verificada FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Verificar si la cuenta está activada
            if ($row['cuenta_verificada'] == 1) {
                // Iniciar sesión
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header('Location: /pagina_principal/pagina_principal.html');
                exit();
            } else {
                echo "Por favor, verifica tu cuenta antes de iniciar sesión.";
            }
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