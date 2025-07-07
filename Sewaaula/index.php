<?php
session_start();
if (isset($_SESSION['penyewa'])) {
    header("Location: dashboard/penyewa.php");
}
if (isset($_SESSION['admin'])) {
    header("Location: admin/admin.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Penyewaan Aula</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="login-container">
    <h2>Login Sistem Penyewaan Aula</h2>
    <form action="proses/login.php" method="POST">
      <label>Email</label>
      <input type="email" name="email" required>
      
      <label>Password</label>
      <div class="password-container">
        <input type="password" id="password" name="password" required>
        <span class="password-toggle" onclick="togglePassword()">👁️</span>
      </div>

      <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Registrasi di sini</a></p>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      passwordInput.type = (passwordInput.type === "password") ? "text" : "password";
    }
  </script>
</body>
</html>
