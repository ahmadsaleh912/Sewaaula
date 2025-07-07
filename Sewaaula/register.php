<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi Penyewa</title>

  <!-- Memuat file CSS eksternal untuk styling -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- Kontainer utama form registrasi -->
  <div class="register-container">
    <h2>Form Registrasi Penyewa</h2>

    <!-- Formulir yang dikirim ke file PHP proses (pakai method POST agar data tidak tampil di URL) -->
    <form action="proses/register.php" method="POST">

      <!-- Input untuk nama lengkap -->
      <label>Nama Lengkap</label>
      <input type="text" name="nama" required>

      <!-- Input untuk NIM (nomor induk mahasiswa) -->
      <label>NIM</label>
      <input type="text" name="nim" required>

      <!-- Input untuk Fakultas -->
      <label>Fakultas</label>
      <input type="text" name="fakultas" required>

      <!-- Input untuk Program Studi -->
      <label>Program Studi</label>
      <input type="text" name="prodi" required>

      <!-- Input untuk Email -->
      <label>Email</label>
      <input type="email" name="email" required>

      <!-- Input untuk Password -->
      <label>Password</label>
      <input type="password" name="password" required>

      <!-- Tombol submit untuk mengirim data -->
      <button type="submit">Daftar</button>
    </form>

    <!-- Tautan kembali ke halaman login -->
    <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
  </div>

</body>
</html>
