<?php
session_start();

// Conectar a la base de datos
$servername = "192.168.1.149"; // o la IP de tu servidor de base de datos
$username = "mvmup_root";        // o tu nombre de usuario de la base de datos
$password = "mvmup@KC_IP_DE";            // o tu contraseña de la base de datos
$dbname = "mvmup";         // nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar si hay error en la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comprobar si los datos del formulario fueron enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han recibido los datos del formulario
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        echo "Correo electrónico recibido: $email<br>";
        echo "Contraseña recibida: $password<br>";

        // Consultar si el correo electrónico existe en la base de datos
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si existe el usuario
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verificar si la contraseña es correcta
            if (password_verify($password, $user['password'])) {
                // Iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirigir al usuario a la página principal o dashboard
                header("Location: /pagina_principal/pagina_principal.html");
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "El correo electrónico no está registrado.";
        }
    } else {
        echo "No se enviaron los datos del formulario.";
    }
}

// Cerrar la conexión
$conn->close();
?>
