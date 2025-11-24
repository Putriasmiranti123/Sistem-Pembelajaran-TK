<?php
session_start();

// Cek role guru
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: ../login.php");
    exit();
}

// Ambil username
$username = $_SESSION['username'] ?? 'Guru';

// Koneksi database
$conn = new mysqli("localhost", "root", "", "projek_web"); // ganti nama_database
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Pesan sukses/gagal
$pesan = "";

// Proses input nilai
if (isset($_POST['submit'])) {
    $murid_id = $_POST['murid_id'];
    $aspek = $_POST['aspek_penilaian'];
    $nilai = $_POST['hasil_nilai']; // ENUM, bukan angka

    if ($murid_id && $aspek && $nilai) {
        $sql = "INSERT INTO nilai (murid_id, aspek_penilaian, hasil_nilai)
                VALUES ('$murid_id','$aspek','$nilai')";

        if ($conn->query($sql)) {
            $pesan = "Nilai berhasil disimpan!";
        } else {
            $pesan = "Gagal menyimpan nilai: " . $conn->error;
        }
    } else {
        $pesan = "Semua field harus diisi!";
    }
}

// Ambil daftar murid untuk dropdown
$murid_result = $conn->query("SELECT id_murid, nama_lengkap FROM murid ORDER BY nama_lengkap ASC");

// Ambil semua nilai untuk tabel
$nilai_result = $conn->query("
    SELECT n.id_nilai, m.nama_lengkap, n.aspek_penilaian, n.hasil_nilai, n.tanggal_input
    FROM nilai n
    LEFT JOIN murid m ON n.murid_id = m.id_murid
    ORDER BY n.id_nilai DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Penilaian Harian</title>
<link rel="stylesheet" href="style.css">
<style>
        /* Body & Background */
        body {
            font-family: Arial, sans-serif;
            margin: 0;              /* Hilangkan margin default */
            background-size: cover; /* Biarkan gambar menutupi seluruh halaman */
        }

        /* Header */
        .header {
            background: #4ca0afff;      /* Warna header */
            color: white;                 /* Warna teks */
            padding: 18px;                  /* Jarak dalam */
            text-align: center;      /* Rata tengah */
            font-size: 24px;           /* Ukuran font */
            font-weight: bold;      /* Tebal font */
        }

        /* Container utama */
        .container {
            padding: 20px;                  /* Jarak dalam */
            max-width: 800px;           /* Lebar maksimal */
            margin: auto;           /* Tengah secara horizontal */
            background-color: rgba(255, 255, 255, 0.95); /* Transparansi agar background terlihat */
            border-radius: 10px;        /* Sudut membulat */
        }       

        /* Tombol kembali */
        .btn-back {
            display: inline-block;          /* Agar bisa diatur padding dan margin */
            margin-bottom: 10px;            /* Jarak bawah */
            background: #d28819ff;        /* Warna tombol */
            color: white;                   /* Warna teks */
            text-decoration: none;          /* Hilangkan garis bawah */
            padding: 15px 15px;             /* Jarak dalam */
            border-radius: 6px;             /* Sudut membulat */
            margin-bottom: 15px;            /* Jarak bawah */
            transition: 0.3s;               /* Transisi warna background */   
        }
        .btn-back:hover {
            background: #b30000;
        }

        /* Form input */
        .form-input {
            margin-top: 20px;               /* Jarak atas */    
            padding: 20px;              /* Jarak dalam */
            border-radius: 10px;        /* Sudut membulat */
            background-color: rgba(255, 255, 255, 0.95);        /* Transparansi agar background terlihat */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);        /* Bayangan halus */
        }

        /* Input, select dalam form */
        .form-input input,              /* Input teks */
        .form-input select {          /* Dropdown select */
            width: 99%;           /* Lebar penuh */
            padding: 10px;           /* Jarak dalam */
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        /* Tombol submit */
        .form-input button {
            padding: 10px 15px;             /* Jarak dalam */
            background: #0073b1ff;  /* Warna tombol */
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        .form-input button:hover {
            background: #66cf7bff;  /* Warna tombol saat hover */
        }

        /* Pesan sukses / error */
        .pesan {
            margin-top: 10px;
            padding: 10px;
            background: #ff5c5cff;            /* Warna latar belakang hijau muda */
            border: 1px solid #70abdaff;
            border-radius: 6px;
            color: #ffffffff;
        }

        /* Tabel nilai */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #70abdaff;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        /* Responsif untuk layar kecil */
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

<div class="header">Penilaian / Laporan Harian</div>
<div class="container">
    <a href="dashboard_guru.php" class="btn-back">⬅ Kembali</a>

    <?php if($pesan != ""): ?>
        <div class="pesan"><?php echo $pesan; ?></div>
    <?php endif; ?>

    <!-- Form Input Nilai -->
    <div class="form-input">
        <h3>Input Nilai Murid</h3>
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

            <label>Aspek Penilaian</label>
            <select name="aspek_penilaian" required>
                <option value="">-- Pilih Aspek --</option>
                <option value="Kognitif">Kognitif</option>
                <option value="Sosial">Sosial</option>
                <option value="Motorik">Motorik</option>
                <option value="Bahasa">Bahasa</option>
            </select>

            <label>Hasil Nilai</label>
            <input type="number" name="hasil_nilai" min="0" max="100" placeholder="Masukkan nilai 0-100" required>

            <button type="submit" name="submit">Simpan Nilai</button>
        </form>
    </div>

    <!-- Tabel Nilai Murid -->
    <table>
        <tr>
            <th>No</th>
            <th>Nama Murid</th>
            <th>Aspek Penilaian</th>
            <th>Hasil Nilai</th>
            <th>Tanggal Input</th>
        </tr>
        <?php
        $no = 1;
        if($nilai_result->num_rows > 0){
            while($row = $nilai_result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".htmlspecialchars($row['nama_lengkap'])."</td>";
                echo "<td>".htmlspecialchars($row['aspek_penilaian'])."</td>";
                echo "<td>".htmlspecialchars($row['hasil_nilai'])."</td>";
                echo "<td>".htmlspecialchars($row['tanggal_input'])."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Belum ada data nilai</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
