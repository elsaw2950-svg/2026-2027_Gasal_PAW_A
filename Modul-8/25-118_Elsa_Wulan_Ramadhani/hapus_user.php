<?php
// HAPUS USER (POST). Akun yang sedang login tidak boleh dihapus.
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: user.php"); exit; }

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
try {
    if (!$id) { throw new Exception("ID user tidak valid."); }
    if ($id === (int) $_SESSION['id_user']) {
        throw new Exception("Anda tidak dapat menghapus akun yang sedang digunakan.");
    }
    $q = mysqli_prepare($koneksi, "DELETE FROM `user` WHERE id_user=?");
    mysqli_stmt_bind_param($q, "i", $id);
    mysqli_stmt_execute($q);
    if (mysqli_stmt_affected_rows($q) > 0) {
        set_flash("Data user berhasil dihapus.");
    } else {
        set_flash("Data user tidak ditemukan.", 'err');
    }
} catch (mysqli_sql_exception $ex) {
    set_flash("Terjadi kesalahan database.", 'err');
} catch (Exception $ex) {
    set_flash($ex->getMessage(), 'err');
}
header("Location: user.php");
exit;
