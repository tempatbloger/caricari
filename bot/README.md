# 🤖 CariCariBot V2 - High-Speed JSON Crawler

CariCariBot V2 adalah mesin perayap web (web crawler) modular yang dirancang untuk kecepatan dan efisiensi. Bot ini menggunakan pendekatan **Hybrid Storage**: menggunakan **JSON** untuk antrean (queue) dan hasil sementara (staging), serta **MySQL** untuk penyimpanan data permanen yang terindeks.

## 🚀 Fitur Utama
- **Modular Architecture**: Kode dipisah menjadi modul-modul kecil (Parser, Extractor, File Manager) agar mudah dimodifikasi.
- **JSON-Based Queue**: Proses crawling sangat cepat karena tidak terhambat oleh koneksi database berulang.
- **Auto-Discovery**: Bot secara otomatis mencari link baru di setiap halaman yang dikunjungi dan menambahkannya ke antrean.
- **Resume-able**: Bot dapat dihentikan dan dilanjutkan kapan saja tanpa kehilangan jejak antrean.
- **Multi-Queue Management**: Mendukung banyak file antrean sekaligus (misal: berita.json, teknologi.json).
- **Relational Export**: Fitur sekali klik untuk memindahkan hasil dari JSON ke database MySQL 3-layer (Ekstensi -> Situs -> Artikel).

## 📂 Struktur Folder
```text
/bot/
├── config_bot.php      # Koneksi DB & Fungsi cURL
├── file_manager.php    # Logika Read/Write JSON
├── parser_url.php      # Pembersihan domain & pemecah URL
├── extractor.php       # Pengambil meta title & description
├── link_finder.php     # Pencari link otomatis (Deep Crawl)
├── mass_crawl.php      # Eksekutor utama bot
├── import_to_db.php    # Importir JSON ke SQL
└── index.php           # Dashboard Control Center (UI)
