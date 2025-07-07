<?php
// konfig.php - Koneksi database penyewaan aula

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "penyewaan_aula";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
