<?php
include 'includes/konfig.php';

$nama  = 'Admin';
$email = 'aku@aku.com';
$pass  = 'admin1234'; // ubah sesuai kebutuhan

// Enkripsi password
$hash = password_hash($pass, PASSWORD_DEFAULT);

// Cek apakah admin dengan email ini sudah ada
$cek = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "Admin sudah terdaftar.";
} else {
    $simpan = mysqli_query($conn, "INSERT INTO admin (nama, email, password) VALUES ('$nama', '$email', '$hash')");
    echo $simpan ? "Admin berhasil ditambahkan!" : "Gagal: " . mysqli_error($conn);
}
?>
