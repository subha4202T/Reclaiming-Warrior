<?php
session_start();
include('../db/db_config.php');

if (!isset($_POST['idtoken'])) {
    http_response_code(400);
    echo "Missing ID token";
    exit;
}

require_once 'vendor/autoload.php';

$client = new Google_Client(['client_id' => '444881544975-fcelmef9narr0k87k470dh3c037k7hsa.apps.googleusercontent.com']);

$payload = $client->verifyIdToken($_POST['idtoken']);

if ($payload) {
    $google_id = $payload['sub'];         // ✅ Google unique user ID
    $email = $payload['email'];
    $name = $payload['name'];

    // Check if user already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        // ✅ Insert user with Google ID
        $otp = rand(100000, 999999);
        $stmt_insert = $conn->prepare("INSERT INTO users (username, email, google_id, password, otp) VALUES (?, ?, ?, '', ?)");
        $stmt_insert->bind_param("sssi", $name, $email, $google_id, $otp);
        $stmt_insert->execute();
        $stmt_insert->close();
    } else {
        // ✅ Optional: Update google_id if missing (existing user)
        $stmt_update = $conn->prepare("UPDATE users SET google_id = ? WHERE email = ? AND (google_id IS NULL OR google_id = '')");
        $stmt_update->bind_param("ss", $google_id, $email);
        $stmt_update->execute();
        $stmt_update->close();
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
