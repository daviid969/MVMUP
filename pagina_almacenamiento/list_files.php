<?php

$sesion_email=$_SESSION[email];

$directory = "/mvmup_stor/$sesion_email";
$files = array_diff(scandir($directory), array('.', '..'));
echo json_encode(array_values($files));
?>
