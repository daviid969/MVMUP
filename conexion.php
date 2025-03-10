<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
require_once('/config.php');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
die;
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
