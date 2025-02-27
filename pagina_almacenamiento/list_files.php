<?php
$sql="select * from usuarios where id ='".$_GET["id"]."' ";
$usuario = $_GET["id"];
$nombre_carpeta = "/mvmup_stor/".$usuario."";


$files = array_diff(scandir($nombre_carpeta), array('.', '..'));
echo json_encode(array_values($files));
?>
