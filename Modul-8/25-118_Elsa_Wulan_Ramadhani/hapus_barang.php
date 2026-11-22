<?php
// HAPUS BARANG (POST). Barang yang sudah dipakai di transaksi_detail ditolak oleh foreign key.
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: barang.php"); exit; }

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
try {
    if (!$id) { throw new Exception("ID barang tidak valid."); }
    $q = mysqli_prepare($koneksi, "DELETE FROM barang WHERE id=?");
    mysqli_stmt_bind_param($q, "i", $id);
    mysqli_stmt_execute($q);
    if (mysqli_stmt_affected_rows($q) > 0) {
        set_flash("Data barang berhasil dihapus.");
    } else {
        set_flash("Data barang tidak ditemukan.", 'err');
    }
} catch (mysqli_sql_exception $ex) {
    if ($ex->getCode() == 1451) {
        set_flash("Barang tidak dapat dihapus karena masih digunakan pada transaksi.", 'err');
    } else {
        set_flash("Terjadi kesalahan database.", 'err');
    }
} catch (Exception $ex) {
    set_flash($ex->getMessage(), 'err');
}
header("Location: barang.php");
exit;
