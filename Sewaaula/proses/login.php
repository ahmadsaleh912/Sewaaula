<?php
session_start();
include '../includes/konfig.php';

$email = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo "<script>alert('Email dan password wajib diisi.'); window.location.href = '../index.php';</script>";
    exit;
}

// Cek admin
$stmtAdmin = mysqli_prepare($conn, "SELECT * FROM admin WHERE email = ?");
mysqli_stmt_bind_param($stmtAdmin, "s", $email);
mysqli_stmt_execute($stmtAdmin);
$resultAdmin = mysqli_stmt_get_result($stmtAdmin);


if ($resultAdmin && mysqli_num_rows($resultAdmin) === 1) {
    $admin = mysqli_fetch_assoc($resultAdmin);
    if (password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin;
        header("Location: ../admin/admin.php");
        exit;
    }
}

// Cek penyewa jika bukan admin
$stmtUser = mysqli_prepare($conn, "SELECT * FROM penyewa WHERE email = ?");
mysqli_stmt_bind_param($stmtUser, "s", $email);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);

if ($resultUser && mysqli_num_rows($resultUser) === 1) {
    $penyewa = mysqli_fetch_assoc($resultUser);
    if (password_verify($password, $penyewa['password'])) {
        $_SESSION['penyewa'] = $penyewa;
        header("Location: ../dashboard/penyewa.php");
        exit;
    }
}

// Gagal login
echo "<script>alert('Login gagal. Email atau password salah.'); window.location.href = '../index.php';</script>";
exit;
?>
