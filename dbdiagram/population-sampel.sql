-- ======================================================
-- SISTEM DATABASE POPULASI KANDANG AYAM (VERSI SEDERHANA)
-- TANPA PERHITUNGAN / TANPA PRODUCTION STANDARD
-- HANYA ATRIBUT & RELASI
-- ======================================================

-- 1. DROP TABLE JIKA ADA (AGAR CLEAN SAAT IMPORT)
DROP TABLE IF EXISTS population_log;
DROP TABLE IF EXISTS pipe;
DROP TABLE IF EXISTS flock;
DROP TABLE IF EXISTS kandang;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

-- ======================================================
-- 2. ROLE USER
-- ======================================================
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO roles (name) VALUES
('Manager Production'),
('SPV Kandang'),
('Petugas Kandang'),
('Dokter Hewan');

-- ======================================================
-- 3. USER
-- ======================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255) NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- ======================================================
-- 4. KANDANG
-- ======================================================
CREATE TABLE kandang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255)
);

-- ======================================================
-- 5. FLOCK
-- ======================================================
CREATE TABLE flock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kandang_id INT NOT NULL,
    flock_name VARCHAR(100) NOT NULL,
    date_in DATE,
    initial_population INT NOT NULL,
    FOREIGN KEY (kandang_id) REFERENCES kandang(id)
);

-- ======================================================
-- 6. PIPE (BARIS DALAM FLOCK)
-- ======================================================
CREATE TABLE pipe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flock_id INT NOT NULL,
    pipe_name VARCHAR(100) NOT NULL,
    initial_population INT NOT NULL,
    FOREIGN KEY (flock_id) REFERENCES flock(id)
);

-- ======================================================
-- 7. LOG POPULASI HARIAN (SEKARANG TANPA PERHITUNGAN)
-- ======================================================
DROP TABLE IF EXISTS population_log;

CREATE TABLE population_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pipe_id INT NOT NULL,
    log_date DATE NOT NULL,

    died_daily INT DEFAULT 0,      -- ayam mati hari ini
    culled_daily INT DEFAULT 0,    -- ayam afkir hari ini

    died_total INT DEFAULT 0,      -- akumulasi mati (DIINPUT / DIUPDATE DARI APPLIKASI)
    culled_total INT DEFAULT 0,    -- akumulasi afkir (DIINPUT / DIUPDATE DARI APPLIKASI)

    mortality_rate DECIMAL(5,2),   -- persentase mati (penampung perhitungan)
    cull_rate DECIMAL(5,2),        -- persentase afkir (penampung perhitungan)

    healthy_daily INT DEFAULT 0,   -- ayam sehat tersisa hari ini (juga diinput manual / hasil hitung aplikasi)

    recorded_by INT NOT NULL,      -- user pencatat

    FOREIGN KEY (pipe_id) REFERENCES pipe(id),
    FOREIGN KEY (recorded_by) REFERENCES users(id)
);
