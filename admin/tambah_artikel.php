<?php
include '../includes/config.php';
include '../includes/functions.php';

$pesan = "";

if (isset($_POST['simpan'])) {
    $url_input = trim($_POST['url']);
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $konten    = mysqli_real_escape_string($conn, $_POST['konten']);
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);

    // Gunakan fungsi Parser dari functions.php
    $dataUrl = parseUrlCariCari($url_input);

    if ($dataUrl) {
        $ext  = mysqli_real_escape_string($conn, $dataUrl['ext']);
        $host = mysqli_real_escape_string($conn, $dataUrl['host']);
        $slug = mysqli_real_escape_string($conn, $dataUrl['slug']);

        // --- PROSES TABEL 1: EKSTENSI ---
        $cekExt = mysqli_query($conn, "SELECT id_ext FROM ekstensi WHERE nama_ext = '$ext'");
        if (mysqli_num_rows($cekExt) > 0) {
            $id_ext = mysqli_fetch_assoc($cekExt)['id_ext'];
        } else {
            mysqli_query($conn, "INSERT INTO ekstensi (nama_ext) VALUES ('$ext')");
            $id_ext = mysqli_insert_id($conn);
        }

        // --- PROSES TABEL 2: SITUS ---
        $cekSitus = mysqli_query($conn, "SELECT id_situs FROM situs WHERE host = '$host' AND id_ext = $id_ext");
        if (mysqli_num_rows($cekSitus) > 0) {
            $id_situs = mysqli_fetch_assoc($cekSitus)['id_situs'];
        } else {
            mysqli_query($conn, "INSERT INTO situs (id_ext, host) VALUES ($id_ext, '$host')");
            $id_situs = mysqli_insert_id($conn);
        }

        // --- PROSES TABEL 3: ARTIKEL ---
        $querySimpan = "INSERT INTO artikel (id_situs, slug, judul, konten, kategori) 
                        VALUES ($id_situs, '$slug', '$judul', '$konten', '$kategori')";
        
        if (mysqli_query($conn, $querySimpan)) {
            $pesan = "<div class='alert success'>✅ Berhasil! Data tersimpan di 3 tabel relasi.</div>";
        } else {
            $pesan = "<div class='alert error'>❌ Gagal: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $pesan = "<div class='alert error'>⚠️ Format URL tidak valid atau tidak lengkap!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data - CariCari V2 Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; }
        .form-container { max-width: 700px; margin: 30px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { margin-top: 0; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
        label { display: block; margin-top: 15px; margin-bottom: 5px; font-weight: 600; color: #475569; }
        input[type="text"], input[type="url"], textarea {
            width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px;
        }
        textarea { resize: vertical; }
        .btn-submit { 
            background: #2563eb; color: white; border: none; padding: 12px 25px; border-radius: 8px; 
            cursor: pointer; font-weight: bold; width: 100%; margin-top: 25px; transition: 0.3s;
        }
        .btn-submit:hover { background: #1d4ed8; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <div class="form-container">
        <h2>➕ Indeks Artikel Baru</h2>
        
        <?= $pesan ?>

        <form action="" method="POST">
            <label>URL Lengkap</label>
            <input type="url" name="url" placeholder="https://news.detik.com/berita-hari-ini" required>
            
            <label>Judul Halaman</label>
            <input type="text" name="judul" placeholder="Masukkan judul artikel..." required>
            
            <label>Kategori</label>
            <input type="text" name="kategori" placeholder="Contoh: Teknologi, Ekonomi, Kesehatan...">
            
            <label>Konten / Ringkasan</label>
            <textarea name="konten" rows="6" placeholder="Masukkan ringkasan konten untuk hasil pencarian..." required></textarea>
            
            <button type="submit" name="simpan" class="btn-submit">🚀 Simpan ke Database</button>
        </form>
<label>URL Lengkap</label>
<input type="url" name="url" id="url_input" placeholder="https://news.detik.com/berita-hari-ini" required autocomplete="off">
<div id="url_preview" style="margin-top: 5px; font-size: 12px; min-height: 18px; color: #64748b;">
    Masukkan URL untuk cek status domain...
</div>

<script>
    const urlInput = document.getElementById('url_input');
    const urlPreview = document.getElementById('url_preview');

    urlInput.addEventListener('blur', function() {
        const urlValue = this.value;
        if (urlValue.length > 5) {
            urlPreview.innerHTML = "⏳ Mengecek...";
            
            // Gunakan Fetch API untuk cek ke server
            fetch('cek_domain.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'url=' + encodeURIComponent(urlValue)
            })
            .then(response => response.text())
            .then(data => {
                urlPreview.innerHTML = data;
            })
            .catch(error => {
                urlPreview.innerHTML = "❌ Gagal mengecek.";
            });
        }
    });
</script>
    </div>

</div>

</body>

</html>
