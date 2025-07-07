<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

// Ambil nama admin
$nama_admin = $_SESSION['admin']['nama'];

// Proses aksi: Setujui
if (isset($_GET['setujui'])) {
    $id = $_GET['setujui'];
    mysqli_query($conn, "UPDATE penyewaan SET status = 'disetujui' WHERE id = '$id'");
    header("Location: pengajuan.php");
    exit;
}

// Proses aksi: Tolak
if (isset($_POST['tolak'])) {
    $id = $_POST['id_penyewaan'];
    $alasan = $_POST['alasan_ditolak'];
    mysqli_query($conn, "UPDATE penyewaan SET status = 'ditolak', alasan_ditolak = '$alasan' WHERE id = '$id'");
    header("Location: pengajuan.php");
    exit;
}

// Ambil semua penyewaan dengan status pending
$query = mysqli_query($conn, "SELECT p.nama, p.prodi, s.* 
    FROM penyewaan s 
    JOIN penyewa p ON s.id_penyewa = p.id 
    WHERE s.status = 'pending' 
    ORDER BY s.created_at ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengajuan Pesanan</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <?php include 'header.php' ;?>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>📥 Pengajuan Pesanan Masuk</h2>

      <?php if (mysqli_num_rows($query) === 0): ?>
        <p>Tidak ada pengajuan baru saat ini.</p>
      <?php else: ?>
        <table>
          <tr>
            <th>Nama Penyewa</th>
            <th>Program Studi</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Kapasitas</th>
            <th>Aksi</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($query)): ?>
          <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['prodi']) ?></td>
            <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
            <td><?= date('d M Y', strtotime($row['tanggal_pakai'])) ?></td>
            <td><?= $row['kapasitas'] ?></td>
            <td>
              <a href="?setujui=<?= $row['id'] ?>" onclick="return confirm('Setujui permintaan ini?')">✅ Setujui</a>
              <form method="POST" style="margin-top:10px;">
                <input type="hidden" name="id_penyewaan" value="<?= $row['id'] ?>">
                <textarea name="alasan_ditolak" placeholder="Alasan penolakan..." required></textarea>
                <button type="submit" name="tolak">❌ Tolak</button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </table>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
