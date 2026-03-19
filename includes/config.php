<?php
// Ganti dengan data dari Panel 
$host = "MySQL Hostname"; // LIHAT DI PANEL: MySQL Hostname kamu apa?
$user = "Username";           // Username database kamu
$pass = "Password";          // Password akun hosting/vpanel kamu
$db   = "Nama database";     // Nama database lengkap yang kamu buat

// Koneksi dengan pengaman error
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = mysqli_connect($host, $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// --- 2. AMBIL DATA DARI TABEL SETTING ---
// Kita ambil sekali saja agar bisa dipakai di INDEX maupun ADMIN
$querySetting = mysqli_query($conn, "SELECT * FROM setting WHERE id_setting = 1");
$set = mysqli_fetch_assoc($querySetting);

// --- 3. URL DASAR (Penting untuk Link & CSS) ---
// Jika kamu pindah domain, cukup ganti di tabel 'setting' kolom 'url_base'
$base_url = $set['url_base'] ?? "https://usahaku.top/caricariv2";

?>
