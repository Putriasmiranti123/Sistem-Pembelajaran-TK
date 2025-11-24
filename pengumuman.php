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
<title>Pengumuman</title>
<style>
    body { font-family: Arial; background:#f1f5f8; padding:20px; }
    .box {
        width:80%;
        margin:auto;
        background:white;
        padding:20px;
        box-shadow:0 3px 10px rgba(0,0,0,0.1);
        border-radius:8px;
    }
    h2 { text-align:center; }
    .item {
        background:#e6f0ff;
        padding:12px;
        border-radius:6px;
        margin-bottom:12px;
    }
</style>
</head>

<body>

<h2>Pengumuman Sekolah</h2>

<div class="box">

    <div class="item">
        <b>📢 Libur Akhir Semester</b><br>
        Mulai tanggal 18 Desember 2025.
    </div>

    <div class="item">
        <b>📢 Pengambilan Raport</b><br>
        Dilaksanakan 20 Desember 2025.
    </div>

</div>

<br><center><a href="dashboard_ortu.php">⬅ Kembali</a></center>

</body>
</html>
