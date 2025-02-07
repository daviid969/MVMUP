<?php
if(isset($_POST["submit"])) {
  $target_dir = "home/hosting2/Descargas/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]). " ha sido subido.";
  } else {
    echo "Lo siento, hubo un error al subir tu archivo.";
  }
}
?>
