<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

// Jika admin menyetujui pembatalan
if (isset($_GET['setujui'])) {
    $id = $_GET['setujui'];
    mysqli_query($conn, "UPDATE penyewaan SET status = 'batal' WHERE id = '$id'");
    header("Location: pembatalan.php");
    exit;
}

// Ambil daftar permintaan pembatalan
$query = mysqli_query($conn, "SELECT p.nama, p.prodi, s.* FROM penyewaan s
    JOIN penyewa p ON s.id_penyewa = p.id 
    WHERE s.status = 'diajukan_batal' ORDER BY s.tanggal_pakai ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Permintaan Pembatalan</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <?php include 'header.php' ;?>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>❌ Permintaan Pembatalan</h2>

      <?php if (mysqli_num_rows($query) === 0): ?>
        <p>Tidak ada permintaan pembatalan saat ini.</p>
      <?php else: ?>
        <table>
          <tr>
            <th>Nama Penyewa</th>
            <th>Prodi</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Kapasitas</th>
            <th>Alasan Pembatalan</th>
            <th>Aksi</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['prodi']) ?></td>
              <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
              <td><?= date('d M Y', strtotime($row['tanggal_pakai'])) ?></td>
              <td><?= $row['kapasitas'] ?></td>
              <td><?= htmlspecialchars($row['alasan_batal']) ?></td>
              <td>
                <a href="?setujui=<?= $row['id'] ?>" onclick="return confirm('Setujui pembatalan ini?')">✅ Setujui</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </table>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
