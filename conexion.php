<?php
phpinfo();
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

$servername = "localhost";
$username = "mvmup_root";
$password = "mvmup@KCIPDE";
$dbname = "mvmup";
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
var_dump($conn); die;

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
