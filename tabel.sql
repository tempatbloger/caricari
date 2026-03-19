-- 1. Tabel Ekstensi (Menyimpan TLD seperti .com, .id)
CREATE TABLE `ekstensi` (
  `id_ext` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ext` varchar(20) NOT NULL,
  PRIMARY KEY (`id_ext`),
  UNIQUE KEY `nama_ext` (`nama_ext`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel Situs (Menyimpan Domain Utama)
CREATE TABLE `situs` (
  `id_situs` int(11) NOT NULL AUTO_INCREMENT,
  `id_ext` int(11) NOT NULL,
  `host` varchar(255) NOT NULL,
  `nama_brand` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_situs`),
  KEY `id_ext` (`id_ext`),
  CONSTRAINT `situs_ibfk_1` FOREIGN KEY (`id_ext`) REFERENCES `ekstensi` (`id_ext`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel Artikel (Menyimpan Konten/Halaman)
CREATE TABLE `artikel` (
  `id_artikel` int(11) NOT NULL AUTO_INCREMENT,
  `id_situs` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text DEFAULT NULL,
  `kategori` varchar(50) DEFAULT 'Umum',
  `tgl_input` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_artikel`),
  FULLTEXT KEY `pencarian` (`judul`, `konten`),
  KEY `id_situs` (`id_situs`),
  CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`id_situs`) REFERENCES `situs` (`id_situs`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel Setting (Pengaturan Website)
CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_website` varchar(100) DEFAULT 'CariCari V2',
  `logo` varchar(255) DEFAULT 'logo.png',
  `favicon` varchar(255) DEFAULT 'favicon.ico',
  `deskripsi_web` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Awal untuk Tabel Setting
INSERT INTO `setting` (`id`, `nama_website`, `logo`, `favicon`, `deskripsi_web`) 
VALUES (1, 'CariCari V2', 'logo.png', 'favicon.ico', 'Mesin Pencari Blogger Indonesia');
