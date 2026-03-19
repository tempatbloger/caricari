<?php
include '../includes/config.php';
include '../includes/functions.php';

if (isset($_POST['url'])) {
    $dataUrl = parseUrlCariCari($_POST['url']);
    if ($dataUrl) {
        $host = mysqli_real_escape_string($conn, $dataUrl['host']);
        $ext = mysqli_real_escape_string($conn, $dataUrl['ext']);

        // Cek apakah kombinasi host + ext sudah ada di tabel situs
        $sql = "SELECT s.nama_brand FROM situs s 
                JOIN ekstensi e ON s.id_ext = e.id_ext 
                WHERE s.host = '$host' AND e.nama_ext = '$ext'";
        
        $query = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            echo "✅ Domain dikenal: <b>" . ($data['nama_brand'] ?: $host.$ext) . "</b> (Sudah ada di database)";
        } else {
            echo "🆕 Domain baru: <b>" . $host . $ext . "</b> (Akan ditambahkan otomatis)";
        }
    } else {
        echo "❌ Format URL tidak valid.";
    }
}
