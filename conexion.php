<?php
require_once('config.php');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
   die("Conexión fallida: " . $conn->connect_error);
}

?>

