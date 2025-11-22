<?php
    // Definisikan variabel PHP
    $school_name = "Ceria Nusantara";
    $page_title = "Beranda";
    $menu_items = [
        "Beranda" => "index.php",
        "Testimoni" => "testimoni.php",
    ];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TK <?php echo $school_name; ?> - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="logo">
            <span class="tk-prefix">TK</span> 
            <span class="school-name"><?php echo $school_name; ?></span>
        </div>
        <nav>
            <ul>
                <?php foreach ($menu_items as $text => $url): ?>
                    <li>
                        <a 
                           href="<?php echo $url; ?>" 
                           class="<?php echo ($text == $page_title) ? 'active' : ''; ?>">
                           <?php echo $text; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li><button class="login-button">Masuk</button></li>
            </ul>
        </nav>
    </header>

    <main class="content-area">