-- setup.sql (update)
CREATE DATABASE login_db;
USE login_db;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    role ENUM('guru', 'orangtua') NOT NULL
);
CREATE TABLE siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50),
    orangtua VARCHAR(50), -- Username orangtua
    kelas VARCHAR(20)
);
CREATE TABLE materi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    file_path VARCHAR(255),
    uploaded_by VARCHAR(50),
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender VARCHAR(50),
    receiver VARCHAR(50),
    message TEXT,
    send_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE penilaian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT,
    mata_pelajaran VARCHAR(50),
    nilai INT,
    laporan TEXT,
    tanggal DATE,
    guru VARCHAR(50),
    FOREIGN KEY (siswa_id) REFERENCES siswa(id)
);
CREATE TABLE presensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT,
    tanggal DATE,
    status ENUM('hadir', 'tidak hadir', 'izin'),
    guru VARCHAR(50),
    FOREIGN KEY (siswa_id) REFERENCES siswa(id)
);
INSERT INTO users (username, password, role) VALUES 
('guru1', '$2y$10$examplehashedpassword', 'guru'),
('orangtua1', '$2y$10$examplehashedpassword', 'orangtua');
INSERT INTO siswa (nama, orangtua, kelas) VALUES 
('Siswa1', 'orangtua1', 'Kelas 1'),
('Siswa2', 'orangtua1', 'Kelas 2');