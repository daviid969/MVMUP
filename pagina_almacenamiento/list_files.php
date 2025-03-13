<?php
$_SESION['email'];
$email= $_SESION['email'];
$directory = "/mvmup_stor/$email";
$files = array_diff(scandir($directory), array('.', '..'));
echo json_encode(array_values($files));
?>
