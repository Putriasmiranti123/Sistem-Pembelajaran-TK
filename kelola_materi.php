<?php
session_start();

// Cek role guru
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'] ?? 'Guru';
$uploader_id = $_SESSION['id_user'] ?? 1; // id guru yang login

// Koneksi database
$conn = new mysqli("localhost", "root", "", "projek_web");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Proses upload materi
$pesan = "";
if(isset($_POST['upload'])){
    $judul = $_POST['judul'];
    $file = $_FILES['file'];

    if($file['error'] === 0){
        $target_dir = "uploads/";
        if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $file_name = time() . "_" . basename($file['name']);
        $target_file = $target_dir . $file_name;

        if(move_uploaded_file($file['tmp_name'], $target_file)){
            $sql = "INSERT INTO materi (judul, file_path, uploader_id) 
                    VALUES ('$judul','$target_file','$uploader_id')";
            if($conn->query($sql)){
                $pesan = "Materi berhasil diupload!";
            } else {
                $pesan = "Gagal menyimpan data materi: ".$conn->error;
            }
        } else {
            $pesan = "Gagal mengunggah file.";
        }
    } else {
        $pesan = "File tidak valid.";
    }
}

// Proses hapus materi
if(isset($_GET['hapus'])){
    $id_hapus = $_GET['hapus'];
    // Ambil file_path sebelum dihapus
    $res = $conn->query("SELECT file_path FROM materi WHERE id_materi='$id_hapus'");
    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        if(file_exists($row['file_path'])) unlink($row['file_path']); // hapus file fisik
    }
    $conn->query("DELETE FROM materi WHERE id_materi='$id_hapus'");
    header("Location: kelola_materi.php");
    exit();
}

// Ambil daftar materi
$materi_result = $conn->query("SELECT * FROM materi ORDER BY id_materi DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Materi</title>
<link rel="stylesheet" href="style.css"> 
<style>
body { font-family: Arial, sans-serif; margin:0; }
.header { background: #4ca0afff; color: white; padding: 18px; text-align: center; font-size: 24px; }
.container { padding: 30px; max-width: 900px; margin: auto; background-color: rgba(255,255,255,0.95); border-radius: 10px; }
.btn-back { background: #d28819ff; padding: 10px 15px; border-radius: 6px; color: white; text-decoration: none; display: inline-block; margin-bottom: 15px; }
.btn-back:hover { background: #b30000; }
.form-input { margin-top: 20px; padding: 20px; border-radius: 10px; background-color: rgba(255,255,255,0.95); box-shadow: 0 0 10px rgba(0,0,0,0.2); }
.form-input input, .form-input textarea { width: 100%; padding: 10px; margin: 8px 0; border-radius: 6px; border: 1px solid #ccc; }
.form-input button { padding: 10px 15px; background: #70abdaff; color: white; border: none; border-radius: 6px; cursor: pointer; }
.form-input button:hover { background: #1976D2; }
.pesan { margin-top: 10px; padding: 10px; background: #d0ffd0; border: 1px solid #70abdaff; border-radius: 6px; color: #333; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
th { background: #70abdaff; color: white; }
tr:nth-child(odd) { background-color: #f9f9f9; }
a.hapus { color: red; text-decoration: none; }
a.hapus:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="header">Kelola Materi</div>
<div class="container">
    <a href="dashboard_guru.php" class="btn-back">⬅ Kembali</a>

    <?php if($pesan != ""): ?>
        <div class="pesan"><?php echo $pesan; ?></div>
    <?php endif; ?>

    <!-- Form Upload Materi -->
    <div class="form-input">
        <h3>Upload Materi</h3>
        <form method="POST" enctype="multipart/form-data">
            <label>Judul Materi</label>
            <input type="text" name="judul" required placeholder="Masukkan judul materi">
            <label>File</label>
            <input type="file" name="file" required>
            <button type="submit" name="upload">Upload</button>
        </form>
    </div>

    <!-- Tabel Daftar Materi -->
    <table>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>File</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        if($materi_result->num_rows > 0){
            while($row = $materi_result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".htmlspecialchars($row['judul'])."</td>";
                echo "<td><a href='".htmlspecialchars($row['file_path'])."' target='_blank'>Lihat File</a></td>";
                echo "<td><a class='hapus' href='?hapus=".$row['id_materi']."' onclick=\"return confirm('Yakin hapus materi ini?')\">Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Belum ada materi</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
