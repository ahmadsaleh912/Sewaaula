<?php
// Mulai session untuk nantinya bisa menyimpan data login
session_start();

// Panggil file koneksi database
include '../includes/konfig.php';

// Ambil data dari form registrasi menggunakan method POST
$nama     = $_POST['nama'];
$nim      = $_POST['nim'];
$fakultas = $_POST['fakultas'];
$prodi    = $_POST['prodi'];
$email    = $_POST['email'];
$password = $_POST['password'];

// Enkripsi password menggunakan hashing (supaya tidak disimpan dalam bentuk asli)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah email sudah terdaftar di database
$cek_email = mysqli_query($conn, "SELECT * FROM penyewa WHERE email = '$email'");
if (mysqli_num_rows($cek_email) > 0) {
    // Jika email sudah terdaftar, tampilkan pesan dan kembali ke halaman registrasi
    echo "<script>
        alert('Email sudah terdaftar, silakan gunakan email lain.');
        window.location.href = '../register.php';
    </script>";
    exit;
}

// Simpan data penyewa baru ke tabel 'penyewa'
$simpan = mysqli_query($conn, "INSERT INTO penyewa 
    (nama, nim, fakultas, prodi, email, password) 
    VALUES 
    ('$nama', '$nim', '$fakultas', '$prodi', '$email', '$hashed_password')");

// Jika penyimpanan berhasil
if ($simpan) {
    echo "<script>
        alert('Registrasi berhasil! Silakan login.');
        window.location.href = '../index.php';
    </script>";
} else {
    // Jika gagal menyimpan, tampilkan pesan error dari MySQL
    echo "<script>
        alert('Registrasi gagal: " . mysqli_error($conn) . "');
        window.location.href = '../register.php';
    </script>";
}
?>
