# 🔍 CariCari V2 - Search Engine & Indexer

Mesin pencari lokal yang cerdas dengan sistem manajemen basis data relasional (3-Layer) dan fitur pengindeksan otomatis berbasis cURL.

---

## 🌟 Fitur Unggulan

### 1. Sistem Database Relasional (3 Tabel)
Struktur database dioptimalkan untuk performa tinggi dan efisiensi ruang:
- **Tabel `ekstensi`**: Mengelola TLD unik (.com, .id, .net, dll).
- **Tabel `situs`**: Mengelola domain utama (host) tanpa duplikasi.
- **Tabel `artikel`**: Menyimpan konten, slug, judul, dan deskripsi.

### 2. Auto-Indexer (Smart Scraping)
- **cURL Engine**: Mengambil data secara *remote* dari URL luar meskipun situs tujuan memiliki proteksi SSL.
- **Multilayer Meta-Tags**: Robot secara otomatis mencari informasi di:
    - `<title>` (Judul Halaman)
    - `<meta name="description">` (Deskripsi SEO)
    - `og:description` (Open Graph/Facebook)
    - `twitter:description` (Twitter Card)

### 3. User Submission (Submit URL)
- Fitur bagi publik (Blogger/Pemilik Web) untuk mendaftarkan link mereka secara mandiri.
- **Preview & Edit**: Pengguna dapat melihat hasil scraping dan mengedit Judul serta Deskripsi secara manual sebelum disimpan.

### 4. Pencarian Pintar (Full-Text Search)
Menggunakan teknologi `MATCH...AGAINST` pada database MySQL untuk hasil pencarian yang lebih relevan dan fleksibel dibandingkan `LIKE` standar.

---

## 🗂️ Struktur Proyek

- `/admin/` : Folder manajemen (Tambah Artikel, Setting, Statistik).
- `/includes/` : Berisi `config.php` (koneksi) dan `functions.php` (logika global).
- `/assets/` : Folder untuk logo, favicon, dan gambar pendukung lainnya.
- `index.php` : Halaman depan pencarian user.
- `submit.php` : Halaman pendaftaran URL publik.
- `proses_submit.php` : Logika pemrosesan scraping dan database.

---

## 🚀 Log Pengerjaan Utama

1. **V1.0**: Inisialisasi 3 tabel dan fungsi pemecah URL (`parseUrlCariCari`).
2. **V1.5**: Implementasi Full-Text Search untuk pencarian multi-kata.
3. **V2.0**: Penambahan fitur `submit.php` publik dengan sistem cURL.
4. **V2.1**: Implementasi edit deskripsi manual oleh user saat submit.
5. **V2.2**: Penambahan Dashboard Statistik dan Pengaturan Website dinamis.

---

## 🛠️ Cara Instalasi

1. Pastikan server PHP memiliki modul **cURL** yang aktif.
2. Buat database MySQL dan impor tabel `artikel`, `situs`, dan `ekstensi`.
3. Masukkan data awal ke tabel `setting` (ID 1).
4. Sesuaikan kredensial database di `includes/config.php`.

---
*Dikembangkan oleh Admin Sobandi - 2026*
