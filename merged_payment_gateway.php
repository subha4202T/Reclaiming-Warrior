<?php
session_start();
$key_id = "rzp_test_2RnEXCgLi65umH"; // Razorpay Test Key ID

// Fetch user details from session after registration
$full_name = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Enroll in Cybersecurity Course</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    /* Same styling preserved */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 15px;
      color: #1a202c;
    }
    .payment-card {
      background: #ffffffee;
      width: 100%;
      max-width: 480px;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
      padding: 40px 35px;
    }
    .payment-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 30px 60px rgba(102, 126, 234, 0.5);
    }
    .header { text-align: center; margin-bottom: 30px; }
    .header h1 {
      font-size: 28px;
      font-weight: 700;
      color: #3b3f5c;
      letter-spacing: 1px;
      text-shadow: 1px 1px 3px rgba(118, 75, 162, 0.3);
    }
    .course-info {
      background: #f5f7ff;
      padding: 20px 18px;
      border-radius: 16px;
      margin-bottom: 35px;
      border: 1.5px solid #8a79e1;
      box-shadow: inset 0 0 10px #b6a8ff88;
    }
    .course-info h2 { font-size: 22px; font-weight: 700; margin-bottom: 10px; color: #5c5e81; }
    .course-info p { font-size: 16px; color: #6e7191; font-weight: 500; }
    form label { display: block; margin-bottom: 8px; font-weight: 600; color: #4a4d6d; }
    form input {
      width: 100%; padding: 14px 18px; margin-bottom: 25px;
      border-radius: 12px; border: 2px solid #dddfff;
      font-size: 15px; font-weight: 500; color: #3b3f5c;
      box-shadow: inset 0 0 6px #e6e8ff;
    }
    form input:focus {
      border-color: #7c5cff; outline: none; box-shadow: 0 0 12px #7c5cffaa;
    }
    .pay-btn {
      background: linear-gradient(90deg, #764ba2, #667eea);
      color: white; border: none; padding: 16px 0; width: 100%;
      font-size: 18px; border-radius: 14px; cursor: pointer;
      font-weight: 700; letter-spacing: 1.1px;
      box-shadow: 0 6px 15px rgba(102, 126, 234, 0.6);
    }
    .pay-btn:hover {
      background: linear-gradient(90deg, #5a3988, #4a63d4);
      box-shadow: 0 8px 20px rgba(90, 57, 136, 0.8);
    }
    .pay-btn:active { transform: scale(0.98); box-shadow: 0 4px 12px rgba(90, 57, 136, 0.5); }
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

  <form id="paymentForm" onsubmit="return false;">
    <label for="name">Full Name</label>
    <input type="text" id="name" value="<?php echo htmlspecialchars($full_name); ?>" readonly />

    <label for="email">Email Address</label>
    <input type="email" id="email" value="<?php echo htmlspecialchars($email); ?>" readonly />

    <label for="contact">Mobile Number</label>
    <input type="text" id="contact" required placeholder="Enter 10-digit mobile number" maxlength="10" inputmode="numeric" pattern="[0-9]{10}" />

    <input type="hidden" id="amount" value="499" />

    <button type="button" class="pay-btn" onclick="payNow()">Pay ₹499 Now</button>
  </form>
</div>

<script>
function payNow() {
  var name = document.getElementById('name').value.trim();
  var email = document.getElementById('email').value.trim();
  var contact = document.getElementById('contact').value.trim();
  var amount = document.getElementById('amount').value;

  if (!name || !email || !contact) {
    alert("Please fill all details.");
    return;
  }

  var contactRegex = /^[0-9]{10}$/;
  if (!contactRegex.test(contact)) {
    alert("Please enter a valid 10-digit mobile number.");
    return;
  }

  var contactWithCode = "+91" + contact;

  var options = {
    "key": "<?php echo $key_id; ?>",
    "amount": amount * 100,
    "currency": "INR",
    "name": "Reclaiming Warrior",
    "description": "Cybersecurity Masterclass Enrollment",
    "image": "https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png",
    "handler": function (response){
      alert("✅ Payment Success! \nPayment ID: " + response.razorpay_payment_id);
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "payment-success.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("payment_id=" + response.razorpay_payment_id + "&name=" + encodeURIComponent(name) + "&email=" + encodeURIComponent(email) + "&contact=" + encodeURIComponent(contactWithCode) + "&amount=" + amount);
    },
    "prefill": {
      "name": name,
      "email": email,
      "contact": contactWithCode
    },
    "theme": { "color": "#764ba2" },
    "method": { "upi": true, "card": true, "netbanking": true, "wallet": true }
  };

  var rzp = new Razorpay(options);
  rzp.open();
}
</script>
</body>
</html>
