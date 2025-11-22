<?php
// index.php
  if (isset($_COOKIE['remember'])) {
      $data = json_decode($_COOKIE['remember'], true);
      $remember_username = $data['username'] ?? '';
      $remember_role = $data['role'] ?? '';
      echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
              document.getElementById('username').value = '$remember_username';
              document.getElementById('role').value = '$remember_role';
          });
      </script>";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beranda Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Beranda</h1>
        <h2>Login</h2>
        <form id="loginForm" action="login.php" method="POST">
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="guru">Guru</option>
                <option value="orangtua">Orangtua</option>
            </select>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p id="error"></p>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>