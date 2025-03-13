<?php
$email= "kcuadrado@institutmvm.cat";
$directory = "/mvmup_stor/$email";
$files = array_diff(scandir($directory), array('.', '..'));
echo json_encode(array_values($files));
?>
