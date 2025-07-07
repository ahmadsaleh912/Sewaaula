<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['penyewa'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Penyewaan Aula</title>
  <link rel="stylesheet" href="../css/penyewa.css">
</head>
<body>
  <?php include '../admin/header.php' ;?>
  <div class="form-container">
    <h2>Form Pengajuan Sewa Aula</h2>
    <form method="POST" action="../proses/booking.php">
      <label>Nama Kegiatan</label>
      <input type="text" name="nama_kegiatan" required>

      <label>Tanggal Pemakaian</label>
      <input type="date" name="tanggal_pakai" required>

      <label>Kapasitas (jumlah orang)</label>
      <input type="number" name="kapasitas" required min="1">

      <div class="form-actions">
        <button type="submit">Ajukan Sewa</button>
        <a href="../dashboard/penyewa.php" class="btn-cancel">Batal</a>
      </div>
    </form>
  </div>
</body>
</html>
