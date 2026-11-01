<?php
require_once "koneksi.php";
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { header("Location: supplier.php"); exit; }

$stmt = mysqli_prepare($koneksi, "DELETE FROM supplier WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
if (mysqli_stmt_execute($stmt)) {
    header("Location: supplier.php?pesan=" . urlencode("Data supplier berhasil dihapus"));
    exit;
}
header("Location: supplier.php?pesan=" . urlencode("Data tidak dapat dihapus karena masih digunakan oleh tabel barang"));
exit;
?>
