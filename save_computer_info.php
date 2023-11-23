<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Ambil data dari permintaan POST
$operatingSystem = $_POST['operatingSystem'];
$browser = $_POST['browser'];
// $ipAddress = $_POST['ipAddress'];

// Konfigurasi koneksi ke MySQL
$servername = "localhost";
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$dbname = "dispatcher"; // Ganti dengan nama database MySQL Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Persiapkan dan jalankan query SQL untuk menyimpan data
$query = "INSERT INTO computer_info (id,operating_system, browser, ip_address,access_time) VALUES ('','$operatingSystem', '$browser', NULL,NULL)";
if ($conn->query($query) === TRUE) {
    echo "Informasi berhasil disimpan ke database";
} else {
    echo "Gagal menyimpan informasi ke database: " . $conn->error;
}

// Tutup koneksi ke MySQL
$conn->close();
?>
