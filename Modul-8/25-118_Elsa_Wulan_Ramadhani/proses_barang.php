<?php
// PROSES SIMPAN BARANG: aksi=tambah (INSERT) atau aksi=edit (UPDATE)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: barang.php"); exit; }

$aksi = $_POST['aksi'] ?? '';
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$kode = trim($_POST['kode_barang'] ?? '');
$nama = trim($_POST['nama_barang'] ?? '');
$harga = filter_input(INPUT_POST, 'harga', FILTER_VALIDATE_INT);
$stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
$supplier_id = filter_input(INPUT_POST, 'supplier_id', FILTER_VALIDATE_INT);

// Halaman form asal, dipakai saat validasi gagal
$kembali = $aksi === 'edit' ? "edit_barang.php?id=" . (int) $id : "tambah_barang.php";

try {
    if (!in_array($aksi, ['tambah', 'edit'], true)) { throw new Exception("Aksi tidak valid."); }
    if ($aksi === 'edit' && !$id) { throw new Exception("ID barang tidak valid."); }
    if ($kode === '' || $nama === '' || !$supplier_id
        || $harga === false || $harga === null || $harga < 0
        || $stok === false || $stok === null || $stok < 0) {
        throw new Exception("Semua field wajib diisi dengan benar.");
    }

    if ($aksi === 'tambah') {
        $q = mysqli_prepare($koneksi, "INSERT INTO barang (kode_barang,nama_barang,harga,stok,supplier_id) VALUES (?,?,?,?,?)");
        mysqli_stmt_bind_param($q, "ssiii", $kode, $nama, $harga, $stok, $supplier_id);
        mysqli_stmt_execute($q);
        set_flash("Data barang berhasil ditambahkan.");
    } else {
        $q = mysqli_prepare($koneksi, "UPDATE barang SET kode_barang=?, nama_barang=?, harga=?, stok=?, supplier_id=? WHERE id=?");
        mysqli_stmt_bind_param($q, "ssiiii", $kode, $nama, $harga, $stok, $supplier_id, $id);
        mysqli_stmt_execute($q);
        set_flash("Data barang berhasil diubah.");
    }
    header("Location: barang.php");
    exit;
} catch (mysqli_sql_exception $ex) {
    set_flash($ex->getCode() == 1062 ? "Kode barang sudah digunakan." : "Terjadi kesalahan database.", 'err');
} catch (Exception $ex) {
    set_flash($ex->getMessage(), 'err');
}
set_old($_POST);
header("Location: " . $kembali);
exit;
