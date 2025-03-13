<?php

$directory = "/mvmup_stor/$_SESSION[email]";
$files = array_diff(scandir($directory), array('.', '..'));
echo json_encode(array_values($files));
?>
