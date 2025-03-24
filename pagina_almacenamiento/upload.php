<?php
session_start();

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $target_dir = "/mvmup_stor/$email/"; 
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Archivo existente
    if (file_exists($target_file)) {
        echo "El archivo ya existe";
        $uploadOk = 0;
    }
    
    // Tamaño archivo
    if ($_FILES["fileToUpload"]["size"] > 50 * 1024 * 1024) {
        echo "Tu archivo supera el limite de 50MB.";
        $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
        echo "Tu archivo no fue subido.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]). " ha sido subido";
        } else {
            echo "Hubo un error al subir tu archivo";
        }
    }
}
?>
