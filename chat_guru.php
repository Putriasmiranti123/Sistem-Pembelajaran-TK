<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'orangtua') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Chat Guru</title>
<style>
    body { background:#eef2f3; font-family: Arial; padding:25px; }
    .container {
        width:70%;
        margin:auto;
        background:white;
        padding:20px;
        border-radius:10px;
        box-shadow:0 4px 12px rgba(0,0,0,0.1);
    }
    textarea {
        width:100%;
        height:120px;
        padding:10px;
        border-radius:6px;
        border:1px solid #aaa;
    }
    button {
        background:#4a90e2;
        color:white;
        border:none;
        padding:10px 20px;
        border-radius:6px;
        cursor:pointer;
        margin-top:10px;
    }
</style>
</head>

<body>

<div class="container">
    <h2>Hubungi Guru</h2>

    <form>
        <label>Kirim Pesan:</label><br>
        <textarea placeholder="Tulis pesan Anda..."></textarea><br>
        <button>Kirim</button>
    </form>
</div>

<br><center><a href="dashboard_ortu.php">⬅ Kembali</a></center>

</body>
</html>
