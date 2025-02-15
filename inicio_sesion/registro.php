
<?php
// Configuración de la conexión a la base de datos
$host = '192.168.1.149'; // Cambia esto según la configuración de tu servidor
$dbname = 'mvmup_db';
$username = 'mvmup_root'; // Usuario de la base de datos
$password = 'mvmup@KC_IP_DE'; // Contraseña del usuario

try {
    // Crear conexión con la base de datos utilizando PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Establecer el modo de error de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del formulario
    $new_username = $_POST['new-username'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $password_raw = ['password'];

    // Cifrar la contraseña utilizando password_hash
    $hashed_password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO mvmup_users (username, password, name, surname, email, course) 
            VALUES (:username, :password, :name, :surname, :email, :course)";

    // Preparar la sentencia SQL
    $stmt = $conn->prepare($sql);

    // Asignar los valores a los parámetros de la consulta
    $stmt->bindParam(':username', $new_username);
    $stmt->bindParam(':password', $hashed_password); // Usar la contraseña cifrada
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':course', $curso);

    // Ejecutar la consulta
    $stmt->execute();

    // Mensaje de éxito
    echo "Usuario registrado correctamente.";
} catch(PDOException $e) {
    // Si ocurre un error en la conexión o la consulta
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>