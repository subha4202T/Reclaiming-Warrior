<?php
session_start();
include('../db/db_config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $entered_otp = $_POST['otp'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        if (password_verify($_POST['password'], $user['password']) && $entered_otp == $user['otp']) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
        } else {
            echo "Login failed. Invalid credentials or OTP.";
        }
    }
}
?>
<form method="post">
  Username: <input name="username"><br>
  Password: <input name="password" type="password"><br>
  OTP: <input name="otp"><br>
  <button type="submit">Login</button>
</form>