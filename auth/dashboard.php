<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Body Styling */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1abc9c, #3498db);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        /* Card Container */
        .welcome-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 80%;
        }

        /* Heading */
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        /* Paragraph Text */
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        /* Logout Button */
        a {
            padding: 12px 25px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 8px;
            transition: background 0.3s ease;
            margin-right: 15px;
        }

        a:hover {
            background-color: #c0392b;
        }

        /* Go to Course Button */
        .course-btn {
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .course-btn:hover {
            background-color: #2980b9;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .welcome-container {
                width: 90%;
                padding: 25px;
            }

            .course-btn, a {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>

    <div class="welcome-container">
        <h1>🎉 Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>You have successfully logged in to your account.</p>

        <!-- Go to Course Button -->
        <a href="#" class="course-btn" id="course-btn">Go to Course</a>

        <!-- Logout Button -->
        <a href="logout.php">Logout</a>
    </div>

    <script>
        // JavaScript: Check if the user is logged in
        document.getElementById('course-btn').addEventListener('click', function(event) {
            // Check if the session variable 'username' exists
            <?php if (isset($_SESSION['username'])): ?>
                // If the user is logged in, redirect to course.html
                window.location.href = 'https://localhost/Final_Reclaiming_Warrior_Complete/course.html';
            <?php else: ?>
                // If not logged in, alert the user and redirect to login page
                alert("You are not logged in!");
                window.location.href = 'login.php';
            <?php endif; ?>
        });
    </script>

</body>
</html>
