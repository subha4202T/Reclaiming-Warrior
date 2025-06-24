<?php
include('../db/db_config.php'); 
session_start(); // Start the session to use session variables

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $dob = trim($_POST['dob']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $otp = rand(100000, 999999); // Generate OTP
	
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, phone, dob, otp) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $username, $password, $email, $phone, $dob, $otp);
    if ($stmt->execute()) {
        // ✅ Set session variables after successful registration
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['dob'] = $dob;
        $_SESSION['phone'] = $phone;
        $_SESSION['otp_message'] = "🎉 Registered successfully! Your OTP is: <strong>$otp</strong>";
        
        // Redirect to login page
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
  <script src="https://accounts.google.com/gsi/client" async defer></script>

  <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #6a11cb, #2575fc);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .form-container {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 16px;
        padding: 60px 40px;
		padding-right: 80px;
        width: 100%;
        max-width: 420px;
        backdrop-filter: blur(15px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        color: #fff;
        text-align: center;
    }
    h2 {
        margin-bottom: 20px;
        font-size: 28px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    }
    input {
        width: 100%;
        padding: 14px 18px;
        margin: 12px 0;
        border: none;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        font-size: 16px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    input::placeholder {
        color: #dcdcdc;
    }
    input:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 0 2px #ffffff88;
    }
    button {
        width: 100%;
        padding: 14px;
        background-color: #ff7b54;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        margin-top: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #e66b48;
    }
    a {
        display: inline-block;
        margin-top: 20px;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }
    a:hover {
        color: #f4a261;
    }
    .divider {
        margin: 20px 0;
        text-align: center;
        color: #e6e6e6;
        position: relative;
    }
    .divider::before, .divider::after {
        content: "";
        position: absolute;
        top: 50%;
        width: 40%;
        height: 1px;
        background: #ccc;
    }
    .divider::before {
        left: 0;
    }
    .divider::after {
        right: 0;
    }
    #g_id_signin {
        margin-top: 10px;
        display: flex;
        justify-content: center;
    }
  </style>
</head>
<body>
<a href="admin_login.php" style="position: absolute; top: 20px; left: 20px; padding: 10px 20px; background-color: #2c3e50; color: white; text-decoration: none; border-radius: 5px;">
  👨‍💼 Admin Login
</a>

<div class="form-container">
  <h2>🚀 Create Your Account</h2>
  
  <?php if (!empty($message)) echo $message; ?>

  <form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="tel" name="phone" placeholder="Mobile Number" pattern="[0-9]{10}" title="Enter 10-digit mobile number" required>
    <input type="date" name="dob" placeholder="Date of Birth" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password" placeholder="Confirm Password" required>

    <button type="submit">Register</button>
  </form>

  <div class="divider">or</div>
  <div id="g_id_signin"></div>
</div>

<script>
  window.onload = function () {
    google.accounts.id.initialize({
      client_id: "444881544975-fcelmef9narr0k87k470dh3c037k7hsa.apps.googleusercontent.com", // Replace with your Google Client ID
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
