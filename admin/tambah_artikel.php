<?php
include '../includes/config.php';
include '../includes/functions.php'; // Berisi fungsi parseUrlCariCari

if (isset($_POST['simpan'])) {
    $url_input = mysqli_real_escape_string($conn, $_POST['url']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $konten = mysqli_real_escape_string($conn, $_POST['konten']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

    // 1. Bedah URL menggunakan fungsi Parser
    $dataUrl = parseUrlCariCari($url_input);

    if ($dataUrl) {
        $ext = $dataUrl['ext'];
        $host = $dataUrl['host'];
        $slug = $dataUrl['slug'];

        // --- PROSES TABEL 1: EKSTENSI ---
        // Cek apakah ekstensi sudah ada
        $cekExt = mysqli_query($conn, "SELECT id_ext FROM ekstensi WHERE nama_ext = '$ext'");
        if (mysqli_num_rows($cekExt) > 0) {
            $rowExt = mysqli_fetch_assoc($cekExt);
            $id_ext = $rowExt['id_ext'];
        } else {
            // Jika belum ada, simpan baru
            mysqli_query($conn, "INSERT INTO ekstensi (nama_ext) VALUES ('$ext')");
            $id_ext = mysqli_insert_id($conn);
        }

        // --- PROSES TABEL 2: SITUS ---
        // Cek apakah host ini sudah ada di tabel situs
        $cekSitus = mysqli_query($conn, "SELECT id_situs FROM situs WHERE host = '$host' AND id_ext = $id_ext");
        if (mysqli_num_rows($cekSitus) > 0) {
            $rowSitus = mysqli_fetch_assoc($cekSitus);
            $id_situs = $rowSitus['id_situs'];
        } else {
            // Jika belum ada, simpan baru
            mysqli_query($conn, "INSERT INTO situs (id_ext, host) VALUES ($id_ext, '$host')");
            $id_situs = mysqli_insert_id($conn);
        }

        // --- PROSES TABEL 3: ARTIKEL ---
        $querySimpan = "INSERT INTO artikel (id_situs, slug, judul, konten, kategori) 
                        VALUES ($id_situs, '$slug', '$judul', '$konten', '$kategori')";
        
        if (mysqli_query($conn, $querySimpan)) {
            echo "<script>alert('Data Berhasil Disimpan ke 3 Tabel!'); window.location='tambah_artikel.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Format URL tidak valid!');</script>";
    }
}
?>

<div style="max-width: 600px; margin: 50px auto; font-family: sans-serif;">
    <h2>🚀 Tambah Artikel (CariCari V2)</h2>
    <form action="" method="POST">
        <p>URL Lengkap:<br>
        <input type="url" name="url" placeholder="https://news.detik.com/berita-hari-ini" style="width:100%; padding:10px;" required></p>
        
        <p>Judul Artikel:<br>
        <input type="text" name="judul" style="width:100%; padding:10px;" required></p>
        
        <p>Kategori:<br>
        <input type="text" name="kategori" style="width:100%; padding:10px;"></p>
        
        <p>Konten/Ringkasan:<br>
        <textarea name="konten" rows="5" style="width:100%; padding:10px;" required></textarea></p>
        
        <button type="submit" name="simpan" style="padding:10px 20px; cursor:pointer; background: #2563eb; color:white; border:none; border-radius:5px;">
            Simpan ke Database
        </button>
    </form>
</div>
