<?php
$conn = new mysqli('localhost', 'root', '', 'cyber_project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['submit'])) {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $card_name = $_POST['cardName'];
    $card_number = $_POST['cardNum'];
    $exp_month = $_POST['expMonth'];
    $exp_year = $_POST['expYear'];
    $cvv = $_POST['cvv'];
    $last4 = substr(str_replace(" ", "", $card_number), -4);
    $query = "INSERT INTO payments (full_name, email, address, city, state, zip_code, card_name, card_number_last4, exp_month, exp_year)
              VALUES ('$full_name', '$email', '$address', '$city', '$state', '$zip', '$card_name', '$last4', '$exp_month', '$exp_year')";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Payment received successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Payment-Page</title>
<link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon" />
<style>
* { margin: 0; padding: 0; box-sizing: border-box; border: none; outline: none; font-family: 'Poppins', sans-serif; text-transform: capitalize; transition: all 0.2s linear; }
.container { display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 25px; background: #d6eef1; }
.container form { width: 700px; padding: 20px; background: #fff; box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2); }
.container form .row { display: flex; flex-wrap: wrap; gap: 15px; }
.container form .row .col { flex: 1 1 250px; }
.col .title { font-size: 20px; color: rgb(237, 55, 23); padding-bottom: 5px; }
.col .inputBox { margin: 15px 0; }
.col .inputBox label { margin-bottom: 10px; display: block; }
.col .inputBox input, .col .inputBox select { width: 100%; border: 1px solid #ccc; padding: 10px 15px; font-size: 15px; }
.col .inputBox input:focus, .col .inputBox select:focus { border: 1px solid #000; }
.col .flex { display: flex; gap: 15px; }
.col .flex .inputBox { flex: 1 1; margin-top: 5px; }
.col .inputBox img { height: 34px; margin-top: 5px; filter: drop-shadow(0 0 1px #000); }
.container form .submit_btn { width: 100%; padding: 12px; font-size: 17px; background: rgb(1, 143, 34); color: #fff; margin-top: 5px; cursor: pointer; letter-spacing: 1px; }
.container form .submit_btn:hover { background: #3d17fb; }
input::-webkit-inner-spin-button, input::-webkit-outer-spin-button { display: none; }
</style>
</head>

<body>
<div class="container">
<form action="" method="POST">
    <div class="row">
        <div class="col">
            <h3 class="title">Billing Address</h3>
            <div class="inputBox"><label for="name">Full Name:</label><input type="text" name="name" placeholder="Enter your full name" required></div>
            <div class="inputBox"><label for="email">Email:</label><input type="text" name="email" placeholder="Enter email address" required></div>
            <div class="inputBox"><label for="address">Address:</label><input type="text" name="address" placeholder="Enter address" required></div>
            <div class="inputBox"><label for="city">City:</label><input type="text" name="city" placeholder="Enter city" required></div>
            <div class="flex">
                <div class="inputBox"><label for="state">State:</label><input type="text" name="state" placeholder="Enter state" required></div>
                <div class="inputBox"><label for="zip">Zip Code:</label><input type="number" name="zip" placeholder="123456" required></div>
            </div>
        </div>
        <div class="col">
            <h3 class="title">Payment</h3>
            <div class="inputBox"><label>Card Accepted:</label><img src="https://bucket-qcmpq1.s3.us-east-2.amazonaws.com/wp-content/uploads/2020/06/29203137/major-credit-card-logos-png-5.png" alt="Cards"></div>
            <div class="inputBox"><label for="cardName">Name On Card:</label><input type="text" name="cardName" placeholder="Enter card name" required></div>
            <div class="inputBox"><label for="cardNum">Credit Card Number:</label><input type="text" name="cardNum" placeholder="1111-2222-3333-4444" maxlength="19" required></div>
            <div class="inputBox"><label for="expMonth">Exp Month:</label>
                <select name="expMonth" required>
                    <option value="">Choose month</option>
                    <option value="01">January</option><option value="02">February</option>
                    <option value="03">March</option><option value="04">April</option>
                    <option value="05">May</option><option value="06">June</option>
                    <option value="07">July</option><option value="08">August</option>
                    <option value="09">September</option><option value="10">October</option>
                    <option value="11">November</option><option value="12">December</option>
                </select>
            </div>
            <div class="flex">
                <div class="inputBox"><label for="expYear">Exp Year:</label>
                    <select name="expYear" required>
                        <option value="">Choose Year</option>
                        <option value="2023">2023</option><option value="2024">2024</option>
                        <option value="2025">2025</option><option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                </div>
                <div class="inputBox"><label for="cvv">CVV</label><input type="number" name="cvv" placeholder="123" required></div>
            </div>
        </div>
    </div>
    <input type="submit" name="submit" value="Proceed to Checkout" class="submit_btn">
</form>
</div>
<script>
    let cardNumInput = document.querySelector('input[name="cardNum"]');
    cardNumInput.addEventListener('keyup', () => {
        let cNumber = cardNumInput.value.replace(/\s/g, "");
        if (Number(cNumber)) {
            cNumber = cNumber.match(/.{1,4}/g);
            cardNumInput.value = cNumber.join(" ");
        }
    });
</script>
</body>
</html>
