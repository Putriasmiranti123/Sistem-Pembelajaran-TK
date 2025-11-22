<?php
// delete_materi.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header('Location: index.html');
    exit();
}
$guru = $_SESSION['username'];
$id = $_GET['id'];

$conn = new mysqli('localhost', 'root', '', 'login_db');
$stmt = $conn->prepare('SELECT file_path FROM materi WHERE id = ? AND uploaded_by = ?');
$stmt->bind_param('is', $id, $guru);
$stmt->execute();
$stmt->bind_result($file_path);
if ($stmt->fetch()) {
    unlink($file_path); // Hapus file fisik
    $stmt->close();
    $stmt = $conn->prepare('DELETE FROM materi WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
$stmt->close();
$conn->close();
header('Location: dashboard_guru.php');
?>