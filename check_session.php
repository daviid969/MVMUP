<?php
session_start();

$response = [
    'loggedIn' => false,
    'username' => '',
    'redirect' => false // Nuevo campo para indicar si se debe redirigir
];

if (isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
    $response['username'] = $_SESSION['username'];
} else {
    $response['redirect'] = true; // Indicar que se debe redirigir
}

header('Content-Type: application/json'); // Especificar que la respuesta es JSON
echo json_encode($response);
?>