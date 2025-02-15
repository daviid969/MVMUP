<?php
session_start();

$response = [
    'loggedIn' => false,
    'username' => ''
];

if (isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
    $response['username'] = $_SESSION['username'];
}

echo json_encode($response);
?>