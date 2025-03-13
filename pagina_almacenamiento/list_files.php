<?php
require_once "../inicio_sesion/inicio_sesion.php";

$directory = "/mvmup_stor/$sesion_email";
$files = array_diff(scandir($directory), array('.', '..'));
echo json_encode(array_values($files));
?>
