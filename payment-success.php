<?php
session_start();

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'cyber_project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect Razorpay POST data
$payment_id = $_POST['payment_id'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$contact = $_POST['contact'] ?? '';
$amount = $_POST['amount'] ?? 0;

// Validate input data
if (empty($payment_id) || empty($name) || empty($email) || empty($contact) || $amount <= 0) {
    http_response_code(400);
    echo "Invalid payment data.";
    exit();
}

// Insert payment into `payments` table
$stmt = $conn->prepare("INSERT INTO payments (full_name, email, phone, amount, razorpay_payment_id) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssds", $name, $email, $contact, $amount, $payment_id);
$stmt->execute();

// Check if insertion was successful
if ($stmt->affected_rows > 0) {
    // Proceed with purchase insertion
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $course_id = 1;

        // Check if already purchased
        $check = $conn->prepare("SELECT * FROM purchases WHERE user_id = ? AND course_id = ?");
        $check->bind_param("ii", $user_id, $course_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            $insert = $conn->prepare("INSERT INTO purchases (user_id, course_id, purchase_status) VALUES (?, ?, 'completed')");
            $insert->bind_param("ii", $user_id, $course_id);
            $insert->execute();
        }

        // Redirect to course
        header("Location: main_course.php");
        exit();
    } else {
        http_response_code(401);
        echo "Session expired. Please log in again.";
    }
} else {
    http_response_code(500);
    echo "Failed to record payment.";
}

// Close database resources
$stmt->close();
$conn->close();
?>
