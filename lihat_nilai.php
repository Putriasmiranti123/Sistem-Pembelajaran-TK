<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'orangtua') {
    header("Location: login.php");
    exit();
}
include "koneksi.php";

$nilai = mysqli_query($conn,
"SELECT murid.nama_lengkap, nilai.aspek_penilaian, nilai.hasil_nilai
 FROM nilai 
 JOIN murid ON murid.id_murid = nilai.murid_id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lihat Nilai</title>
<style>
    body { font-family: Arial; background:#eef2f3; padding:20px; }
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
</style>
</head>

<body>

<h2 style="text-align:center;">Nilai Anak</h2>

<table>
<tr>
    <th>Nama Anak</th>
    <th>Aspek</th>
    <th>Nilai</th>
</tr>

<?php while($row = mysqli_fetch_assoc($nilai)): ?>
<tr>
    <td><?= $row['nama_lengkap'] ?></td>
    <td><?= $row['aspek_penilaian'] ?></td>
    <td><?= $row['hasil_nilai'] ?></td>
</tr>
<?php endwhile; ?>

</table>

<br><center><a href="dashboard_ortu.php">⬅ Kembali</a></center>

</body>
</html>
