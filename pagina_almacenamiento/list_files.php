<?php
session_start();
$email = $_SESSION['email'];

$directory = "/mvmup_stor/$email";
$files = array_diff(scandir($directory), array('.', '..'));
echo json_encode(array_values($files));
?>
