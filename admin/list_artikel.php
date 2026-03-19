<?php
include '../includes/config.php';
include 'header.php';

// Logika Hapus Artikel (Jika tombol hapus diklik)
if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM artikel WHERE id_artikel = '$id_hapus'");
    header("Location: list_artikel.php?pesan=terhapus");
}

// Query JOIN 3 Tabel untuk menampilkan data lengkap
$sql = "SELECT a.id_artikel, a.judul, a.kategori, a.slug, s.host, e.nama_ext 
        FROM artikel a
        JOIN situs s ON a.id_situs = s.id_situs
        JOIN ekstensi e ON s.id_ext = e.id_ext
        ORDER BY a.id_artikel DESC";

$query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Artikel - CariCari V2</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 1100px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #2563eb; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
        th { background: #f8fafc; color: #64748b; text-transform: uppercase; font-size: 12px; }
        .url-text { color: #10b981; font-family: monospace; font-size: 12px; }
        .badge { padding: 4px 8px; border-radius: 5px; font-size: 11px; background: #dbeafe; color: #1e40af; }
        .btn-hapus { color: #ef4444; text-decoration: none; font-weight: bold; margin-left: 10px; }
        .btn-hapus:hover { text-decoration: underline; }
        .nav-link { text-decoration: none; color: #2563eb; font-weight: bold; margin-bottom: 20px; display: inline-block; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="nav-link">← Kembali ke Dashboard</a>
    <h2>📰 Semua Artikel Terindeks</h2>

    <?php if(isset($_GET['pesan'])) echo "<p style='color:green;'>Data berhasil dihapus!</p>"; ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Artikel</th>
                <th>URL Asli</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($query)): 
                // Menggabungkan kembali komponen URL
                $link_lengkap = "https://" . $row['host'] . $row['nama_ext'] . $row['slug'];
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <div style="font-weight:bold; color:#1e293b;"><?= htmlspecialchars($row['judul']) ?></div>
                </td>
                <td>
                    <span class="url-text"><?= $row['host'] . $row['nama_ext'] . $row['slug'] ?></span>
                </td>
                <td><span class="badge"><?= htmlspecialchars($row['kategori']) ?></span></td>
                <td>
                    <a href="<?= $link_lengkap ?>" target="_blank" style="color:#2563eb; text-decoration:none;">Buka</a>
                    <a href="list_artikel.php?hapus=<?= $row['id_artikel'] ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php if(mysqli_num_rows($query) == 0): ?>
        <p style="text-align:center; color:#999; padding:20px;">Belum ada artikel yang masuk.</p>
    <?php endif; ?>
</div>

</body>
</html>
