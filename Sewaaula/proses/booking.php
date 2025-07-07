<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['penyewa'])) {
    header("Location: ../index.php");
    exit;
}

$id_penyewa     = $_SESSION['penyewa']['id'];
$nama_kegiatan  = $_POST['nama_kegiatan'];
$tanggal_pakai  = $_POST['tanggal_pakai'];
$kapasitas      = $_POST['kapasitas'];

// Cek bentrok tanggal
$cek = mysqli_query($conn, "SELECT * FROM penyewaan 
    WHERE tanggal_pakai = '$tanggal_pakai' 
    AND status IN ('pending', 'disetujui')");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Tanggal sudah dipesan. Silakan pilih tanggal lain.');
        window.location.href = '../penyewa/form_sewa.php';
    </script>";
    exit;
}

// Simpan
$simpan = mysqli_query($conn, "INSERT INTO penyewaan 
    (id_penyewa, nama_kegiatan, tanggal_pakai, kapasitas, status) 
    VALUES ('$id_penyewa', '$nama_kegiatan', '$tanggal_pakai', '$kapasitas', 'pending')");

if ($simpan) {
    echo "<script>
        alert('Pengajuan berhasil dikirim. Silakan tunggu persetujuan admin.');
        window.location.href = '../dashboard/penyewa.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menyimpan data.');
        window.location.href = '../dashboard/form_sewa.php';
    </script>";
}
?>
