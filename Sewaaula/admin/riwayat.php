<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';

// Ambil seluruh data penyewaan dengan filter
$query = mysqli_query($conn, "SELECT p.nama, p.nim, p.fakultas, s.* 
    FROM penyewaan s 
    JOIN penyewa p ON s.id_penyewa = p.id 
    WHERE p.nama LIKE '%$keyword%' 
    OR s.nama_kegiatan LIKE '%$keyword%' 
    ORDER BY s.tanggal_pakai DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Penyewaan</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <?php include 'header.php' ;?>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>📜 Riwayat Penyewaan Aula</h2>

      <form method="GET" style="margin-bottom: 15px;">
        <input type="text" name="cari" placeholder="Cari nama atau kegiatan..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Cari</button>
      </form>

      <table>
        <tr>
          <th>Nama Penyewa</th>
          <th>Fakultas</th>
          <th>Nama Kegiatan</th>
          <th>Tanggal</th>
          <th>Kapasitas</th>
          <th>Status</th>
          <th>Alasan (jika ada)</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['fakultas']) ?></td>
          <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
          <td><?= date('d M Y', strtotime($row['tanggal_pakai'])) ?></td>
          <td><?= $row['kapasitas'] ?></td>
          <td><?= ucfirst($row['status']) ?></td>
          <td>
            <?php
              if ($row['status'] === 'ditolak') {
                echo htmlspecialchars($row['alasan_ditolak']);
              } elseif ($row['status'] === 'diajukan_batal' || $row['status'] === 'batal') {
                echo htmlspecialchars($row['alasan_batal']);
              } else {
                echo '-';
              }
            ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </div>
</body>
</html>
