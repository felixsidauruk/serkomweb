<?php
$servername = "localhost";
$username = "root";  // Ubah sesuai dengan username MySQL Anda
$password = "";      // Ubah sesuai dengan password MySQL Anda
$dbname = "hotel_booking";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$nama_pemesan = $_POST['nama_pemesan'];
$nomor_identitas = $_POST['nomor_identitas'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tipe_kamar = $_POST['tipe_kamar'];
$durasi_menginap = intval($_POST['durasi_menginap']);
$diskon = $durasi_menginap > 3 ? "10%" : "0%";
$total_bayar = floatval($_POST['total_bayar']);

$sql = "INSERT INTO bookings (nama_pemesan, nomor_identitas, jenis_kelamin, tipe_kamar, durasi_menginap, diskon, total_bayar)
        VALUES ('$nama_pemesan', '$nomor_identitas', '$jenis_kelamin', '$tipe_kamar', $durasi_menginap, '$diskon', $total_bayar)";

if ($conn->query($sql) === TRUE) {
    // Redirect ke show.php dengan query string untuk menunjukkan status sukses
    header("Location: show.php?status=success");
} else {
    // Redirect ke show.php dengan query string untuk menunjukkan status error
    header("Location: show.php?status=error");
}

$conn->close();
?>
