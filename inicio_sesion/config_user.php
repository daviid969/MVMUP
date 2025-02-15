<?php
session_start();

// Verificar si el usuario está logueado, si no, redirigir a la página de inicio de sesión
if (!isset($_SESSION['username'])) {
    header("Location: /inicio_sesion/inicio_sesion.php");
    exit();
}

// Conectar a la base de datos
$servername = "192.168.1.149";
$username = "mvmup_root";
$password = "mvmup@KC_IP_DE";
$dbname = "mvmup";
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del usuario
$userEmail = $_SESSION['email'];
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nombre = $user['nombre'];
    $apellidos = $user['apellidos'];
    $email = $user['email'];
} else {
    echo "Error: Usuario no encontrado.";
    exit();
}

// Actualizar los datos si el formulario es enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_nombre = $_POST['nombre'];
    $new_apellidos = $_POST['apellidos'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    // Actualizar los datos en la base de datos
    $updateSql = "UPDATE usuarios SET nombre = ?, apellidos = ?, email = ?, password = ? WHERE email = ?";
    $stmt = $conn->prepare($updateSql);
    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt->bind_param("sssss", $new_nombre, $new_apellidos, $new_email, $new_password_hashed, $userEmail);

    if ($stmt->execute()) {
        // Actualización exitosa
        $_SESSION['email'] = $new_email;  // Actualizar sesión con el nuevo correo
        echo "Datos actualizados con éxito!";
    } else {
        echo "Error al actualizar los datos.";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Usuario - MVMUP</title>
    <link rel="icon" href="/img/favicon-logo.ico">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS personalizados -->
    <link rel="stylesheet" href="/pagina_principal/pagina_principal.css">
    <link rel="stylesheet" href="/inicio_sesion/inicio_sesion.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/pagina_principal/pagina_principal.html">
                <img src="/img/logo.png" alt="Logo MVMUP" class="rounded-circle" width="50" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/pagina_principal/pagina_principal.html">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="/quienes_somos/quines-somos.html">Sobre Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pagina_almacenamiento/almacenamiento.html">Almacenamiento</a></li>
                    <li class="nav-item"><a class="nav-link" href="/forum/forum_principal.html">Forum</a></li>
                    <li class="nav-item"><a class="nav-link" href="/inicio_sesion/inicio_sesion.php">Iniciar sesión/Registrarse</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <main class="flex-grow-1">
        <div class="container my-5 pt-5">
            <div class="container my-5 pt-5">
                <div class="login-register-container bg-white rounded shadow p-4 mx-auto" style="max-width: 800px;">
                    <h2 class="text-center text-primary mb-4">Configuración de Usuario</h2>

                    <!-- Formulario de configuración -->
                    <form method="POST" action="configuracion.php">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?= htmlspecialchars($apellidos) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Actualizar Información</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3 mt-auto">
        <div class="container d-flex flex-wrap justify-content-between">
            <div class="footer-left">
                <p>Has iniciado sesión como: <?= htmlspecialchars($nombre) . ' ' . htmlspecialchars($apellidos) ?></p>
            </div>
            <div class="footer-center text-center flex-grow-1">
                <p>&copy; IES Manuel Vazquez Montalban. Todos los derechos reservados.</p>
            </div>
            <div class="footer-right text-end">
                <p><a href="https://agora.xtec.cat/iesmvm" class="text-white text-decoration-none">Modle MVM: https://agora.xtec.cat/iesmvm/</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
