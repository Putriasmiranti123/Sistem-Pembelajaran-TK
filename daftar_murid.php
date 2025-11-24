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

// Ambil data semua murid, urut descending berdasarkan id_murid
$sql = "SELECT * FROM murid ORDER BY id_murid DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Murid</title>
<link rel="stylesheet" href="style.css">
    <style>
        /* ===== Body & Font ===== */
        body {
            font-family: Arial, sans-serif;
            margin: 0;                      /* Hilangkan margin default */
            background-color: #f5f5f5; /* Background netral agar kontras dengan container */
        }

        /* ===== Header ===== */
        .header {
            background-color: #4ca0afff;  /* Warna header */
            color: white;                  /* Warna teks */
            padding: 25px;                 /* Jarak dalam */
            text-align: center;            /* Rata tengah */
            font-size: 24px;               /* Ukuran font */
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        /* ===== Container ===== */
        .container {
            padding: 40px;                          /* Jarak dalam */
            max-width: 800px;                       /* Lebar maksimal */
            margin: 30px auto;
            background-color: rgba(255, 255, 255, 0.95); /* Semi-transparent putih */
            border-radius: 12px;                            /* Sudut membulat */
            box-shadow: 0 0 15px rgba(0,0,0,0.2);       /* Bayangan halus */   
        }

        /* ===== Tombol Kembali ===== */
        .btn-back {
            display: inline-block;              /* Agar bisa diatur padding dan margin */
            margin-bottom: 20px;                /* Jarak bawah */
            background-color: #d28819ff;
            color: white;                   /* Warna teks */
            text-decoration: none;          /* Hilangkan garis bawah */
            padding: 10px 15px;             /* Jarak dalam */
            border-radius: 6px;             /* Sudut membulat */
            margin-bottom: 20px;            /* Jarak bawah */
            transition: background 0.3s;    /* Transisi warna background */
        }

        .btn-back:hover {
            background-color: #b30000;      /* Warna saat hover */
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

        /* Baris ganjil agar lebih enak dibaca */
        tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        /* ===== Responsive ===== */
        @media screen and (max-width: 600px) {
            .container {
                padding: 15px;
                margin: 15px;
            }
            table, th, td {
                font-size: 12px;
            }
        }
        </style>
</head>
<body>
<div class="header">Daftar Murid</div>
<div class="container">
    <a href="dashboard_guru.php" class="btn-back">⬅ Kembali</a>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Tanggal Lahir</th>
            <th>Kelas</th>
        </tr>
        <?php
        $no = 1;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".htmlspecialchars($row['nama_lengkap'])."</td>";
                echo "<td>".htmlspecialchars($row['tanggal_lahir'])."</td>";

                // Konversi kelas_id ke A/B/C
                switch($row['kelas_id']) {
                    case '1':
                        $kelas = 'A';
                        break;
                    case '2':
                        $kelas = 'B';
                        break;
                    case '3':
                        $kelas = 'C';
                        break;
                    default:
                        $kelas = '';
                }
                echo "<td>".htmlspecialchars($kelas)."</td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Belum ada data murid</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
