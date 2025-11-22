<?php
// presensi.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header('Location: index.html');
    exit();
}
$guru = $_SESSION['username'];

$conn = new mysqli('localhost', 'root', '', 'login_db');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $siswa = $_POST['siswa'];
    $status = $_POST['status'];
    $tanggal = date('Y-m-d');
    $stmt = $conn->prepare('INSERT INTO presensi (siswa, tanggal, status, guru) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $siswa, $tanggal, $status, $guru);
    $stmt->execute();
    $stmt->close();
}

// Form input presensi
echo '<h1>Presensi Siswa</h1>';
echo '<form method="POST">';
echo '<label for="siswa">Nama Siswa:</label>';
echo '<input type="text" name="siswa" required>';
echo '<label for="status">Status:</label>';
echo '<select name="status" required>';
echo '<option value="hadir">Hadir</option>';
echo '<option value="tidak hadir">Tidak Hadir</option>';
echo '<option value="izin">Izin</option>';
echo '</select>';
echo '<button type="submit">Simpan</button>';
echo '</form>';

// Tampilkan daftar presensi
$result = $conn->query("SELECT siswa, tanggal, status FROM presensi WHERE guru = '$guru' ORDER BY tanggal DESC");
if ($result->num_rows > 0) {
    echo '<h2>Daftar Presensi</h2><ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li>' . $row['siswa'] . ' - ' . $row['status'] . ' (' . $row['tanggal'] . ')</li>';
    }
    echo '</ul>';
}
$conn->close();
echo '<br><a href="dashboard_guru.php">Kembali</a>';
?>