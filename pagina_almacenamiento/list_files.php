<?php
$sql="select * from usuarios where id ='".$_GET["id"]."' ";
$usuario = $_GET["id"];
$nombre_carpeta = "/mvmup_stor/".$usuario."";

if(!is_dir($nombre_carpeta)){
@mkdir($nombre_carpeta, 0700);
}

$files = array_diff(scandir($nombre_carpeta), array('.', '..'));
echo json_encode(array_values($files));
?>
