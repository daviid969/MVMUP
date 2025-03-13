<?php
require_once "../conexion.php";
require_once "../check_session.php";
$sql = "SELECT email password FROM usuarios WHERE id = ?";

$directory = "/mvmup_stor/$sesion_email";
$files = array_diff(scandir($directory), array('.', '..'));
echo json_encode(array_values($files));
?>
