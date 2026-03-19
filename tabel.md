-- 1. Tabel Ekstensi (Contoh: .com, .id)
CREATE TABLE ekstensi (
    id_ext INT AUTO_INCREMENT PRIMARY KEY,
    nama_ext VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- 2. Tabel Situs (Contoh: news.detik, www.google)
CREATE TABLE situs (
    id_situs INT AUTO_INCREMENT PRIMARY KEY,
    id_ext INT NOT NULL,
    host VARCHAR(255) NOT NULL,
    nama_brand VARCHAR(100),
    favicon VARCHAR(255),
    FOREIGN KEY (id_ext) REFERENCES ekstensi(id_ext) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. Tabel Artikel (Data Utama)
CREATE TABLE artikel (
    id_artikel BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_situs INT NOT NULL,
    slug TEXT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    konten TEXT NOT NULL,
    kategori VARCHAR(50),
    tanggal_indeks TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FULLTEXT(judul, konten),
    FOREIGN KEY (id_situs) REFERENCES situs(id_situs) ON DELETE CASCADE
) ENGINE=InnoDB;
