<?php
// register.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $conn = new mysqli('localhost', 'root', '', 'login_db');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    $stmt = $conn->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $username, $password, $role);
    if ($stmt->execute()) {
        echo 'Registrasi berhasil! <a href="index.php">Kembali ke Beranda</a>';
    } else {
        echo 'Error: ' . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo '<h1>Registrasi</h1>';
    echo '<form action="register.php" method="POST">';
    echo '<label for="role">Role:</label>';
    echo '<select name="role" required><option value="guru">Guru</option><option value="orangtua">Orangtua</option></select>';
    echo '<label for="username">Username:</label>';
    echo '<input type="text" name="username" required>';
    echo '<label for="password">Password:</label>';
    echo '<input type="password" name="password" required>';
    echo '<button type="submit">Daftar</button>';
    echo '</form>';
}
?>