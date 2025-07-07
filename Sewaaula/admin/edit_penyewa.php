<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'] ?? '';
if (!$id) {
    header("Location: kelola_pengguna.php");
    exit;
}

$cek = mysqli_query($conn, "SELECT * FROM penyewa WHERE id = '$id'");
$data = mysqli_fetch_assoc($cek);

if (!$data) {
    echo "Pengguna tidak ditemukan.";
    exit;
}

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $nim      = $_POST['nim'];
    $prodi    = $_POST['prodi'];
    $fakultas = $_POST['fakultas'];

    $update = mysqli_query($conn, "UPDATE penyewa 
        SET nama='$nama', email='$email', nim='$nim', prodi='$prodi', fakultas='$fakultas' 
        WHERE id = '$id'");

    if ($update) {
        header("Location: kelola_pengguna.php");
        exit;
    } else {
        $pesan = "❗ Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Penyewa</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>✏️ Edit Data Penyewa</h2>

      <?php if ($pesan): ?>
        <p style="color:red;"><?= $pesan ?></p>
      <?php endif; ?>

      <form method="POST">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>

        <label>NIM</label>
        <input type="text" name="nim" value="<?= htmlspecialchars($data['nim']) ?>" required>

        <label>Program Studi</label>
        <input type="text" name="prodi" value="<?= htmlspecialchars($data['prodi']) ?>" required>

        <label>Fakultas</label>
        <input type="text" name="fakultas" value="<?= htmlspecialchars($data['fakultas']) ?>" required>

        <br><br>
        <button type="submit">Simpan Perubahan</button>
        <a href="kelola_pengguna.php">← Batal</a>
      </form>
    </div>
  </div>
</body>
</html>
