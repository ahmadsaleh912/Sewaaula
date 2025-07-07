<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'] ?? '';
if (!$id) {
    header("Location: kelola_pengguna.php");
    exit;
}

// Hapus penyewa
$hapus = mysqli_query($conn, "DELETE FROM penyewa WHERE id = '$id'");
header("Location: kelola_pengguna.php");
exit;
?>
