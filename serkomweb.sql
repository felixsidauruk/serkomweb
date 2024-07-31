CREATE DATABASE hotel_booking;

USE hotel_booking;

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pemesan VARCHAR(255),
    nomor_identitas VARCHAR(16),
    jenis_kelamin VARCHAR(50),
    tipe_kamar VARCHAR(50),
    durasi_menginap INT,
    diskon VARCHAR(10),
    total_bayar FLOAT
);
