<?php
// penilaian.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header('Location: index.html');
    exit();
}
$guru = $_SESSION['username'];

$conn = new mysqli('localhost', 'root', '', 'login_db');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $siswa = $_POST['siswa'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $nilai = $_POST['nilai'];
    $laporan = $_POST['laporan'];
    $tanggal = date('Y-m-d');
    $stmt = $conn->prepare('INSERT INTO penilaian (siswa, mata_pelajaran, nilai, laporan, tanggal, guru) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssisss', $siswa, $mata_pelajaran, $nilai, $laporan, $tanggal, $guru);
    $stmt->execute();
    $stmt->close();
}

// Form input penilaian
echo '<h1>Penilaian/Laporan Harian</h1>';
echo '<form method="POST">';
echo '<label for="siswa">Nama Siswa:</label>';
echo '<input type="text" name="siswa" required>';
echo '<label for="mata_pelajaran">Mata Pelajaran:</label>';
echo '<input type="text" name="mata_pelajaran" required>';
echo '<label for="nilai">Nilai:</label>';
echo '<input type="number" name="nilai" min="0" max="100" required>';
echo '<label for="laporan">Laporan Harian:</label>';
echo '<textarea name="laporan" required></textarea>';
echo '<button type="submit">Simpan</button>';
echo '</form>';

// Tampilkan daftar penilaian
$result = $conn->query("SELECT siswa, mata_pelajaran, nilai, laporan, tanggal FROM penilaian WHERE guru = '$guru' ORDER BY tanggal DESC");
if ($result->num_rows > 0) {
    echo '<h2>Daftar Penilaian</h2><ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li>' . $row['siswa'] . ' - ' . $row['mata_pelajaran'] . ' - Nilai: ' . $row['nilai'] . ' - Laporan: ' . $row['laporan'] . ' (' . $row['tanggal'] . ')</li>';
    }
    echo '</ul>';
}
$conn->close();
echo '<br><a href="dashboard_guru.php">Kembali</a>';
?>