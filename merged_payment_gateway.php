<?php
$key_id = "rzp_test_2RnEXCgLi65umH"; // Razorpay Test Key ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enroll in Cybersecurity Course</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }
    body {
      background-color: #f9fbfd;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 15px;
    }
    .payment-card {
      background: #fff;
      width: 100%;
      max-width: 700px;
      border-radius: 16px;
      box-shadow: 0 0 25px rgba(0,0,0,0.1);
      padding: 35px 30px;
    }
    .header {
      text-align: center;
      margin-bottom: 25px;
    }
    .header h1 {
      font-size: 26px;
      color: #1a202c;
    }
    .course-info {
      background: #edf2f7;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 25px;
    }
    .course-info h2 {
      font-size: 20px;
      margin-bottom: 8px;
      color: #2d3748;
    }
    .course-info p {
      font-size: 15px;
      color: #4a5568;
    }
    form label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #2d3748;
    }
    form input {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 8px;
      border: 1px solid #cbd5e0;
      font-size: 14px;
    }
    .pay-btn {
      background: #2b6cb0;
      color: white;
      border: none;
      padding: 14px;
      width: 100%;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }
    .pay-btn:hover {
      background: #2c5282;
    }
    @media (max-width: 600px) {
      .payment-card {
        padding: 25px 20px;
      }
    }
  </style>
</head>
<body>
<div class="payment-card">
  <div class="header">
    <h1>Enroll in Reclaiming Warrior: Cybersecurity Course</h1>
  </div>
  <div class="course-info">
    <h2>Cybersecurity Mastery</h2>
    <p>Duration: 8 Weeks • Certificate Included • ₹499 only</p>
  </div>

  <form id="paymentForm">
    <label for="name">Full Name</label>
    <input type="text" id="name" required>

    <label for="email">Email Address</label>
    <input type="email" id="email" required>

    <label for="contact">Mobile Number</label>
    <input type="text" id="contact" required>

    <input type="hidden" id="amount" value="499">

    <button type="button" class="pay-btn" onclick="payNow()">Pay ₹499 Now</button>
  </form>
</div>

<script>
function payNow() {
  var name = document.getElementById('name').value;
  var email = document.getElementById('email').value;
  var contact = document.getElementById('contact').value;
  var amount = document.getElementById('amount').value;

  if (!name || !email || !contact) {
    alert("Please fill all details.");
    return;
  }

  var options = {
    "key": "<?php echo $key_id; ?>",
    "amount": amount * 100,
    "currency": "INR",
    "name": "Reclaiming Warrior",
    "description": "Cybersecurity Masterclass Enrollment",
    "image": "https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png",
    "handler": function (response){
      alert("Payment Success!\nPayment ID: " + response.razorpay_payment_id);
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "payment-success.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("payment_id=" + response.razorpay_payment_id + "&name=" + name + "&email=" + email + "&contact=" + contact + "&amount=" + amount);
    },
    "prefill": {
        "name": name,
        "email": email,
        "contact": contact
    },
    "theme": {
        "color": "#3182ce"
    },
    "method": {
        "upi": true,
        "card": true,
        "netbanking": true,
        "wallet": true
    }
  };

  var rzp = new Razorpay(options);
  rzp.open();
}
</script>
</body>
</html>
