<?php
// upload_materi.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header('Location: index.html');
    exit();
}
$guru = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $file = $_FILES['file'];
    
    // Validasi file
    $allowed_types = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed_types) || $file['size'] > 5000000) { // Max 5MB
        echo 'File tidak valid atau terlalu besar!';
        exit();
    }
    
    // Upload file
    $target_dir = 'uploads/';
    $target_file = $target_dir . basename($file['name']);
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Simpan ke database
        $conn = new mysqli('localhost', 'root', '', 'login_db');
        $stmt = $conn->prepare('INSERT INTO materi (title, file_path, uploaded_by) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $title, $target_file, $guru);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header('Location: dashboard_guru.php');
    } else {
        echo 'Upload gagal!';
    }
}
?>