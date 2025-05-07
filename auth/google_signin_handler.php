<?php
session_start();
include('../db/db_config.php');

if (!isset($_POST['idtoken'])) {
    http_response_code(400);
    echo "Missing ID token";
    exit;
}

require_once 'vendor/autoload.php';

$client = new Google_Client(['client_id' => 'YOUR_CLIENT_ID.apps.googleusercontent.com']);

$payload = $client->verifyIdToken($_POST['idtoken']);

if ($payload) {
    $google_id = $payload['sub'];
    $email = $payload['email'];
    $name = $payload['name'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $otp = rand(100000, 999999);
        $stmt_insert = $conn->prepare("INSERT INTO users (username, email, password, otp) VALUES (?, ?, '', ?)");
        $stmt_insert->bind_param("ssi", $name, $email, $otp);
        $stmt_insert->execute();
        $stmt_insert->close();
    }

    $stmt->close();
    $conn->close();

    $_SESSION['username'] = $name;
    $_SESSION['email'] = $email;

    http_response_code(200);
    echo "Login successful";
} else {
    http_response_code(401);
    echo "Invalid ID token";
}
?>
