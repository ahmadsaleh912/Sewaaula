<?php
session_start();
include '../includes/konfig.php';

// Cek login penyewa
if (!isset($_SESSION['penyewa'])) {
    header("Location: ../index.php");
    exit;
}

$penyewa = $_SESSION['penyewa'];
$nama = $penyewa['nama'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Penyewa</title>
  <link rel="stylesheet" href="../css/penyewa.css">
</head>
<body>
  <?php include '../admin/header.php' ;?>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>Selamat datang, <?= htmlspecialchars($nama) ?>!</h2>
      <p>Ini adalah beranda penyewa aula Anda. Gunakan menu di kiri untuk navigasi.</p>
      <!-- Konten lainnya -->
    </div>
  </div>
</body>
</html>
