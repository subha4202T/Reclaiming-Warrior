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
  <meta charset="UTF-8">
  <title>Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon">

  <!-- Google Identity Services -->
  <script src="https://accounts.google.com/gsi/client" async defer></script>

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
      padding: 80px;
      width: 100%;
      max-width: 400px;
      backdrop-filter: blur(20px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      text-align: center;
      color: white;
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
    }
    input::placeholder { color: #eee; }
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
    }
    button:hover { background-color: #e65c00; }
    .divider {
      margin: 20px 0;
      text-align: center;
      color: #eee;
    }
    #g_id_signin {
      display: flex;
      justify-content: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
<div class="form-container">
  <h2>🚀 Create Your Account</h2>
  
  <?php if (!empty($message)) echo $message; ?>

  <form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register Now</button>
  </form>

  <div class="divider"></div>
  <div id="g_id_signin"></div>
</div>

<script>
  window.onload = function () {
    google.accounts.id.initialize({
      client_id: "444881544975-fcelmef9narr0k87k470dh3c037k7hsa.apps.googleusercontent.com", // Replace this with your actual Google client ID
      callback: handleCredentialResponse
    });

    google.accounts.id.renderButton(
      document.getElementById("g_id_signin"),
      {
        theme: "outline",     
        size: "large",        
        shape: "pill",        
        width: "100%"         
      }
    );
  };

  function handleCredentialResponse(response) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'google_signin_handler.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
      if (xhr.status === 200) {
        alert("✅ Login successful. Redirecting to Course...");
        window.location.href = "http://localhost/Final_Reclaiming_Warrior_Complete/course.html";
      } else {
        alert("❌ Google Sign-In Failed: " + xhr.responseText);
      }
    };
    xhr.send("idtoken=" + response.credential);
  }
</script>
</body>
</html>
