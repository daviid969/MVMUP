<?php

require_once('config.php');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
echo "socoorro"; die;
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
