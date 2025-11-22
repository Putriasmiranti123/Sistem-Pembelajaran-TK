<?php
// chat_orangtua.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'orangtua') {
    header('Location: index.html');
    exit();
}
$orangtua = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];
    
    $conn = new mysqli('localhost', 'root', '', 'login_db');
    $stmt = $conn->prepare('INSERT INTO chat (sender, receiver, message) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $orangtua, $receiver, $message);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: dashboard_orangtua.php');
}
?>