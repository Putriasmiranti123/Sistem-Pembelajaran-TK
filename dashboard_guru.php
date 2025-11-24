<?php
session_start();

// Cek apakah user sudah login dan role = guru
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: login.php");
    exit();
}

// Ambil username dari session
$username = $_SESSION['username'] ?? 'guru';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;                      /* Hilangkan margin default */
            font-family: Arial, sans-serif; /* Font yang digunakan */
        }

        /* Header */
        .header {
            background: #4ca0afff;        /* Warna latar belakang header */
            color: white;                   /* Warna teks putih */
            padding: 20px;                  /* Jarak dalam elemen */
            text-align: center;             /* Teks rata tengah */
            font-size: 25px;                /* Ukuran font */
        }

        /* Container */
        .container {
            padding: 35px;              /* Jarak dalam elemen */
            display: flex;              /* Gunakan flexbox */
            justify-content: center;    /* Rata tengah secara horizontal */
        }

        /* Box menu */
        .card {
            background: white;                      /* Warna latar belakang putih */
            width: 500px;                           /* Lebar box */
            padding: 30px;                          /* Jarak dalam elemen */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Tombol menu */
        .btn {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            background: #70abdaff;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn:hover {
            background: #1976D2;
        }

        .logout {
            background: #d28819ff;
            margin-top: 25px;
        }

        .logout:hover {
            background: #b30000;
        }
    </style>
</head>
<body>
    <div class="header">
        Dashboard Guru
    </div>

    <div class="container">
        <div class="card">
            <h2>Halo, <?php echo htmlspecialchars($username); ?> 👋</h2>

            <a href="daftar_anak.php" class="btn">Daftar Murid</a>
            <a href="absensi.php" class="btn">Absensi</a>
            <a href="kelola_materi.php" class="btn">Upload/Hapus Materi</a>
            <a href="input_nilai.php" class="btn">Penilaian/Laporan Harian</a> 
            <a href="chat_.php" class="btn">Chat dengan Orang Tua</a>


            <a href="logout.php" class="btn logout">Logout</a>
        </div>
    </div>
</body>
</html>
