<?php
// Memulai session pengguna
session_start();

// Menghubungkan ke database
include '../includes/konfig.php';

// Jika penyewa belum login, arahkan ke halaman login
if (!isset($_SESSION['penyewa'])) {
    header("Location: ../index.php");
    exit;
}

// Ambil ID penyewa dari session
$id_penyewa = $_SESSION['penyewa']['id'];

// Ambil tanggal hari ini untuk pengecekan otomatis
$today = date('Y-m-d');

// Otomatis ubah status ke 'selesai' jika tanggal_pakai sudah lewat
mysqli_query($conn, "UPDATE penyewaan 
    SET status = 'selesai' 
    WHERE id_penyewa = '$id_penyewa' 
      AND status = 'disetujui' 
      AND tanggal_pakai < '$today'");

// Query untuk menampilkan pesanan yang masih aktif: 'pending' atau 'disetujui' saja
$query = mysqli_query($conn, "SELECT * FROM penyewaan 
    WHERE id_penyewa = '$id_penyewa' 
      AND status IN ('pending', 'disetujui') 
    ORDER BY tanggal_pakai DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan Saya</title>
  <!-- Hubungkan file CSS penyewa -->
  <link rel="stylesheet" href="../css/penyewa.css">
</head>
<body>
  <!-- Header aplikasi (admin bisa tetap pakai ini) -->
  <?php include '../admin/header.php'; ?>

  <div class="container">
    <!-- Sidebar penyewa -->
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>📋 Pesanan Saya</h2>

      <!-- Tabel daftar pesanan -->
      <table class="table-pesanan">
        <thead>
          <tr>
            <th>Nama Kegiatan</th>
            <th>Tanggal Pemakaian</th>
            <th>Kapasitas</th>
            <th>Status</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($query)) : ?>
          <tr>
            <!-- Menampilkan nama kegiatan -->
            <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>

            <!-- Menampilkan tanggal kegiatan -->
            <td><?= date('d M Y', strtotime($row['tanggal_pakai'])) ?></td>

            <!-- Menampilkan kapasitas peserta -->
            <td><?= $row['kapasitas'] ?></td>

            <!-- Menampilkan status penyewaan (pending/disetujui) -->
            <td><?= ucfirst($row['status']) ?></td>

            <!-- Menampilkan alasan ditolak, jika statusnya 'ditolak' -->
            <td><?= $row['status'] === 'ditolak' ? htmlspecialchars($row['alasan_ditolak']) : '-' ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
