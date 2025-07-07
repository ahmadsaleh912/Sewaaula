<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['penyewa'])) {
    header("Location: ../index.php");
    exit;
}

$id_penyewa = $_SESSION['penyewa']['id'];

// Ambil daftar pesanan aktif yang bisa dibatalkan
$query = mysqli_query($conn, "SELECT * FROM penyewaan 
    WHERE id_penyewa = '$id_penyewa' AND status = 'disetujui'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ajukan Pembatalan</title>
  <link rel="stylesheet" href="../css/penyewa.css">
</head>
<body>
  <?php include '../admin/header.php' ;?>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>Ajukan Pembatalan Penyewaan</h2>

      <?php if (mysqli_num_rows($query) === 0): ?>
        <p>Tidak ada pesanan aktif yang dapat dibatalkan.</p>
      <?php else: ?>
        <div class="form-container">
        <form method="POST" action="../proses/pembatalan.php">
          <label>Pilih Pesanan</label>
          <select name="id_penyewaan" required>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
              <option value="<?= $row['id'] ?>">
                <?= htmlspecialchars($row['nama_kegiatan']) ?> - <?= date('d M Y', strtotime($row['tanggal_pakai'])) ?>
              </option>
            <?php endwhile; ?>
          </select>

          <label>Alasan Pembatalan</label>
          <textarea name="alasan_batal" required></textarea>

          <br><br>
          <div class="form-actions">
           <button type="submit">Ajukan Sewa</button>
           <a href="../dashboard/penyewa.php" class="btn-cancel">Cancel</a>
          </div>
        </form>
              </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
