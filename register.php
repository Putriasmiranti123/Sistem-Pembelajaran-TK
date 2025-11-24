<?php
session_start();
include 'koneksi.php'; // koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // bisa 'guru' atau 'ortu'

    // cek email atau username sudah ada atau belum
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=? LIMIT 1");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        $error = "Username atau email sudah terdaftar!";
    } else {
        // hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // insert data ke database
        $stmt = $conn->prepare("INSERT INTO users (username,email,password,role) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

        if($stmt->execute()){
            $success = "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
        } else {
            $error = "Terjadi kesalahan: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register - Sistem Pembelajaran TK</title>
<link rel="stylesheet" href="style.css">
<style>
body {
    margin:0;
    font-family: Arial, sans-serif;
    height:100vh;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
}
.register-container {
    background-color: rgba(255,255,255,0.9);
    border: 2px solid #4ca0afff;
    border-radius: 12px;
    padding: 40px 30px;
    width: 350px;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
    text-align: center;
}
.register-container h2 {
    margin-bottom: 20px;
    color: #333;
    font-weight: bold;
}
.register-container input, .register-container select {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #bbb;
}
.register-container button {
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
.register-container button:hover {
    background-color: #1976D2;
}
.register-container a {
    color: #4a74ff;
    text-decoration: none;
}
.error {color: red; margin-top: 10px;}
.success {color: green; margin-top: 10px;}
</style>
</head>
<body>

<div class="register-container">
<h2>Daftar Akun</h2>

<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
<?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>

<form action="" method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="role" required>
        <option value="">-- Pilih Role --</option>
        <option value="guru">Guru</option>
        <option value="orangtua">Orang Tua</option>
    </select><br>
    <button type="submit">Daftar</button>
</form>

<p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>

</body>
</html>
