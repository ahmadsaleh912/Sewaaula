<?php
session_start();
include '../includes/konfig.php';

if (!isset($_SESSION['penyewa'])) {
    header("Location: ../index.php");
    exit;
}

$id_penyewa   = $_SESSION['penyewa']['id'];
$id_penyewaan = $_POST['id_penyewaan'];
$alasan       = $_POST['alasan_batal'] ?? '';

$update = mysqli_query($conn, "UPDATE penyewaan 
    SET status = 'diajukan_batal', alasan_batal = '$alasan' 
    WHERE id = '$id_penyewaan' AND id_penyewa = '$id_penyewa'");

if ($update) {
    echo "<script>
        alert('Permintaan pembatalan diajukan.');
        window.location.href = '../dashboard/pesanan_saya.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal mengajukan pembatalan.');
        window.location.href = '../dashboard/form_pembatalan.php';
    </script>";
}
?>
