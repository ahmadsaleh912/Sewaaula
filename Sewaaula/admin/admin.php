<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

$nama_admin = $_SESSION['admin']['nama'];

$query_aktif = mysqli_query($conn, "SELECT p.nama, p.prodi, s.* 
    FROM penyewaan s 
    JOIN penyewa p ON s.id_penyewa = p.id 
    WHERE s.status = 'disetujui' 
    ORDER BY s.tanggal_pakai ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <?php include 'header.php'; ?>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>Selamat datang, <?= htmlspecialchars($nama_admin) ?> 👋</h2>

      <h3>Daftar Pesanan yang Sedang Aktif</h3>
      <?php if (mysqli_num_rows($query_aktif) === 0): ?>
        <p>Tidak ada pesanan aktif saat ini.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Nama Penyewa</th>
              <th>Prodi</th>
              <th>Nama Kegiatan</th>
              <th>Tanggal</th>
              <th>Kapasitas</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($query_aktif)): ?>
              <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['prodi']) ?></td>
                <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
                <td><?= date('d M Y', strtotime($row['tanggal_pakai'])) ?></td>
                <td><?= $row['kapasitas'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
