<?php
$admin_username = $_POST['admin_username'];
$admin_password = $_POST['admin_password'];

// Replace with your actual admin credentials
$valid_username = 'admin';
$valid_password = 'admin123'; // You should hash this in production

if ($admin_username === $valid_username && $admin_password === $valid_password) {
    header("Location: admin_dashboard.php"); // Redirect to admin area
    exit();
} else {
    echo "<script>alert('❌ Invalid admin credentials');window.location.href='admin_login.php';</script>";
}
?>
