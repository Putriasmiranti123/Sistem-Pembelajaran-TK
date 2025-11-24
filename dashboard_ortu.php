<?php
session_start();

// Cek apakah role sudah benar
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'orangtua') {
    header("Location: login.php");
    exit();
}

// Ambil username untuk ditampilkan
$nama = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Orang Tua</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* HEADER */
        .header {
            background: #4ca0af;
            color: white;
            padding: 25px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);    
        }

        /* Container */
        .container {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        /* Card */
        .card {
            background: white;
            width: 420px;
            padding: 25px 70px;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.12);    
            text-align: center;
        }

        .card h2 {
            font-size: 20px;
            margin-bottom: 25px;
        }

        /* Button */
        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            margin-top: 15px;
            background: #5eafbe;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 17px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background: #3f8793;
            transform: translateY(-2px);
        }

        /* Logout */
        .logout {
            background: #d28819;
        }

        .logout:hover {
            background: #b36a10;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    Dashboard Orang Tua
</div>

<!-- CARD CONTENT -->
<div class="container">
    <div class="card">
        <h2>Halo, <?= $nama; ?> 👋</h2>

        <a href="daftar_anak.php" class="btn">Daftar Anak</a>
        <a href="mulai_belajar.php" class="btn">Mulai Belajar</a>
        <a href="lihat_nilai.php" class="btn">Lihat Nilai Perkembangan</a>
        <a href="pengumuman.php" class="btn">Informasi Pengumuman</a>
        <a href="chat_guru.php" class="btn">Chat dengan Guru</a>

        <a href="logout.php" class="btn logout">Logout</a>
    </div>
</div>

</body>
</html>
