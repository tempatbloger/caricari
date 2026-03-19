function parseUrlCariCari($url) {
    // 1. Bersihkan URL dari spasi
    $url = trim($url);
    
    // 2. Gunakan fungsi bawaan PHP untuk memecah komponen dasar
    $parse = parse_url($url);
    
    // Ambil host (contoh: news.detik.com)
    $fullHost = isset($parse['host']) ? $parse['host'] : '';
    
    // Ambil path/slug (contoh: /berita/hari-ini)
    $slug = isset($parse['path']) ? $parse['path'] : '/';
    if(isset($parse['query'])) $slug .= '?' . $parse['query'];

    if ($fullHost != '') {
        // 3. Pisahkan Host dan Ekstensi (Logika: ambil titik terakhir)
        $posisiTitikTerakhir = strrpos($fullHost, '.');
        
        // Cek jika ini domain tingkat dua seperti .co.id atau .ac.id
        // Kita buat logika sederhana dulu, jika ada ".id" di akhir dan ada titik lain sebelumnya
        if (preg_match('/\.(com|co|ac|go|or|net|my)\.id$/i', $fullHost)) {
            // Potong dari titik kedua dari belakang (untuk .co.id)
            $parts = explode('.', $fullHost);
            $ext = '.' . $parts[count($parts)-2] . '.' . $parts[count($parts)-1];
            $hostOnly = str_replace($ext, '', $fullHost);
        } else {
            // Domain standar seperti .com, .net, .id
            $ext = substr($fullHost, $posisiTitikTerakhir);
            $hostOnly = substr($fullHost, 0, $posisiTitikTerakhir);
        }

        return [
            'host' => $hostOnly, // Hasil: news.detik
            'ext'  => $ext,      // Hasil: .com
            'slug' => $slug      // Hasil: /berita/hari-ini
        ];
    }
    
    return false;
}
