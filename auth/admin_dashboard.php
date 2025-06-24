<?php

include(__DIR__ . '/../db/db_config.php');

session_start();
// if (!isset($_SESSION['is_admin'])) { header("Location: index.php"); exit(); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <link rel="shortcut icon" href="https://www.freepnglogos.com/uploads/warriors-png-logo/reclaiming-warrior-png-logo-10.png" type="image/x-icon" />
   <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f4;
      display: flex;
    }

    .sidebar {
      width: 220px;
      background-color: #2c3e50;
      height: 100vh;
      color: white;
      padding-top: 20px;
      position: fixed;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .sidebar a {
      display: block;
      padding: 12px 20px;
      color: white;
      text-decoration: none;
      border-bottom: 1px solid #34495e;
    }

    .sidebar a:hover {
      background-color: #34495e;
    }

    .main {
      margin-left: 220px;
      padding: 40px;
      width: 100%;
    }

    .section {
      display: none;
    }

    .section.active {
      display: block;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: #3498db;
      color: white;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <h2>🔐 Admin Panel</h2>
  <a href="#" onclick="showSection('users')">👥 Logged-in Users</a>
  <a href="#" onclick="showSection('qa')">❓ Q&A</a>
  <a href="logout.php">🚪 Logout</a>
</div>

<div class="main">
  <!-- 👥 Users Section -->
  <div id="users" class="section active">
    <h2>👥 Registered Users</h2>
    <table>
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Date of Birth</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include('../db/db_config.php');

        $result = $conn->query("SELECT username, email, phone, dob FROM users");

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['dob']}</td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='4'>No users found.</td></tr>";
        }

        $conn->close();
        ?>
      </tbody>
    </table>
  </div>

  <!-- ❓ Q&A Section -->
  <div id="qa" class="section">
    <h2>❓ Submitted Questions & Answers</h2>
    <p>This section can be connected to a Q&A table in the database.</p>
    <p>Example data:</p>
    <ul>
      <li><strong>User:</strong> Subhadip Dutta</li>
      <li><strong>Q:</strong> What is the refund policy?</li>
      <li><strong>A:</strong> We offer a 7-day refund for valid reasons.</li>
    </ul>
  </div>
</div>

<script>
  function showSection(id) {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.classList.remove('active'));
    document.getElementById(id).classList.add('active');
  }
</script>

</body>
</html>
