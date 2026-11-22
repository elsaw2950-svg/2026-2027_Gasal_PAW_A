<?php
// PROSES SIMPAN SUPPLIER: aksi=tambah (INSERT) atau aksi=edit (UPDATE)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: supplier.php"); exit; }

$aksi = $_POST['aksi'] ?? '';
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nama = trim($_POST['nama'] ?? '');
$telp = trim($_POST['telp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');

$kembali = $aksi === 'edit' ? "edit_supplier.php?id=" . (int) $id : "tambah_supplier.php";

try {
    if (!in_array($aksi, ['tambah', 'edit'], true)) { throw new Exception("Aksi tidak valid."); }
    if ($aksi === 'edit' && !$id) { throw new Exception("ID supplier tidak valid."); }
    if ($nama === '') { throw new Exception("Nama supplier wajib diisi."); }
    if ($telp !== '' && !preg_match('/^[0-9]{1,12}$/', $telp)) {
        throw new Exception("Telp harus berupa angka (maksimal 12 digit).");
    }

    if ($aksi === 'tambah') {
        $q = mysqli_prepare($koneksi, "INSERT INTO supplier (nama,telp,alamat) VALUES (?,?,?)");
        mysqli_stmt_bind_param($q, "sss", $nama, $telp, $alamat);
        mysqli_stmt_execute($q);
        set_flash("Data supplier berhasil ditambahkan.");
    } else {
        $q = mysqli_prepare($koneksi, "UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
        mysqli_stmt_bind_param($q, "sssi", $nama, $telp, $alamat, $id);
        mysqli_stmt_execute($q);
        set_flash("Data supplier berhasil diubah.");
    }
    header("Location: supplier.php");
    exit;
} catch (mysqli_sql_exception $ex) {
    set_flash("Terjadi kesalahan database.", 'err');
} catch (Exception $ex) {
    set_flash($ex->getMessage(), 'err');
}
set_old($_POST);
header("Location: " . $kembali);
exit;
