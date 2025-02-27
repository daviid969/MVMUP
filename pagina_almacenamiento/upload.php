<?php
$sql="select * from usuarios where id ='".$_GET["id"]."' ";
$usuario = $_GET["id"];
$nombre_carpeta = "/mvmup_stor/".$usuario."";

if(!is_dir($nombre_carpeta)){
@mkdir($nombre_carpeta, 0700);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
     
    $target_file = $nombre_carpeta . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica si el archivo ya existe
    if (file_exists($target_file)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no fue subido.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]). " ha sido subido.";
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}
?>