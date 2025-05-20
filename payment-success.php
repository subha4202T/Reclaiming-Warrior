<?php
$conn = new mysqli('localhost', 'root', '', 'cyber_project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$payment_id = $_POST['payment_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$amount = $_POST['amount'];

$stmt = $conn->prepare("INSERT INTO payments (full_name, email, phone, amount, razorpay_payment_id) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssds", $name, $email, $contact, $amount, $payment_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    http_response_code(200);
    echo "Payment recorded successfully.";
} else {
    http_response_code(500);
    echo "Failed to record payment.";
}
$stmt->close();
$conn->close();
?>