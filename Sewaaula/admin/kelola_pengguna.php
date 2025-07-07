<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

// Cari pengguna (opsional)
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$query = mysqli_query($conn, "SELECT * FROM penyewa 
  WHERE nama LIKE '%$cari%' OR email LIKE '%$cari%' OR nim LIKE '%$cari%' 
  ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pengguna</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <?php include 'header.php' ;?>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>👥 Kelola Pengguna (Penyewa)</h2>

      <form method="GET" style="margin-bottom: 15px;">
        <input type="text" name="cari" placeholder="Cari nama / email / NIM..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit">Cari</button>
      </form>

      <p><a href="tambah_penyewa.php">➕ Tambah Penyewa Baru</a></p>

      <table>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>NIM</th>
          <th>Prodi</th>
          <th>Fakultas</th>
          <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['nim']) ?></td>
          <td><?= htmlspecialchars($row['prodi']) ?></td>
          <td><?= htmlspecialchars($row['fakultas']) ?></td>
          <td>
            <a href="edit_penyewa.php?id=<?= $row['id'] ?>">✏️ Edit</a> | 
            <a href="hapus_penyewa.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus penyewa ini?')">🗑️ Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </div>
</body>
</html>
