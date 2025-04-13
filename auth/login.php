<?php
session_start();
include('../db/db_config.php');

$loginError = "";

// Login validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $entered_otp = $_POST['otp'];
    $password = $_POST['password'];

    // Prepare the query to fetch user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($user = $result->fetch_assoc()) {
        // Debugging: Print the stored password and OTP values
        echo "Stored Password: " . htmlspecialchars($user['password']) . "<br>";
        echo "Entered OTP: " . htmlspecialchars($entered_otp) . "<br>";
        echo "Stored OTP: " . htmlspecialchars($user['otp']) . "<br>";
        
        // Validate the password and OTP
        if (password_verify($password, $user['password']) && $entered_otp == $user['otp']) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $loginError = "Invalid credentials or OTP.";
        }
    } else {
        $loginError = "User not found.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon">
    <title>Login</title>
</head>
<body style="margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(120deg, #654ea3, #eaafc8); height: 100vh; display: flex; justify-content: center; align-items: center;">

    <div style="background-color: rgba(255,255,255,0.15); padding: 40px 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); backdrop-filter: blur(10px); width: 100%; max-width: 400px; text-align: center; color: white;">
        <h2 style="margin-bottom: 25px;">🔐 User Login</h2>

        <!-- OTP success message after registration -->
        <?php if (isset($_SESSION['otp_message'])) : ?>
            <div class="alert" style="background-color: rgba(76, 175, 80, 0.85); padding: 10px 15px; margin-bottom: 15px; border-radius: 10px;">
                <?php echo $_SESSION['otp_message']; ?>
            </div>
            <script>
                setTimeout(function () {
                    document.querySelector('.alert').style.display = 'none';
                }, 10000);
            </script>
            <?php unset($_SESSION['otp_message']); ?>
        <?php endif; ?>

        <!-- Login Error Message -->
        <?php if (!empty($loginError)) : ?>
            <div style="background-color: rgba(255, 0, 0, 0.25); padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 0.95rem;">
                <?php echo htmlspecialchars($loginError); ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="post">
            <input name="username" placeholder="Enter Username" required 
                   style="width: 100%; padding: 12px; margin-bottom: 15px; border: none; border-radius: 8px; font-size: 1rem; background-color: rgba(255,255,255,0.2); color: white;"><br>

            <input name="password" type="password" placeholder="Enter Password" required 
                   style="width: 100%; padding: 12px; margin-bottom: 15px; border: none; border-radius: 8px; font-size: 1rem; background-color: rgba(255,255,255,0.2); color: white;"><br>

            <input name="otp" placeholder="Enter OTP" required 
                   style="width: 100%; padding: 12px; margin-bottom: 20px; border: none; border-radius: 8px; font-size: 1rem; background-color: rgba(255,255,255,0.2); color: white;"><br>

            <button type="submit" 
                    style="padding: 12px 25px; font-size: 1rem; border: none; border-radius: 8px; background-color: #ff6f61; color: white; cursor: pointer; transition: background 0.3s;">
                Login
            </button>
        </form>
    </div>

</body>
</html>
