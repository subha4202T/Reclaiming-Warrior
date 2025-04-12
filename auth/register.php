<?php
include('../db/db_config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $otp = rand(100000, 999999);

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, otp) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $password, $email, $otp);
    if ($stmt->execute()) {
        echo "Registered successfully. Your OTP is: $otp";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}
?>
<form method="post">
  Username: <input name="username"><br>
  Email: <input name="email"><br>
  Password: <input name="password" type="password"><br>
  <button type="submit">Register</button>
</form>