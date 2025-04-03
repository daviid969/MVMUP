<?php
session_start();

$id = $_SESSION['id'];

$directory = "/mvmup_stor/$id";
$files = array_diff(scandir($directory), array('.', '..'));

// Incluir archivos compartidos
$shared_directory = "/mvmup_stor/shared";
$shared_files = glob("$shared_directory/{$id}_*");
$shared_files = array_map(function($file) {
    return "shared/" . basename($file);
}, $shared_files);

$all_files = array_merge(array_values($files), $shared_files);

echo json_encode($all_files);
?>
