<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login - Sistem Pembelajaran TK</title>
<link rel="stylesheet" href="style.css">
<style>
body {
    margin:0;
    font-family: Arial, sans-serif;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.login-container {
    background-color: rgba(255,255,255,0.95);
    border: 2px solid #4ca0afff;
    border-radius: 12px;
    padding: 40px 30px;
    width: 350px;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
    text-align: center;
}
.login-container h2 {
    margin-bottom: 20px;
    color: #333;
    font-weight: bold;
}
.login-container input {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #bbb;
}
.login-container button {
    width: 95%;
    padding: 10px 0;
    margin-top: 15px;
    background-color: #4ca0afff;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}
.login-container button:hover {
    background-color: #1976D2;
}
.login-container a {
    color: #4a74ff;
    text-decoration: none;
}
.error {color: red; margin-top: 10px;}
.success {color: green; margin-top: 10px;}
</style>
</head>
<body>

<div class="login-container">
<h2>Login Akun</h2>

<?php 
if(isset($_GET['error'])) echo "<div class='error'>".$_GET['error']."</div>";
if(isset($_GET['success'])) echo "<div class='success'>".$_GET['success']."</div>";
?>

<form action="proses_login.php" method="POST">
    <input type="text" name="user_identifier" placeholder="Username atau Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>

<p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</div>

</body>
</html>
