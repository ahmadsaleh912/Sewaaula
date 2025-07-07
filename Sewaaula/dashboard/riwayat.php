<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['penyewa'])) {
    header("Location: ../index.php");
    exit;
}

$id_penyewa = $_SESSION['penyewa']['id'];
$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';

// Ambil riwayat penyewaan penyewa ini
$query = mysqli_query($conn, "SELECT * FROM penyewaan 
    WHERE id_penyewa = '$id_penyewa' 
    AND status IN ('disetujui','ditolak','batal','diajukan_batal')
    AND nama_kegiatan LIKE '%$keyword%' 
    ORDER BY tanggal_pakai DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Penyewaan</title>
  <link rel="stylesheet" href="../css/penyewa.css">
</head>
<body>
  <?php include '../admin/header.php'; ?>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>Riwayat Pemesanan Aula</h2>

      <form method="GET" class="form-cari">
        <input type="text" name="cari" placeholder="Cari kegiatan..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Cari</button>
      </form>

      <table class="table-riwayat">
        <thead>
          <tr>
            <th>Nama Kegiatan</th>
            <th>Tanggal Pakai</th>
            <th>Kapasitas</th>
            <th>Status</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
          <tr>
            <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
            <td><?= date('d M Y', strtotime($row['tanggal_pakai'])) ?></td>
            <td><?= $row['kapasitas'] ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td>
              <?php
                if ($row['status'] == 'ditolak') {
                  echo htmlspecialchars($row['alasan_ditolak']);
                } else if ($row['status'] == 'diajukan_batal' || $row['status'] == 'batal') {
                  echo htmlspecialchars($row['alasan_batal']);
                } else {
                  echo '-';
                }
              ?>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
