<?php
include('../db/db_config.php'); 
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $email = $_POST['email'];
    $otp = rand(100000, 999999); 

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, otp) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $password, $email, $otp);

    if ($stmt->execute()) {
        $_SESSION['otp_message'] = "🎉 Registered successfully! Your OTP is: <strong>$otp</strong>";
        header("Location: login.php");
        exit;
    } else {
        $message = "<div class='alert error'>❌ Error: " . $conn->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon">
  <meta charset="UTF-8">
  <title>Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #8E2DE2, #4A00E0);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 40px 30px;
      width: 100%;
      max-width: 400px;
      backdrop-filter: blur(20px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      text-align: center;
      color: white;
      position: relative;
    }

    .form-container::before {
      content: '';
      position: absolute;
      top: -10%;
      right: -10%;
      width: 100px;
      height: 100px;
      background: radial-gradient(circle, #ffffff33 10%, transparent 70%);
      filter: blur(20px);
      z-index: 0;
    }

    h2 {
      margin-bottom: 25px;
      font-size: 26px;
      font-weight: 600;
      text-shadow: 1px 1px 2px #000;
    }

    input {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.2);
      color: white;
      font-size: 16px;
      backdrop-filter: blur(5px);
      transition: all 0.3s ease-in-out;
    }

    input::placeholder {
      color: #eee;
    }

    input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.3);
      box-shadow: 0 0 0 2px #ffffff88;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #ff6a00;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      margin-top: 10px;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #e65c00;
    }

    .alert {
      margin-top: 15px;
      padding: 10px 15px;
      border-radius: 8px;
      font-size: 15px;
      animation: fadeIn 0.5s ease-in-out;
    }

    .alert.success {
      background-color: rgba(76, 175, 80, 0.8);
      color: #fff;
    }

    .alert.error {
      background-color: rgba(244, 67, 54, 0.8);
      color: #fff;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }

    @media screen and (max-width: 500px) {
      .form-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>🚀 Create Your Account</h2>
  
  <?php
    if (!empty($message)) {
        echo $message;
    }
  ?>

  <form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register Now</button>
  </form>
</div>

</body>
</html>
