<?php
session_start();
include 'koneksi.php';

$user = $_POST['user_identifier'];
$pass = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$user' OR email='$user' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($pass, $row['password'])) {

        // SET SESSION YANG BENAR
        $_SESSION['id_user'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Arahkan berdasarkan role
        if ($row['role'] == "orangtua") {
            header("Location: dashboard_ortu.php");
        } elseif ($row['role'] == "guru") {
            header("Location: dashboard_guru.php");
        } else {
            header("Location: login.php?error=Role tidak dikenali");
        }
        exit();
    } 
}

header("Location: login.php?error=Username atau password salah");
exit();
?>
