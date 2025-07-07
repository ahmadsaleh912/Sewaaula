CREATE DATABASE IF NOT EXISTS penyewaan_aula;
USE penyewaan_aula;

-- Tabel Penyewa
CREATE TABLE penyewa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  nim VARCHAR(20),
  fakultas VARCHAR(100),
  prodi VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Admin
CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255)
);

-- Tabel Penyewaan
CREATE TABLE penyewaan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_penyewa INT,
  nama_kegiatan VARCHAR(150),
  tanggal_pakai DATE,
  kapasitas INT,
  status ENUM('pending','disetujui','ditolak','batal','diajukan_batal') DEFAULT 'pending',
  alasan_ditolak TEXT,
  alasan_batal TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_penyewa) REFERENCES penyewa(id) ON DELETE CASCADE
);

-- Tabel Riwayat (opsional tapi sangat berguna)
CREATE TABLE log_riwayat (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_penyewa INT,
  id_penyewaan INT,
  aksi VARCHAR(100),
  waktu DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_penyewa) REFERENCES penyewa(id) ON DELETE CASCADE,
  FOREIGN KEY (id_penyewaan) REFERENCES penyewaan(id) ON DELETE CASCADE
);
