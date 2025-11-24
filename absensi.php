<?php
session_start();

// Cek role guru
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'] ?? 'Guru';

// Koneksi database
$conn = new mysqli("localhost", "root", "", "projek_web");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Proses tambah absensi
$pesan = "";
if(isset($_POST['submit'])) {
    $murid_id = $_POST['murid_id'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'];

    $sql = "INSERT INTO absensi (murid_id, tanggal, status, keterangan) 
            VALUES ('$murid_id','$tanggal','$status','$keterangan')";
    if($conn->query($sql)) {
        $pesan = "Absensi berhasil ditambahkan!";
    } else {
        $pesan = "Gagal menambahkan absensi: ".$conn->error;
    }
}

// Ambil daftar murid untuk dropdown
$murid_result = $conn->query("SELECT id_murid, nama_lengkap FROM murid ORDER BY nama_lengkap ASC");

// Ambil data absensi
$absen_result = $conn->query("
    SELECT a.id_absen, m.nama_lengkap, a.tanggal, a.status, a.keterangan
    FROM absensi a
    LEFT JOIN murid m ON a.murid_id = m.id_murid
    ORDER BY a.tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Absensi Murid</title>
<link rel="stylesheet" href="style.css">    
<style>
            /* ===== Body & Font ===== */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                background-size: cover;       /* Cover seluruh layar */
                background-position: center;  /* Posisi tengah */
                background-attachment: fixed; /* Tetap saat scroll */
                background-repeat: no-repeat;
            }

            /* Overlay untuk membuat teks tetap terbaca */
            body::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(245, 245, 245, 0.7); /* Warna overlay semi-transparent */
                z-index: -1;
            }

            /* ===== Header ===== */
            .header {
                background-color: #4ca0afff;
                color: white;
                padding: 18px;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            }

            /* ===== Container ===== */
            .container {
                padding: 30px;
                max-width: 900px;
                margin: 30px auto;
                background-color: rgba(255,255,255,0.95); /* Semi-transparent */
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.2);
            }

            /* ===== Tombol Kembali ===== */
            .btn-back {
                display: inline-block;
                background-color: #d28819ff;
                color: white;
                text-decoration: none;
                padding: 10px 15px;
                border-radius: 6px;
                margin-bottom: 15px;
                transition: background 0.3s;
            }

            .btn-back:hover {
                background-color: #b30000;
            }

            /* ===== Tabel ===== */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 14px;
            }

            /* Header Tabel */
            th {
                background-color: #70abdaff;
                color: white;
                padding: 10px;
                text-align: left;
                font-weight: bold;
            }

            /* Sel Tabel */
            td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
                vertical-align: middle;
            }

            /* Baris ganjil untuk readability */
            tr:nth-child(odd) {
                background-color: #f9f9f9;
            }

            /* ===== Form Input ===== */
            .form-input {
                margin-top: 20px;
                padding: 20px;
                border-radius: 10px;
                background-color: rgba(255,255,255,0.95);
                box-shadow: 0 0 10px rgba(0,0,0,0.2);
            }

            .form-input input,
            .form-input select,
            .form-input textarea {
                width: 100%;
                padding: 10px;
                margin: 8px 0;
                border-radius: 6px;
                border: 1px solid #ccc;
            }

            .form-input button {
                padding: 10px 15px;
                background-color: #70abdaff;
                color: white;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                transition: background 0.3s;
            }

            .form-input button:hover {
                background-color: #1976D2;
            }

            /* ===== Pesan sukses ===== */
            .pesan {
                margin-top: 10px;
                padding: 10px;
                background-color: #d0ffd0;
                border: 1px solid #70abdaff;
                border-radius: 6px;
                color: #333;
            }

            /* ===== Responsif ===== */
            @media screen and (max-width: 600px) {
                .container {
                    padding: 15px;
                    margin: 15px;
                }
                table, th, td {
                    font-size: 12px;
                }
                .form-input {
                    padding: 15px;
                }
            }
    </style>
</head>
<body>
<div class="header">Absensi Murid</div>
<div class="container">
    <a href="dashboard_guru.php" class="btn-back">⬅ Kembali</a>

    <?php if($pesan != ""): ?>
        <div class="pesan"><?php echo $pesan; ?></div>
    <?php endif; ?>

    <!-- Form Tambah Absensi -->
    <div class="form-input">
        <h3>Tambah Absensi</h3>
        <form method="POST">
            <label>Pilih Murid</label>
            <select name="murid_id" required>
                <option value="">-- Pilih Murid --</option>
                <?php
                if($murid_result->num_rows > 0){
                    while($m = $murid_result->fetch_assoc()){
                        echo "<option value='".$m['id_murid']."'>".htmlspecialchars($m['nama_lengkap'])."</option>";
                    }
                }
                ?>
            </select>
            <label>Tanggal</label>
            <input type="date" name="tanggal" required>
            <label>Status</label>
            <select name="status" required>
                <option value="">-- Pilih Status --</option>
                <option value="Hadir">Hadir</option>
                <option value="Sakit">Sakit</option>
                <option value="Izin">Izin</option>
            </select>
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Keterangan tambahan"></textarea>
            <button type="submit" name="submit">Tambah Absensi</button>
        </form>
    </div>

    <!-- Tabel Absensi -->
    <table>
        <tr>
            <th>No</th>
            <th>Nama Murid</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
        <?php
        $no = 1;
        if($absen_result->num_rows > 0){
            while($row = $absen_result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".htmlspecialchars($row['nama_lengkap'])."</td>";
                echo "<td>".htmlspecialchars($row['tanggal'])."</td>";
                echo "<td>".htmlspecialchars($row['status'])."</td>";
                echo "<td>".htmlspecialchars($row['keterangan'])."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Belum ada data absensi</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
