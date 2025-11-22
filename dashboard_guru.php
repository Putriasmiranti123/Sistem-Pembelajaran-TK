<?php
// dashboard_guru.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header('Location: index.html');
    exit();
}
$guru = $_SESSION['username'];
echo '<h1>Beranda Guru</h1>';
echo 'Selamat datang Guru, ' . $guru . '!';
echo '<br><a href="logout.php">Logout</a>';

// Form upload materi
echo '<div class="upload-form">';
echo '<h2>Upload Materi Pembelajaran</h2>';
echo '<form action="upload_materi.php" method="POST" enctype="multipart/form-data">';
echo '<label for="title">Judul Materi:</label>';
echo '<input type="text" name="title" required>';
echo '<label for="file">Pilih File:</label>';
echo '<input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" required>';
echo '<button type="submit">Upload</button>';
echo '</form>';
echo '</div>';

// Daftar materi dengan opsi hapus
$conn = new mysqli('localhost', 'root', '', 'login_db');
$result = $conn->query("SELECT id, title, file_path, upload_date FROM materi WHERE uploaded_by = '$guru' ORDER BY upload_date DESC");
if ($result->num_rows > 0) {
    echo '<h2>Daftar Materi Anda</h2><ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li><a href="' . $row['file_path'] . '">' . $row['title'] . '</a> - ' . $row['upload_date'] . ' <a href="delete_materi.php?id=' . $row['id'] . '">Hapus</a></li>';
    }
    echo '</ul>';
}

// Link ke fitur lain
echo '<h2>Fitur Lain</h2>';
echo '<ul>';
echo '<li><a href="chat.php">Chat dengan Orangtua</a></li>';
echo '<li><a href="penilaian.php">Penilaian/Laporan Harian</a></li>';
echo '<li><a href="presensi.php">Presensi Siswa</a></li>';
echo '</ul>';

$conn->close();
?>