<?php
// chat.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header('Location: index.html');
    exit();
}
$guru = $_SESSION['username'];

$conn = new mysqli('localhost', 'root', '', 'login_db');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];
    $stmt = $conn->prepare('INSERT INTO chat (sender, receiver, message) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $guru, $receiver, $message);
    $stmt->execute();
    $stmt->close();
}

// Form kirim pesan
echo '<h1>Chat dengan Orangtua</h1>';
echo '<form method="POST">';
echo '<label for="receiver">Pilih Orangtua:</label>';
echo '<select name="receiver" required>';
$result = $conn->query("SELECT username FROM users WHERE role = 'orangtua'");
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['username'] . '">' . $row['username'] . '</option>';
}
echo '</select>';
echo '<label for="message">Pesan:</label>';
echo '<textarea name="message" required></textarea>';
echo '<button type="submit">Kirim</button>';
echo '</form>';

// Tampilkan pesan
$result = $conn->query("SELECT sender, receiver, message, send_date FROM chat WHERE sender = '$guru' OR receiver = '$guru' ORDER BY send_date DESC");
if ($result->num_rows > 0) {
    echo '<h2>Riwayat Chat</h2><ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li>' . $row['sender'] . ' ke ' . $row['receiver'] . ': ' . $row['message'] . ' (' . $row['send_date'] . ')</li>';
    }
    echo '</ul>';
}
$conn->close();
echo '<br><a href="dashboard_guru.php">Kembali</a>';
?>