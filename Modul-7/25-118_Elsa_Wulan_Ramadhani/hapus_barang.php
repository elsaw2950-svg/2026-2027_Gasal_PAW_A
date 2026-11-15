<?php
require "koneksi.php";
$id=filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT);
if (!$id) { die("ID barang tidak valid."); }
$q=mysqli_prepare($koneksi,"SELECT COUNT(*) AS jumlah FROM transaksi_detail WHERE barang_id=?");
mysqli_stmt_bind_param($q,"i",$id); mysqli_stmt_execute($q);
$hasil=mysqli_fetch_assoc(mysqli_stmt_get_result($q));
if ((int)$hasil["jumlah"]>0) {
    header("Location: barang.php?pesan=terpakai"); exit;
}
$q=mysqli_prepare($koneksi,"DELETE FROM barang WHERE id=?");
mysqli_stmt_bind_param($q,"i",$id);
if (mysqli_stmt_execute($q) && mysqli_stmt_affected_rows($q)>0) {
    header("Location: barang.php?pesan=hapus"); exit;
}
echo "Barang tidak ditemukan atau gagal dihapus. <a href='barang.php'>Kembali</a>";
