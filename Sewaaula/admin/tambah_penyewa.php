<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nim      = $_POST['nim'];
    $prodi    = $_POST['prodi'];
    $fakultas = $_POST['fakultas'];

    // Cek duplikat email
    $cek = mysqli_query($conn, "SELECT * FROM penyewa WHERE email = '$email'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "❗ Email sudah terdaftar.";
    } else {
        $simpan = mysqli_query($conn, "INSERT INTO penyewa (nama, email, password, nim, prodi, fakultas)
                    VALUES ('$nama', '$email', '$password', '$nim', '$prodi', '$fakultas')");
        if ($simpan) {
            header("Location: kelola_pengguna.php");
            exit;
        } else {
            $pesan = "❗ Gagal menambahkan penyewa.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Penyewa</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <?php include 'header.php' ;?>
  <div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="content">
      <h2>➕ Tambah Penyewa Baru</h2>
      
      <?php if ($pesan): ?>
        <p style="color:red;"><?= $pesan ?></p>
      <?php endif; ?>

      <form method="POST">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="text" name="password" required>

        <label>NIM</label>
        <input type="text" name="nim" required>

        <label>Program Studi</label>
        <input type="text" name="prodi" required>

        <label>Fakultas</label>
        <input type="text" name="fakultas" required>

        <br><br>
        <button type="submit">Simpan</button> 
        <a href="kelola_pengguna.php">← Batal</a>
      </form>
    </div>
  </div>
</body>
</html>
