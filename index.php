<?php
include 'includes/config.php';

// Ambil kata kunci jika ada
$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <?php if(!empty($set['favicon_path'])): ?>
        <link rel="icon" type="image/x-icon" href="assets/img/<?= $set['favicon_path'] ?>">
    <?php endif; ?>
    <title><?= $set['nama_website']; ?> - <?= $set['slogan']; ?></title>
    <style>
        :root { --primary: #2563eb; --text: #1f2937; }
        body { font-family: sans-serif; color: var(--text); line-height: 1.6; margin: 0; padding: 20px; }
        .search-container { max-width: 700px; margin: 50px auto; text-align: center; }
        input[type="text"] { width: 80%; padding: 12px; border: 1px solid #ddd; border-radius: 25px; outline: none; }
        button { padding: 12px 25px; border-radius: 25px; border: none; background: var(--primary); color: white; cursor: pointer; }
        .result-item { margin-bottom: 30px; max-width: 700px; margin-left: auto; margin-right: auto; display: flex; gap: 15px; align-items: flex-start; }
        .result-url { color: #059669; font-size: 14px; margin-bottom: 2px; display: block; text-decoration: none; }
        .result-title { color: var(--primary); font-size: 19px; text-decoration: none; font-weight: bold; }
        .result-title:hover { text-decoration: underline; }
        .result-desc { color: #4b5563; font-size: 14px; margin-top: 5px; }
        .badge { background: #f3f4f6; padding: 2px 8px; border-radius: 10px; font-size: 11px; color: #6b7280; }
        .favicon-img { width: 24px; height: 24px; margin-top: 5px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="search-container">
    <?php if(!empty($set['logo_path'])): ?>
        <img src="assets/img/<?= $set['logo_path'] ?>" style="max-width: 200px; margin-bottom: 10px;">
    <?php else: ?>
        <h1 style="font-size: 40px; margin-bottom: 10px;">🔍 <?= $set['nama_website'] ?></h1>
    <?php endif; ?>
    
    <p style="color: #64748b; margin-top: -10px; margin-bottom: 20px;"><?= $set['slogan'] ?></p>

    <form action="" method="GET">
        <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari apa saja di Indonesia..." required>
        <button type="submit">Cari</button>
    </form>
</div>

<?php
if ($q != "") {
    $sql = "SELECT a.*, s.host, e.nama_ext 
            FROM artikel a
            JOIN situs s ON a.id_situs = s.id_situs
            JOIN ekstensi e ON s.id_ext = e.id_ext
            WHERE MATCH(a.judul, a.konten) AGAINST('$q' IN NATURAL LANGUAGE MODE)
            ORDER BY a.id_artikel DESC";
            
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    echo "<div style='max-width:700px; margin:0 auto; margin-bottom:20px; color:#999;'>Ditemukan $count hasil untuk <b>".htmlspecialchars($q)."</b></div>";

    while ($row = mysqli_fetch_assoc($query)) {
        $url_utuh = "https://" . $row['host'] . $row['nama_ext'] . $row['slug'];
        $domain_favicon = $row['host'] . $row['nama_ext'];
        ?>
        
        <div class="result-item">
            <img src="https://www.google.com/s2/favicons?domain=<?= $domain_favicon ?>&sz=32" class="favicon-img" alt="icon">
            
            <div>
                <a href="<?= $url_utuh ?>" class="result-url" target="_blank">
                    <?= $domain_favicon ?> <span class="badge"><?= $row['kategori'] ?></span>
                </a>
                <a href="<?= $url_utuh ?>" class="result-title" target="_blank">
                    <?= htmlspecialchars($row['judul']) ?>
                </a>
                <div class="result-desc">
                    <?= htmlspecialchars(substr($row['konten'], 0, 180)) ?>...
                </div>
            </div>
        </div>

        <?php
    } // Penutup While

    if ($count == 0) {
        echo "<p style='text-align:center;'>Maaf, tidak ada hasil yang ditemukan.</p>";
    }
}
?>

<footer style="text-align: center; margin-top: 50px; padding: 20px; color: #94a3b8; border-top: 1px solid #eee;">
    <?= $set['footer_text'] ?> - kontak: <?= $set['email_kontak'] ?>
</footer>

</body>
</html>
