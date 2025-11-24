<?php
include 'includes/koneksi.php';

// ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];

// hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// simpan ke database
$query = "INSERT INTO users (username, password, role) 
          VALUES ('$username', '$hashed_password', '$role')";

if (mysqli_query($conn, $query)) {
    echo "Registrasi berhasil! <a href='login.php'>Login sekarang</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
