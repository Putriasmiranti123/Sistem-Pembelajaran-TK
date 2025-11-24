<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'orangtua') {
    header("Location: login.php?error=Silakan login sebagai ortu");
    exit();
}

$id_ortu = $_SESSION['id'];

include 'koneksi.php';
$sql = "SELECT id_anak, nama, usia, kelas FROM anak WHERE id_ortu='$id_ortu' ORDER BY nama ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Daftar Anak</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0;padding:0;}
.container{max-width:800px;margin:30px auto;background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);}
table{width:100%;border-collapse:collapse;}
th,td{border:1px solid #ccc;padding:10px;text-align:center;}
th{background:#4ca0afff;color:white;}
tr:nth-child(odd){background:#f9f9f9;}
h2{text-align:center;}
.btn-back{display:inline-block;margin-bottom:15px;padding:8px 12px;background:#d28819;color:white;text-decoration:none;border-radius:6px;}
.btn-back:hover{background:#b36a10;}
</style>
</head>
<body>
<div class="container">
<h2>Daftar Anak</h2>
<a href="dashboard_ortu.php" class="btn-back">⬅ Kembali ke Dashboard</a>
<table>
<tr><th>No</th><th>Nama</th><th>Usia</th><th>Kelas</th></tr>
<?php
$no=1;
if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$no++."</td>";
        echo "<td>".htmlspecialchars($row['nama'])."</td>";
        echo "<td>".htmlspecialchars($row['usia'])."</td>";
        echo "<td>".htmlspecialchars($row['kelas'])."</td>";
        echo "</tr>";
    }
}else{
    echo "<tr><td colspan='4'>Belum ada data anak</td></tr>";
}
?>
</table>
</div>
</body>
</html>
