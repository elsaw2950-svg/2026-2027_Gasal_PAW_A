<?php
// HAPUS PELANGGAN (POST). Pelanggan yang sudah punya transaksi ditolak oleh foreign key.
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: pelanggan.php"); exit; }

$id = trim($_POST['id'] ?? '');
try {
    if ($id === '') { throw new Exception("ID pelanggan tidak valid."); }
    $q = mysqli_prepare($koneksi, "DELETE FROM pelanggan WHERE id=?");
    mysqli_stmt_bind_param($q, "s", $id);
    mysqli_stmt_execute($q);
    if (mysqli_stmt_affected_rows($q) > 0) {
        set_flash("Data pelanggan berhasil dihapus.");
    } else {
        set_flash("Data pelanggan tidak ditemukan.", 'err');
    }
} catch (mysqli_sql_exception $ex) {
    if ($ex->getCode() == 1451) {
        set_flash("Pelanggan tidak dapat dihapus karena masih digunakan pada transaksi.", 'err');
    } else {
        set_flash("Terjadi kesalahan database.", 'err');
    }
} catch (Exception $ex) {
    set_flash($ex->getMessage(), 'err');
}
header("Location: pelanggan.php");
exit;
