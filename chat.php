<?php
session_start();
if(!isset($_SESSION['id_user'])){
    header("Location: dashboard_guru.php");
    exit();
}

include 'koneksi.php';

$id_user = $_SESSION['id_user'];
$role    = $_SESSION['role'];
$id_murid_user = $_SESSION['id_murid'] ?? null;

// Kirim pesan
if(isset($_POST['kirim'])){
    $pesan = trim($_POST['pesan']);
    $id_murid = $_POST['id_murid'] ?? null;

    if($pesan != ''){
        if($role === 'guru' && $id_murid){
            $stmt = $conn->prepare("INSERT INTO chat (pengirim,id_user,id_murid,pesan) VALUES ('guru',?,?,?)");
            $stmt->bind_param("iis",$id_user,$id_murid,$pesan);
        } else if($role === 'orangtua'){
            // id_murid milik ortu sendiri
            $stmt = $conn->prepare("INSERT INTO chat (pengirim,id_user,id_murid,pesan) VALUES ('orangtua',?,?,?)");
            $stmt->bind_param("iis",$id_user,$id_murid_user,$pesan);
        }
        $stmt->execute();
        $stmt->close();
    }
}

// Ambil daftar murid untuk guru
if($role === 'guru'){
    $murid_list = $conn->query("SELECT id_murid,nama_lengkap FROM murid ORDER BY nama_lengkap ASC");
}

// Ambil chat
if($role === 'guru'){
    $chat_result = $conn->query("SELECT c.*, m.nama_lengkap FROM chat c JOIN murid m ON c.id_murid=m.id_murid ORDER BY c.tanggal_kirim ASC");
} else {
    $chat_result = $conn->query("SELECT c.*, u.username FROM chat c JOIN users u ON c.id_user=u.id WHERE c.id_murid=$id_murid_user ORDER BY c.tanggal_kirim ASC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Chat</title>
<style>
body{font-family:Arial,sans-serif;margin:0;background:#f5f5f5;}
.container{padding:30px;max-width:900px;margin:auto;background-color: rgba(255,255,255,0.95);border-radius:10px;}
textarea, select{width:100%;padding:10px;margin:8px 0;border-radius:6px;border:1px solid #ccc;}
button{padding:10px 15px;background:#70abdaff;color:white;border:none;border-radius:6px;cursor:pointer;}
button:hover{background:#1976D2;}
.chat-box{max-height:400px;overflow-y:auto;border:1px solid #ccc;padding:10px;border-radius:6px;background:#f9f9f9;margin-bottom:20px;}
.chat-msg{margin-bottom:10px;padding:8px;border-radius:6px;}
.chat-msg.guru{background:#d0e7ff;text-align:left;}
.chat-msg.ortu{background:#d0ffd0;text-align:right;}
</style>
</head>
<body>
<div class="container">
<h2>Chat <?php echo ucfirst($role); ?></h2>

<div class="chat-box">
<?php while($c = $chat_result->fetch_assoc()): ?>
    <div class="chat-msg <?php echo $c['pengirim']; ?>">
        <strong>
        <?php 
        if($role==='guru') echo $c['nama_lengkap'].' ('.ucfirst($c['pengirim']).')';
        else echo $c['username'].' ('.ucfirst($c['pengirim']).')';
        ?>:
        </strong>
        <?php echo htmlspecialchars($c['pesan']); ?>
        <br><small><?php echo $c['tanggal_kirim']; ?></small>
    </div>
<?php endwhile; ?>
</div>

<form method="POST">
<?php if($role==='guru'): ?>
    <select name="id_murid" required>
        <option value="">-- Pilih Murid --</option>
        <?php while($m=$murid_list->fetch_assoc()): ?>
            <option value="<?php echo $m['id_murid']; ?>"><?php echo htmlspecialchars($m['nama_lengkap']); ?></option>
        <?php endwhile; ?>
    </select>
<?php endif; ?>
<textarea name="pesan" placeholder="Ketik pesan..." required></textarea>
<button type="submit" name="kirim">Kirim Pesan</button>
</form>
</div>
</body>
</html>
