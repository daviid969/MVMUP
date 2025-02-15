<?php
// Obtener los datos del formulario
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si los datos están completos
if (!isset($data['username'], $data['nombre'], $data['apellidos'], $data['email'], $data['curso'], $data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos necesarios']);
    exit;
}

// Validar formato del correo electrónico
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Correo electrónico no válido']);
    exit;
}

// Configuración de la base de datos
$host = '192.168.1.149';
$dbname = 'mvmup';
$user = 'mvmup_user';
$password = 'mvmup@KC_IP_DE';

// Conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Preparar los datos
$username = $data['username'];
$nombre = $data['nombre'];
$apellidos = $data['apellidos'];
$email = $data['email'];
$curso = $data['curso'];
$password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash de la contraseña

// Insertar los datos en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (username, nombre, apellidos, email, curso, password) VALUES (:username, :nombre, :apellidos, :email, :curso, :password)");
    $stmt->execute([
        ':username' => $username,
        ':nombre' => $nombre,
        ':apellidos' => $apellidos,
        ':email' => $email,
        ':curso' => $curso,
        ':password' => $password
    ]);

    echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()]);
}
