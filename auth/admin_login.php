<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | Reclaiming Warrior</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  

  <link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon" />

  
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">

  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background: radial-gradient(circle at top, #0f2027, #203a43, #2c5364);
      font-family: 'Orbitron', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #ffffff;
      overflow: hidden;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
      padding: 40px 30px;
      border-radius: 16px;
      width: 100%;
      max-width: 360px;
      text-align: center;
    }

    .login-box h2 {
      margin-bottom: 25px;
      font-size: 22px;
      font-weight: 600;
      letter-spacing: 1px;
      color: #00e6e6;
      text-shadow: 0 0 10px rgba(0,230,230,0.4);
    }

    .login-box input {
      width: 100%;
      padding: 14px;
      margin-bottom: 18px;
      border: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      font-size: 15px;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
    }

    .login-box input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.2);
      box-shadow: 0 0 0 2px #00e6e6;
    }

    .login-box button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #00e6e6, #007a7a);
      color: #000;
      font-weight: bold;
      font-size: 15px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.3s ease;
      letter-spacing: 1px;
    }

    .login-box button:hover {
      background: linear-gradient(135deg, #00f6ff, #008b8b);
    }

    .login-box i {
      color: #00e6e6;
      font-size: 24px;
      margin-bottom: 15px;
    }
  </style>
</head>

<body>

  <div class="login-box">
    <i class="fas fa-user-shield"></i>
    <h2>Admin Login</h2>
    <form action="admin_auth.php" method="post">
      <input type="text" name="admin_username" placeholder="👨‍💻 Admin Username" required>
      <input type="password" name="admin_password" placeholder="🔐 Password" required>
      <button type="submit">Access Panel</button>
    </form>
  </div>

</body>
</html>
