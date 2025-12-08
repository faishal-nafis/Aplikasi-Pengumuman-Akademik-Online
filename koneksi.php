<?php
$host = "localhost";
$user = "root";     // Default user XAMPP
$pass = "";         // Default password XAMPP (kosong)
$db   = "db_pbl"; // Nama database yang baru

// Melakukan koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek jika koneksi gagal
if (!$koneksi) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>