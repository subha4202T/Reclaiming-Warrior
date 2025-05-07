<?php
session_start();
include('../db/db_config.php');

$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $entered_otp = trim($_POST['otp']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($entered_otp) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            $stored_password = $user['password'];
            $stored_otp = (string) trim($user['otp']);

            if (password_verify($password, $stored_password)) {
                if ($entered_otp === $stored_otp && $stored_otp !== "") {
                    $_SESSION['username'] = $username;

                    $stmt = $conn->prepare("UPDATE users SET otp = NULL WHERE id = ?");
                    $stmt->bind_param("i", $user['id']);
                    $stmt->execute();

                    header("Location: dashboard.php");
                    exit;
                } else {
                    $loginError = "Invalid OTP.";
                }
            } else {
                $loginError = "Incorrect password.";
            }
        } else {
            $loginError = "User not found.";
        }
    } else {
        $loginError = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #654ea3, #eaafc8);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background-color: rgba(255,255,255,0.15);
            padding: 32px 82px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 400px;
            text-align: center;
            color: white;
        }
        .login-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        .login-box button {
            padding: 12px 25px;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            background-color: #ff6f61;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        .alert {
            background-color: rgba(76, 175, 80, 0.85);
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 10px;
        }
        .error {
            background-color: rgba(255, 0, 0, 0.25);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 0.95rem;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2 style="margin-bottom: 25px;">🔐 User Login</h2>

    <?php if (isset($_SESSION['otp_message'])) : ?>
        <div class="alert"><?php echo $_SESSION['otp_message']; ?></div>
        <script>
            setTimeout(function () {
                let alert = document.querySelector('.alert');
                if (alert) alert.style.display = 'none';
            }, 10000);
        </script>
        <?php unset($_SESSION['otp_message']); ?>
    <?php endif; ?>

    <?php if (!empty($loginError)) : ?>
        <div class="error"><?php echo htmlspecialchars($loginError); ?></div>
    <?php endif; ?>

    <form method="post">
        <input name="username" placeholder="Enter Username" required>
        <input name="password" type="password" placeholder="Enter Password" required>
        <input name="otp" placeholder="Enter OTP" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
