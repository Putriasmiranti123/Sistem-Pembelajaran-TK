<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'orangtua') {
    header("Location: login.php");
    exit();
}
include "koneksi.php";

$materi = mysqli_query($conn, "SELECT * FROM materi");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lihat Materi</title>
<style>
    body { font-family: Arial; background:#eef2f3; padding:20px; }
    h2 { text-align:center; }
    table {
        width: 80%;
        margin: auto;
        border-collapse: collapse;
        background:white;
        box-shadow:0 3px 10px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }
    th { background:#4a90e2; color:white; }
    a.btn {
        background:#4a90e2;
        padding:6px 12px;
        color:white;
        border-radius:5px;
        text-decoration:none;
    }
</style>
</head>

<body>
<h2>Materi Pembelajaran</h2>

<table>
    <tr>
        <th>Judul</th>
        <th>File</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($materi)): ?>
    <tr>
        <td><?= $row['judul'] ?></td>
        <td><a class="btn" href="<?= $row['file_path'] ?>" download>Download</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<br><center><a href="dashboard_ortu.php">⬅ Kembali</a></center>
</body>
</html>
