<?php
include('../db/db_config.php');
session_start();
if (!isset($_SESSION['username'])) {
    echo "Login required.";
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $course = $_POST['course'];
    $price = $_POST['price'];
    $stmt = $conn->prepare("INSERT INTO orders (username, course, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $username, $course, $price);
    $stmt->execute();
    echo "Payment successful for course: $course at ₹$price";
}
?>
<form method="post">
  Course Name: <input name="course"><br>
  Price: <input name="price"><br>
  <button type="submit">Pay Now</button>
</form>