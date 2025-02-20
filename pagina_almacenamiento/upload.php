<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $target_dir = "/home/mvmup/";  // Asegúrate de que este directorio existe y tiene permisos de escritura
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica si el archivo ya existe
    if (file_exists($target_file)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Verifica el tamaño del archivo (opcional)
    if ($_FILES["fileToUpload"]["size"] > 5000000) { // 5MB
        echo "Lo siento, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permite ciertos formatos de archivo (opcional)
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "pdf" ) {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG, GIF y PDF.";
        $uploadOk = 0;
    }

    // Verifica si $uploadOk es 0 por un error
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