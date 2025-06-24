<?php
session_start();


// Fetch user details from session after registration
$full_name = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
$dob = isset($_SESSION['dob']) ? $_SESSION['dob'] : '';
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon" />

    <title>User Profile</title>
    <style>
        body { font-family: sans-serif; background: #f0f0f0; padding: 20px; }
        .profile { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        .profile h2 { text-align: center; }
        .row { margin: 12px 0; }
        .label { font-weight: bold; display: inline-block; width: 150px; }
    </style>
</head>
<body>

<div class="profile">
    <h2>👤 User Profile</h2>
    <div class="row"><span class="label">Username:</span> <?php echo $full_name; ?></div>
    <div class="row"><span class="label">Email:</span> <?php echo $email; ?></div>
	<div class="row"><span class="label">Phone:</span> <?php echo $phone; ?></div>
    <div class="row"><span class="label">Date of Birth:</span> <?php echo $dob; ?></div>
  
  
</div>

</body>
</html>

