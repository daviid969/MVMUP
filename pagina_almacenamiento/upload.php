<?php
require_once "../inicio_sesion/inicio_sesion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $target_dir = "/mvmup_stor/$sesion_email"; 
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
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