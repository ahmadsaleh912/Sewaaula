<?php
// Hitung notifikasi pengajuan pesanan & permintaan pembatalan
$notif_pengajuan = mysqli_query($conn, "SELECT COUNT(*) as total FROM penyewaan WHERE status = 'pending'");
$jumlah_pengajuan = mysqli_fetch_assoc($notif_pengajuan)['total'];

$notif_batal = mysqli_query($conn, "SELECT COUNT(*) as total FROM penyewaan WHERE status = 'diajukan_batal'");
$jumlah_batal = mysqli_fetch_assoc($notif_batal)['total'];

// Fungsi untuk tampilkan badge kecil
function badge($jumlah) {
    return $jumlah > 0 ? "<span style='background:red;color:white;padding:1px 6px;border-radius:12px;font-size:12px;margin-left:5px;'>$jumlah</span>" : "";
}
?>

<div class="sidebar">
  <h3>Admin Menu</h3>
  <ul>
    <li><a href="admin.php">🏠 Beranda</a></li>
    <li>
      <a href="pengajuan.php">📥 Pengajuan Pesanan <?= badge($jumlah_pengajuan) ?></a>
    </li>
    <li>
      <a href="pembatalan.php">❌ Permintaan Pembatalan <?= badge($jumlah_batal) ?></a>
    </li>
    <li><a href="riwayat.php">📜 Riwayat Penyewaan</a></li>
    <li><a href="kelola_pengguna.php">👥 Kelola Pengguna</a></li>
    <li><a href="../logout.php">🔓 Logout</a></li>
  </ul>
</div>
