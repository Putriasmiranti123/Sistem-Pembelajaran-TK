<?php
// login.php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Koneksi database
    $conn = new mysqli('localhost', 'root', '', 'login_db');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    // Query untuk cek user dan role
    $stmt = $conn->prepare('SELECT password FROM users WHERE username = ? AND role = ?');
    $stmt->bind_param('ss', $username, $role);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            
            // Redirect berdasarkan role
            if ($role === 'guru') {
                header('Location: dashboard_guru.php');
            } elseif ($role === 'orangtua') {
                header('Location: dashboard_orangtua.php');
            }
            exit();
        } else {
            echo 'Password salah!';
        }
    } else {
        echo 'Username atau role tidak ditemukan!';
    }
    
    $stmt->close();
    $conn->close();
}
?>