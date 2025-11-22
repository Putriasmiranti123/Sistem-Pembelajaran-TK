<?php
// dashboard_orangtua.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'orangtua') {
    header('Location: index.html');
    exit();
}
$orangtua = $_SESSION['username'];
echo '<h1>Beranda Orangtua</h1>';
echo 'Selamat datang Orangtua, ' . $orangtua . '!';
echo '<br><a href="logout.php">Logout</a>';

$conn = new mysqli('localhost', 'root', '', 'login_db');

// Form komunikasi 2 arah (chat balik ke guru)
echo '<h2>Komunikasi dengan Guru</h2>';
echo '<form method="POST" action="chat_orangtua.php">';
echo '<label for="receiver">Pilih Guru:</label>';
echo '<select name="receiver" required>';
$result = $conn->query("SELECT username FROM users WHERE role = 'guru'");
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['username'] . '">' . $row['username'] . '</option>';
}
echo '</select>';
echo '<label for="message">Pesan:</label>';
echo '<textarea name="message" required></textarea>';
echo '<button type="submit">Kirim Pesan</button>';
echo '</form>';

// Tampilkan riwayat chat
$result = $conn->query("SELECT sender, receiver, message, send_date FROM chat WHERE sender = '$orangtua' OR receiver = '$orangtua' ORDER BY send_date DESC");
if ($result->num_rows > 0) {
    echo '<h3>Riwayat Pesan</h3><ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li>' . $row['sender'] . ' ke ' . $row['receiver'] . ': ' . $row['message'] . ' (' . $row['send_date'] . ')</li>';
    }
    echo '</ul>';
}

// Melihat hasil penilaian anak (asumsi nama anak berdasarkan input, atau filter manual; untuk sederhana, tampilkan berdasarkan nama siswa yang dimasukkan)
echo '<h2>Hasil Penilaian Anak</h2>';
echo '<form method="GET">';
echo '<label for="anak">Nama Anak:</label>';
echo '<input type="text" name="anak" required>';
echo '<button type="submit">Cari</button>';
echo '</form>';
$anak = isset($_GET['anak']) ? $_GET['anak'] : '';
if ($anak) {
    $stmt = $conn->prepare('SELECT mata_pelajaran, nilai, laporan, tanggal FROM penilaian WHERE siswa = ? ORDER BY tanggal DESC');
    $stmt->bind_param('s', $anak);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<ul>';
        while ($row = $result->fetch_assoc()) {
            echo '<li>' . $row['mata_pelajaran'] . ' - Nilai: ' . $row['nilai'] . ' - Laporan: ' . $row['laporan'] . ' (' . $row['tanggal'] . ')</li>';
        }
        echo '</ul>';
    } else {
        echo 'Tidak ada data penilaian untuk anak tersebut.';
    }
    $stmt->close();
}

// Melihat materi yang diupload oleh guru
$result = $conn->query('SELECT title, file_path, upload_date, uploaded_by FROM materi ORDER BY upload_date DESC');
if ($result->num_rows > 0) {
    echo '<h2>Materi Pembelajaran dari Guru</h2><ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li><a href="' . $row['file_path'] . '">' . $row['title'] . '</a> - Diupload oleh: ' . $row['uploaded_by'] . ' (' . $row['upload_date'] . ')</li>';
    }
    echo '</ul>';
}

$conn->close();
?>